# Mivesf - spm (Automated deploy setup)

این مخزن محلی شامل کدهای سایت و اسکریپت‌های آماده‌سازی و استقرار است.

آنچه در این پوشه هست:
- `spm-clean.zip` — بستهٔ تمیز ساخته‌شده (تولیدشده محلی)
- `prepare_deploy.ps1` — اسکریپت ویندوزی برای تولید بستهٔ تمیز
- `server_setup.sh` — اسکریپت سروری برای اجرا پس از آپلود (پشتیبان‌گیری، استخراج، حذف اسکریپت‌ها، تنظیم مجوزها، WP-CLI)
- `.github/workflows/auto_deploy.yml` — workflow برای آپلود و اجرای خودکار روی سرور (نیاز به GitHub Actions secrets)
- `DEPLOYMENT.md`, `CPANEL-UPLOAD-INSTRUCTIONS.md`, `WP-CLI-COMMANDS.md` — مستندات راه‌اندازی و دستورات

بعدی که من انجام دادم:
- مخزن را محلی مقداردهی کردم و فایل‌ها را کامیت خواهم کرد (در قدم بعدی).

نحوهٔ push به GitHub و شروع استقرار خودکار:
1. به GitHub بروید و یک مخزن جدید بسازید (ترجیحاً خصوصی).
2. در مخزن محلی این پوشه را به عنوان remote اضافه کنید و push کنید:

```bash
git remote add origin https://github.com/<your-username>/<repo>.git
git branch -M main
git push -u origin main
```

3. در Settings → Secrets and variables → Actions مخزن، Secrets زیر را اضافه کنید:
- `DEPLOY_HOST`, `DEPLOY_PORT`, `DEPLOY_USER`, `DEPLOY_PASS`, `DEPLOY_PATH`

4. پس از push به شاخه `main`، workflow شروع به اجرا می‌کند و سایت را آپدیت می‌کند.

اگر می‌خواهید من خودم مخزن را در گیت‌هاب بسازم و push کنم، اجازهٔ دسترسی کوتاه‌مدت (یا توکن gh) لازم است — اگر مایلید بگویید تا راه امن را توضیح دهم.
