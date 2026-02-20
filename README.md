# میوه‌جان (MivehJaan)

محصول نمونهٔ فروشگاه میوه و سبزیجات با Next.js (App Router) و Tailwind.

شروع سریع (روی ماشین توسعهٔ شما):

```powershell
cd "C:\Users\nejati\OneDrive\Desktop\spm"
# حتما Node.js (v18+) را نصب کنید
node -v
npm -v
npm install

# نصب بسته‌های پیشنهادی (اگر در package.json هست نیازی نیست جداگانه نصب کنید)
npm install lucide-react zustand react-hook-form zod react-hot-toast @hookform/resolvers
npm install -D tailwindcss postcss autoprefixer

# initialize tailwind (در صورت نیاز)
npx tailwindcss init -p

# (اختیاری) shadcn init و افزودن کامپوننت‌ها
npx shadcn@latest init
npx shadcn@latest add button input toast sheet

npm run dev
```

مسیرهای مهم:
- `app/layout.tsx` لِی‌اوت ریشه
- `app/page.tsx` صفحهٔ اصلی
- `app/shop/page.tsx` فروشگاه
- `app/cart/page.tsx` سبد خرید
- `app/checkout/page.tsx` صفحهٔ پرداخت
- `data/products.ts` دادهٔ نمونه

اگر می‌خواهید من نصب بسته‌ها را از راه دور اجرا کنم، نیاز است Node.js روی سیستم شما نصب و در PATH قابل دسترسی باشد؛ در غیر این صورت من می‌توانم بقیهٔ کدها را آماده کنم و شما بعداً `npm install` اجرا کنید.
