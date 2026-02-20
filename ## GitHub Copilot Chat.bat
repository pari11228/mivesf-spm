## GitHub Copilot Chat

- Extension: 0.37.7 (prod)
- VS Code: 1.109.4 (c3a26841a84f20dfe0850d0a5a9bd01da4f003ea)
- OS: win32 10.0.19045 x64
- GitHub Account: pari11228

## Network

User Settings:
```json
  "http.noProxy": ["http://mivesf.ir/wp-admin"],
  "http.proxyKerberosServicePrincipal": "http://mivesf.ir/wp-admin",
  "http.systemCertificatesNode": true,
  "github.copilot.advanced.debug.useElectronFetcher": true,
  "github.copilot.advanced.debug.useNodeFetcher": false,
  "github.copilot.advanced.debug.useNodeFetchFetcher": true
```

Connecting to https://api.github.com:
- DNS ipv4 Lookup: 198.18.0.14 (66 ms)
- DNS ipv6 Lookup: fc00::e (5 ms)
- Proxy URL: None (2 ms)
- Electron fetch (configured): Error (4160 ms): Error: net::ERR_CONNECTION_CLOSED
	at SimpleURLLoaderWrapper.<anonymous> (node:electron/js2c/utility_init:2:10684)
	at SimpleURLLoaderWrapper.emit (node:events:519:28)
  [object Object]
  {"is_request_error":true,"network_process_crashed":false}
- Node.js https: Error (2080 ms): Error: Client network socket disconnected before secure TLS connection was established
	at TLSSocket.onConnectEnd (node:_tls_wrap:1732:19)
	at TLSSocket.emit (node:events:531:35)
	at endReadableNT (node:internal/streams/readable:1698:12)
	at process.processTicksAndRejections (node:internal/process/task_queues:90:21)
