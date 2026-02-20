**تنظیم GitHub Secrets برای استقرار خودکار**

برای اینکه workflow خودکار بدون دخالت شما اجرا شود، یک‌بار این Secrets را در صفحهٔ مخزن گیت‌هاب تنظیم کنید:

- `DEPLOY_HOST` — آدرس میزبان (مثال: cp199.netafraz.com)
- `DEPLOY_PORT` — پورت SSH/SFTP (مثال: 22 یا 2222) — اگر نمی‌دانید، از پشتیبان هاست بپرسید
- `DEPLOY_USER` — نام کاربری (مثال: delipir)
- `DEPLOY_PASS` — رمز عبور (مثال: Mm1225990#)
- `DEPLOY_PATH` — مسیر مقصد روی سرور (مثال: /domains/mivesf.ir/private_html/woocom)

راهنما:
1. وارد GitHub → مخزن شوید.
2. Settings → Secrets and variables → Actions → New repository secret.
3. مقدارهای بالا را اضافه کنید.
4. سپس یک push به شاخهٔ `main` بزنید؛ workflow خودکار اجرا خواهد شد و سایت را آپدیت می‌کند.

نکتهٔ امنیتی: این secrets حاوی اطلاعات حساس هستند — مطمئن شوید مخزن خصوصی است یا دسترسی‌ها محدود.
