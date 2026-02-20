#!/usr/bin/env python3
"""
VPN Config Watcher Agent
- دانلود فایل‌ها از GitHub repo (path)
- استخراج خطوط حاوی vless:// یا trojan:// یا لینک‌های مشابه
- تست اتصال (TCP / TLS / simple WS upgrade)
- ارسال ایمیل گزارش با کانفیگ‌ها و وضعیت
"""
import os
import time
import socket
import ssl
import smtplib
import base64
import re
import logging
from datetime import datetime
from email.message import EmailMessage
from urllib.parse import urlparse, parse_qs, unquote
import requests
import yaml

LOG = logging.getLogger("vpn-agent")
LOG.setLevel(logging.INFO)
ch = logging.StreamHandler()
ch.setFormatter(logging.Formatter("%(asctime)s %(levelname)s %(message)s"))
LOG.addHandler(ch)

# Regex to find typical config URLs in files/text
CFG_URL_RE = re.compile(r"(vless://[^\s'\"<>]+|trojan://[^\s'\"<>]+)", re.IGNORECASE)

def load_cfg(path="config.yaml"):
    with open(path, "r", encoding="utf-8") as f:
        return yaml.safe_load(f)

def github_list_files(owner, repo, path="", branch=None, token=None):
    api = f"https://api.github.com/repos/{owner}/{repo}/contents/{path}"
    params = {}
    if branch:
        params["ref"] = branch
    headers = {"Accept": "application/vnd.github.v3+json"}
    if token:
        headers["Authorization"] = f"token {token}"
    r = requests.get(api, headers=headers, params=params, timeout=20)
    r.raise_for_status()
    return r.json()

def github_download_file(download_url, token=None):
    headers = {}
    if token:
        headers["Authorization"] = f"token {token}"
    r = requests.get(download_url, headers=headers, timeout=20)
    r.raise_for_status()
    return r.text

def find_config_urls(text):
    return CFG_URL_RE.findall(text or "")

def parse_host_port_from_url(url):
    # url may be vless://UUID@host:port?... or trojan://password@host:port?...
    try:
        p = urlparse(url)
        host = p.hostname
        port = p.port or (443 if p.scheme == "trojan" else None)
        qs = parse_qs(p.query)
        # detect ws/tls etc from query params too
        return {"scheme": p.scheme, "host": host, "port": port, "query": qs, "path": p.path or ""}
    except Exception:
        return None

def test_tcp(host, port, timeout=6):
    try:
        with socket.create_connection((host, port), timeout=timeout):
            return True, "tcp_ok"
    except Exception as e:
        return False, f"tcp_err: {e}"

def test_tls(host, port, sni=None, timeout=8):
    try:
        ctx = ssl.create_default_context()
        ctx.check_hostname = False
        ctx.verify_mode = ssl.CERT_NONE
        with socket.create_connection((host, port), timeout=timeout) as sock:
            with ctx.wrap_socket(sock, server_hostname=sni or host) as ss:
                # simple handshake success
                return True, f"tls_ok: {ss.version()}"
    except Exception as e:
        return False, f"tls_err: {e}"

def test_ws(host, port, path="/", use_tls=False, sni=None, timeout=8):
    # perform a minimal HTTP Upgrade request to check ws handshake
    try:
        # build socket
        sock = socket.create_connection((host, port), timeout=timeout)
        if use_tls:
            ctx = ssl.create_default_context()
            ctx.check_hostname = False
            ctx.verify_mode = ssl.CERT_NONE
            sock = ctx.wrap_socket(sock, server_hostname=sni or host)
        req = (
            f"GET {path or '/'} HTTP/1.1\r\n"
            f"Host: {host}\r\n"
            f"Upgrade: websocket\r\n"
            f"Connection: Upgrade\r\n"
            f"Sec-WebSocket-Version: 13\r\n"
            f"Sec-WebSocket-Key: {base64.b64encode(os.urandom(16)).decode()}\r\n"
            f"\r\n"
        )
        sock.settimeout(timeout)
        sock.sendall(req.encode())
        resp = sock.recv(1024).decode(errors="ignore")
        sock.close()
        if "101" in resp.splitlines()[0]:
            return True, "ws_ok_101"
        # some servers respond 200 or others; still consider presence of "upgrade" header
        if "upgrade" in resp.lower():
            return True, "ws_ok_upgrade"
        return False, f"ws_bad_resp: {resp.splitlines()[0] if resp else 'empty'}"
    except Exception as e:
        return False, f"ws_err: {e}"