- Node.js fetch: Error (2071 ms): TypeError: fetch failed
	at node:internal/deps/undici/undici:14900:13
	at process.processTicksAndRejections (node:internal/process/task_queues:105:5)
	at async n._fetch (c:\Users\nejati\.vscode\extensions\github.copilot-chat-0.37.7\dist\extension.js:4862:26129)
	at async n.fetch (c:\Users\nejati\.vscode\extensions\github.copilot-chat-0.37.7\dist\extension.js:4862:25777)
	at async u (c:\Users\nejati\.vscode\extensions\github.copilot-chat-0.37.7\dist\extension.js:4894:190)
	at async CA.h (file:///c:/Users/nejati/AppData/Local/Programs/Microsoft%20VS%20Code/c3a26841a8/resources/app/out/vs/workbench/api/node/extensionHostProcess.js:116:41743)
  Error: Client network socket disconnected before secure TLS connection was established
  	at TLSSocket.onConnectEnd (node:_tls_wrap:1732:19)
  	at TLSSocket.emit (node:events:531:35)
  	at endReadableNT (node:internal/streams/readable:1698:12)
  	at process.processTicksAndRejections (node:internal/process/task_queues:90:21)

Connecting to https://api.githubcopilot.com/_ping:
- DNS ipv4 Lookup: 198.18.0.39 (4 ms)
- DNS ipv6 Lookup: fc00::29 (3 ms)
- Proxy URL: None (12 ms)
- Electron fetch (configured): Error (4059 ms): Error: net::ERR_CONNECTION_CLOSED
	at SimpleURLLoaderWrapper.<anonymous> (node:electron/js2c/utility_init:2:10684)
	at SimpleURLLoaderWrapper.emit (node:events:519:28)
  [object Object]
  {"is_request_error":true,"network_process_crashed":false}
- Node.js https: Error (2049 ms): Error: Client network socket disconnected before secure TLS connection was established
	at TLSSocket.onConnectEnd (node:_tls_wrap:1732:19)
	at TLSSocket.emit (node:events:531:35)
	at endReadableNT (node:internal/streams/readable:1698:12)
	at process.processTicksAndRejections (node:internal/process/task_queues:90:21)
- Node.js fetch: Error (2101 ms): TypeError: fetch failed
	at node:internal/deps/undici/undici:14900:13
	at process.processTicksAndRejections (node:internal/process/task_queues:105:5)
	at async n._fetch (c:\Users\nejati\.vscode\extensions\github.copilot-chat-0.37.7\dist\extension.js:4862:26129)
	at async n.fetch (c:\Users\nejati\.vscode\extensions\github.copilot-chat-0.37.7\dist\extension.js:4862:25777)
	at async u (c:\Users\nejati\.vscode\extensions\github.copilot-chat-0.37.7\dist\extension.js:4894:190)
	at async CA.h (file:///c:/Users/nejati/AppData/Local/Programs/Microsoft%20VS%20Code/c3a26841a8/resources/app/out/vs/workbench/api/node/extensionHostProcess.js:116:41743)
  Error: Client network socket disconnected before secure TLS connection was established
  	at TLSSocket.onConnectEnd (node:_tls_wrap:1732:19)
  	at TLSSocket.emit (node:events:531:35)
  	at endReadableNT (node:internal/streams/readable:1698:12)
  	at process.processTicksAndRejections (node:internal/process/task_queues:90:21)

Connecting to https://copilot-proxy.githubusercontent.com/_ping:
- DNS ipv4 Lookup: 198.18.0.46 (4 ms)
- DNS ipv6 Lookup: fc00::30 (5 ms)
- Proxy URL: None (11 ms)
- Electron fetch (configured): Error (4130 ms): Error: net::ERR_CONNECTION_CLOSED
	at SimpleURLLoaderWrapper.<anonymous> (node:electron/js2c/utility_init:2:10684)
	at SimpleURLLoaderWrapper.emit (node:events:519:28)
  [object Object]
  {"is_request_error":true,"network_process_crashed":false}
- Node.js https: Error (2047 ms): Error: Client network socket disconnected before secure TLS connection was established
	at TLSSocket.onConnectEnd (node:_tls_wrap:1732:19)
	at TLSSocket.emit (node:events:531:35)
	at endReadableNT (node:internal/streams/readable:1698:12)
	at process.processTicksAndRejections (node:internal/process/task_queues:90:21)
- Node.js fetch: Error (2105 ms): TypeError: fetch failed
	at node:internal/deps/undici/undici:14900:13
	at process.processTicksAndRejections (node:internal/process/task_queues:105:5)
	at async n._fetch (c:\Users\nejati\.vscode\extensions\github.copilot-chat-0.37.7\dist\extension.js:4862:26129)
	at async n.fetch (c:\Users\nejati\.vscode\extensions\github.copilot-chat-0.37.7\dist\extension.js:4862:25777)
	at async u (c:\Users\nejati\.vscode\extensions\github.copilot-chat-0.37.7\dist\extension.js:4894:190)
	at async CA.h (file:///c:/Users/nejati/AppData/Local/Programs/Microsoft%20VS%20Code/c3a26841a8/resources/app/out/vs/workbench/api/node/extensionHostProcess.js:116:41743)
  Error: Client network socket disconnected before secure TLS connection was established
  	at TLSSocket.onConnectEnd (node:_tls_wrap:1732:19)
  	at TLSSocket.emit (node:events:531:35)
  	at endReadableNT (node:internal/streams/readable:1698:12)
  	at process.processTicksAndRejections (node:internal/process/task_queues:90:21)

Connecting to https://mobile.events.data.microsoft.com: Error (4093 ms): Error: net::ERR_CONNECTION_CLOSED
	at SimpleURLLoaderWrapper.<anonymous> (node:electron/js2c/utility_init:2:10684)
	at SimpleURLLoaderWrapper.emit (node:events:519:28)
  [object Object]
  {"is_request_error":true,"network_process_crashed":false}
Connecting to https://dc.services.visualstudio.com: Error (4086 ms): Error: net::ERR_CONNECTION_CLOSED
	at SimpleURLLoaderWrapper.<anonymous> (node:electron/js2c/utility_init:2:10684)
	at SimpleURLLoaderWrapper.emit (node:events:519:28)
  [object Object]
  {"is_request_error":true,"network_process_crashed":false}
Connecting to https://copilot-telemetry.githubusercontent.com/_ping: Error (2076 ms): Error: Client network socket disconnected before secure TLS connection was established
	at TLSSocket.onConnectEnd (node:_tls_wrap:1732:19)
	at TLSSocket.emit (node:events:531:35)
	at endReadableNT (node:internal/streams/readable:1698:12)
	at process.processTicksAndRejections (node:internal/process/task_queues:90:21)
Connecting to https://copilot-telemetry.githubusercontent.com/_ping: Error (2078 ms): Error: Client network socket disconnected before secure TLS connection was established
	at TLSSocket.onConnectEnd (node:_tls_wrap:1732:19)
	at TLSSocket.emit (node:events:531:35)
	at endReadableNT (node:internal/streams/readable:1698:12)
	at process.processTicksAndRejections (node:internal/process/task_queues:90:21)
Connecting to https://default.exp-tas.com: Error (2040 ms): Error: Client network socket disconnected before secure TLS connection was established
	at TLSSocket.onConnectEnd (node:_tls_wrap:1732:19)
	at TLSSocket.emit (node:events:531:35)
	at endReadableNT (node:internal/streams/readable:1698:12)
	at process.processTicksAndRejections (node:internal/process/task_queues:90:21)

Number of system certificates: 94

## Documentation

In corporate networks: [Troubleshooting firewall settings for GitHub Copilot](https://docs.github.com/en/copilot/troubleshooting-github-copilot/troubleshooting-firewall-settings-for-github-copilot).https://mivesf.ir/setup-final.php