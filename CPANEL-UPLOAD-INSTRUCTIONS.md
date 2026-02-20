**cPanel Upload (File Manager) — سریع و بدون SSH**

1. ورود به کنترل‌پنل: https://cp199.netafraz.com:2223/ با نام‌کاربری `delipir` و رمز کاربری شما.
2. به File Manager → مسیر `/domains/mivesf.ir/private_html/woocom` بروید.
3. اگر سایت زنده است، از پوشهٔ فعلی یک بکاپ zip بگیرید (Select All → Compress).
4. `Upload` → فایل `spm-clean.zip` را آپلود کنید.
5. پس از آپلود، در File Manager روی `spm-clean.zip` راست‌کلیک → Extract.
6. پس از استخراج، فایل‌های نصب/اسکریپت (اگر مانده‌اند) را حذف کنید.
7. جهت تغییر `wp-config.php` (در صورت نیاز):
   - Edit the `wp-config.php` file and update DB_NAME, DB_USER, DB_PASSWORD, DB_HOST accordingly.
8. از بخش phpMyAdmin در cPanel دیتابیس را وارد (Import) کنید اگر یک فایل `.sql` دارید.

اگر می‌خواهید من اسکریپت انتقال با استفاده از cPanel UAPI یا SFTP برای آپلود اتوماتیک تهیه کنم، بگویید SSH یا SFTP روی هاست فعال است یا خیر.