def test_config_url(url, timeout_tcp=6):
    info = parse_host_port_from_url(url)
    if not info or not info.get("host") or not info.get("port"):
        return False, "parse_failed"
    scheme = info["scheme"].lower()
    host = info["host"]
    port = info["port"]
    qs = info["query"]
    # heuristics: check query params for tls/ws
    use_tls = False
    use_ws = False
    sni = None
    # common query names: security=tls or type=ws or net=ws or sni=...
    if "security" in qs and "tls" in [v.lower() for v in qs.get("security", [])]:
        use_tls = True
    if "type" in qs and "ws" in [v.lower() for v in qs.get("type", [])]:
        use_ws = True
    if "net" in qs and "ws" in [v.lower() for v in qs.get("net", [])]:
        use_ws = True
    if "sni" in qs:
        sni = qs.get("sni")[0]
    # also infer from scheme
    if scheme == "trojan":
        use_tls = True
    if use_ws:
        return test_ws(host, port, path=info.get("path") or "/", use_tls=use_tls, sni=sni or host)
    if use_tls:
        return test_tls(host, port, sni=sni or host, timeout=timeout_tcp+2)
    # fallback to TCP connect
    return test_tcp(host, port, timeout=timeout_tcp)

def send_email(smtp_cfg, subject, body, attachments=None):
    msg = EmailMessage()
    msg["From"] = smtp_cfg["from"]
    msg["To"] = smtp_cfg["to"]
    msg["Subject"] = subject
    msg.set_content(body)
    # attachments: list of (filename, text)
    for fname, text in (attachments or []):
        msg.add_attachment(text, maintype="text", subtype="plain", filename=fname)
    smtp_host = smtp_cfg["host"]
    smtp_port = smtp_cfg.get("port", 587)
    user = smtp_cfg.get("user")
    password = smtp_cfg.get("pass")
    use_ssl = smtp_cfg.get("ssl", False)
    LOG.info("Sending email to %s via %s:%s (ssl=%s)", smtp_cfg["to"], smtp_host, smtp_port, use_ssl)
    if use_ssl or smtp_port == 465:
        with smtplib.SMTP_SSL(smtp_host, smtp_port, timeout=20) as s:
            if user and password:
                s.login(user, password)
            s.send_message(msg)
    else:
        with smtplib.SMTP(smtp_host, smtp_port, timeout=20) as s:
            s.starttls()
            if user and password:
                s.login(user, password)
            s.send_message(msg)

def collect_configs_from_repo(gcfg):
    owner = gcfg["owner"]
    repo = gcfg["repo"]
    path = gcfg.get("path", "")
    branch = gcfg.get("branch")
    token = gcfg.get("token")
    LOG.info("Listing files in %s/%s/%s", owner, repo, path)
    items = github_list_files(owner, repo, path, branch, token)
    configs = []
    for it in items:
        if it["type"] == "file":
            fname = it["name"]
            # simple filter by extension or always try
            try:
                content = github_download_file(it["download_url"], token)
            except Exception as e:
                LOG.warning("Failed download %s: %s", it.get("path"), e)
                continue
            urls = find_config_urls(content)
            if urls:
                configs.append({"source": it["path"], "name": fname, "content": content, "urls": urls})
    return configs

def run_once(cfg):
    gcfg = cfg["github"]
    smtp_cfg = cfg["smtp"]
    timeout_tcp = cfg.get("timeout_tcp", 6)
    configs = collect_configs_from_repo(gcfg)
    LOG.info("Found %d candidate files with configs", len(configs))
    report_lines = []
    attachments = []
    any_down = False
    for c in configs:
        attachments.append((c["name"], c["content"]))
        report_lines.append(f"--- File: {c['source']} ({c['name']})")
        for u in c["urls"]:
            ok, info = test_config_url(u, timeout_tcp=timeout_tcp)
            status = "UP" if ok else "DOWN"
            report_lines.append(f"{status}: {u}\n  -> {info}")
            if not ok:
                any_down = True
    if not configs:
        report_lines.append("No configs found in repo/path.")
    subject = f"[VPN-Agent] report {datetime.utcnow().isoformat()}Z"
    body = "\n".join(report_lines)
    # Send always or only when any_down? Use config flag
    send_when_down = cfg.get("send_when_down", True)
    if (send_when_down and any_down) or (not send_when_down):
        send_email(smtp_cfg, subject, body, attachments=attachments)
        LOG.info("Email sent (any_down=%s)", any_down)
    else:
        LOG.info("No email sent (no down items and send_when_down=True)")

def main():
    cfg = load_cfg()
    interval = cfg.get("interval_sec", 300)
    LOG.info("Starting vpn-agent, interval=%s sec", interval)
    while True:
        try:
            run_once(cfg)
        except Exception as e:
            LOG.exception("Run failed: %s", e)
        time.sleep(interval)

if __name__ == "__main__":
    main()