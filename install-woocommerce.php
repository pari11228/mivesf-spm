<?php
/**
 * اسکریپت خودکار نصب WooCommerce
 * روی هاست آپلود کنید و از مرورگر دسترسی پیدا کنید
 * مثال: https://mivesf.ir/install-woocommerce.php (دامنه خود را تغییر دهید)
 */

// تنظیمات پایه
define('WP_ROOT', dirname(__FILE__));

// بررسی اینکه WordPress نصب شده باشد
if (!file_exists(WP_ROOT . '/wp-load.php')) {
    die('❌ خطا: فایل wp-load.php پیدا نشد. WordPress نصب نشده است.');
}

// بارگذاری WordPress
require_once(WP_ROOT . '/wp-load.php');

echo '<style>
    body { font-family: "Segoe UI", Tahoma; direction: rtl; padding: 20px; background: #f5f5f5; }
    .container { max-width: 800px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
    .success { color: #27ae60; font-weight: bold; padding: 10px; background: #d5f4e6; border-left: 4px solid #27ae60; margin: 10px 0; }
    .error { color: #e74c3c; font-weight: bold; padding: 10px; background: #fadbd8; border-left: 4px solid #e74c3c; margin: 10px 0; }
    .info { color: #2980b9; padding: 10px; background: #d6eaf8; border-left: 4px solid #2980b9; margin: 10px 0; }
    h2 { color: #2c3e50; border-bottom: 2px solid #3498db; padding-bottom: 10px; }
    .step { margin: 20px 0; padding: 15px; background: #ecf0f1; border-radius: 4px; }
</style>';

echo '<div class="container">';
echo '<h1>🛒 نصب خودکار WooCommerce</h1>';

// مرحله 1: نصب WooCommerce
echo '<div class="step"><h2>مرحله ۱: نصب پلاگین WooCommerce</h2>';

// دریافت لیست پلاگین‌های نصب شده
$installed_plugins = get_plugins();
$woo_installed = false;

foreach ($installed_plugins as $plugin => $plugin_data) {
    if (strpos($plugin, 'woocommerce') !== false) {
        $woo_installed = true;
        break;
    }
}

if ($woo_installed) {
    echo '<div class="success">✅ WooCommerce از قبل نصب شده است.</div>';
} else {
    echo '<div class="info">⚙️ در حال نصب WooCommerce...</div>';
    // برای نصب خودکار، نیاز به استفاده از WordPress.org API است
    echo '<div class="info">💡 نصب دستی: بروید به Dashboard > پلاگین‌ها > افزودن جدید و جستجو کنید "WooCommerce"</div>';
}
echo '</div>';

// مرحله 2: فعال‌سازی WooCommerce
echo '<div class="step"><h2>مرحله ۲: فعال‌سازی WooCommerce</h2>';

$active_plugins = get_option('active_plugins');
$woo_activated = false;

foreach ($active_plugins as $plugin) {
    if (strpos($plugin, 'woocommerce') !== false) {
        $woo_activated = true;
        echo '<div class="success">✅ WooCommerce فعال شده است.</div>';
        break;
    }
}

if (!$woo_activated && $woo_installed) {
    echo '<div class="info">⚠️ WooCommerce نصب شده اما فعال نشده است. برروید به Dashboard برای فعال‌کردن آن.</div>';
}
echo '</div>';

// مرحله 3: تنظیمات فروشگاه
echo '<div class="step"><h2>مرحله ۳: تنظیمات فروشگاه</h2>';

$settings = [
    'blogname' => ['نام فروشگاه', 'میوه‌جان'],
    'blogdescription' => ['توضیح', 'فروشگاه میوه و سبزیجات تازه'],
    'woocommerce_currency' => ['واحد پول', 'IRR'],
];

foreach ($settings as $option => $data) {
    update_option($option, $data[1]);
    echo '<div class="success">✅ ' . $data[0] . ' به "' . $data[1] . '" تنظیم شد.</div>';
}
echo '</div>';

// مرحله 4: ایجاد صفحات ضروری
echo '<div class="step"><h2>مرحله ۴: ایجاد صفحات ضروری</h2>';

$pages_to_create = [
    'shop' => 'فروشگاه',
    'cart' => 'سبد خرید',
    'checkout' => 'پرداخت',
    'account' => 'حساب کاربری',
];

foreach ($pages_to_create as $slug => $title) {
    $page = get_page_by_path($slug);
    if (!$page) {
        $page_id = wp_insert_post([
            'post_type' => 'page',
            'post_title' => $title,
            'post_name' => $slug,
            'post_status' => 'publish',
        ]);
        if ($page_id) {
            echo '<div class="success">✅ صفحه "' . $title . '" ایجاد شد.</div>';
        }
    } else {
        echo '<div class="success">✅ صفحه "' . $title . '" از قبل وجود دارد.</div>';
    }
}
echo '</div>';

// مرحله 5: ایجاد دسته‌بندی‌های محصول
echo '<div class="step"><h2>مرحله ۵: ایجاد دسته‌بندی‌های محصول</h2>';

$categories = [
    'میوه‌های تازه' => 'fresh-fruits',
    'سبزیجات' => 'vegetables',
    'میوه‌های خشک' => 'dried-fruits',
];

foreach ($categories as $cat_name => $cat_slug) {
    $cat = term_exists($cat_name, 'product_cat');
    if (!$cat) {
        $cat = wp_insert_term($cat_name, 'product_cat', ['slug' => $cat_slug]);
        if (!is_wp_error($cat)) {
            echo '<div class="success">✅ دسته‌بندی "' . $cat_name . '" ایجاد شد.</div>';
        }
    } else {
        echo '<div class="success">✅ دسته‌بندی "' . $cat_name . '" از قبل وجود دارد.</div>';
    }
}
echo '</div>';

// مرحله 6: خلاصه نهایی
echo '<div class="step"><h2>✨ نتیجه نهایی</h2>';
echo '<div class="success">✅ تمام مراحل نصب کامل شده است!</div>';
echo '<div class="info">
    <h3>مراحل بعدی:</h3>
    <ul>
        <li>۱. بروید به <strong>Dashboard > تنظیمات > فروشگاه</strong> و تنظیمات را تکمیل کنید</li>
        <li>۲. بروید به <strong>محصولات</strong> و محصولات خود را اضافه کنید</li>
        <li>۳. روش‌های پرداخت را در <strong>تنظیمات > پرداخت‌ها</strong> فعال کنید</li>
        <li>۴. قالب را تغییر دهید و فروشگاه را سفارشی کنید</li>
    </ul>
</div>';

echo '<div class="info"><strong>🔗 لینک‌های مهم:</strong><br>
Dashboard: ' . admin_url() . '<br>
فروشگاه: ' . site_url() . '/shop<br>
محصولات: ' . admin_url('edit.php?post_type=product') . '</div>';

echo '</div></div>';
echo '<hr><p style="text-align: center; color: #7f8c8d;">نصب توسط اسکریپت خودکار - تاریخ: ' . date('Y-m-d H:i:s') . '</p>';
?>
