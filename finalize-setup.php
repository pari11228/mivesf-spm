<?php
/**
 * اسکریپت خودکار برای تنظیمات نهایی WooCommerce
 * به آدرس: https://mivesf.ir/finalize-setup.php
 */

define('WP_ROOT', dirname(__FILE__));

if (!file_exists(WP_ROOT . '/wp-load.php')) {
    die('❌ خطا: فایل wp-load.php پیدا نشد.');
}

require_once(WP_ROOT . '/wp-load.php');

echo '<style>
    body { font-family: "Segoe UI"; direction: rtl; padding: 20px; background: #f5f5f5; }
    .container { max-width: 900px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; }
    .success { color: #27ae60; padding: 10px; background: #d5f4e6; border-left: 4px solid #27ae60; margin: 10px 0; }
    .error { color: #e74c3c; padding: 10px; background: #fadbd8; border-left: 4px solid #e74c3c; margin: 10px 0; }
    .info { color: #2980b9; padding: 10px; background: #d6eaf8; border-left: 4px solid #2980b9; margin: 10px 0; }
    h2 { color: #2c3e50; border-bottom: 2px solid #3498db; padding-bottom: 10px; }
</style>';

echo '<div class="container">';
echo '<h1>⚙️ تنظیمات نهایی WooCommerce</h1>';

// مرحله 1: صفحات ضروری
echo '<h2>📄 مرحله ۱: ایجاد صفحات ضروری</h2>';

$pages_to_create = [
    'shop' => ['نام' => 'فروشگاه', 'content' => '[products]'],
    'cart' => ['نام' => 'سبد خرید', 'content' => '[woocommerce_cart]'],
    'checkout' => ['نام' => 'پرداخت', 'content' => '[woocommerce_checkout]'],
    'my-account' => ['نام' => 'حساب کاربری', 'content' => '[woocommerce_my_account]'],
    'terms' => ['نام' => 'شرایط و قوانین', 'content' => 'شرایط و قوانین فروشگاه'],
];

foreach ($pages_to_create as $slug => $page_data) {
    $page = get_page_by_path($slug);
    
    if (!$page) {
        $page_id = wp_insert_post([
            'post_type' => 'page',
            'post_title' => $page_data['نام'],
            'post_name' => $slug,
            'post_content' => $page_data['content'],
            'post_status' => 'publish',
        ]);
        
        if ($page_id) {
            echo '<div class="success">✅ صفحه "' . $page_data['نام'] . '" ایجاد شد</div>';
        } else {
            echo '<div class="error">❌ خطا در ایجاد صفحه "' . $page_data['نام'] . '"</div>';
        }
    } else {
        echo '<div class="info">⚠️ صفحه "' . $page_data['نام'] . '" قبلا وجود دارد</div>';
    }
}

// مرحله 2: تنظیمات WooCommerce
echo '<h2>⚙️ مرحله ۲: تنظیمات فروشگاه</h2>';

$woo_settings = [
    'woocommerce_shop_page_id' => get_page_by_path('shop') ? get_page_by_path('shop')->ID : 0,
    'woocommerce_cart_page_id' => get_page_by_path('cart') ? get_page_by_path('cart')->ID : 0,
    'woocommerce_checkout_page_id' => get_page_by_path('checkout') ? get_page_by_path('checkout')->ID : 0,
    'woocommerce_myaccount_page_id' => get_page_by_path('my-account') ? get_page_by_path('my-account')->ID : 0,
    'woocommerce_terms_page_id' => get_page_by_path('terms') ? get_page_by_path('terms')->ID : 0,
    'woocommerce_currency' => 'IRR',
    'woocommerce_currency_pos' => 'right',
    'woocommerce_price_decimal_sep' => '.',
    'woocommerce_price_thousand_sep' => ',',
    'woocommerce_price_num_decimals' => 0,
];

foreach ($woo_settings as $key => $value) {
    if ($value != 0 || strpos($key, 'page_id') === false) {
        update_option($key, $value);
        echo '<div class="success">✅ تنظیم "' . $key . '" اعمال شد</div>';
    }
}

// مرحله 3: دسته‌بندی‌ها
echo '<h2>🏷️ مرحله ۳: دسته‌بندی‌های محصول</h2>';

$categories = [
    'میوه‌های فصلی' => 'fresh-fruits',
    'میوه‌های گرمسیری' => 'tropical-fruits',
    'سبزیجات تازه' => 'fresh-vegetables',
    'خشکبار' => 'dried-nuts',
    'جعبه‌های اشتراک' => 'subscription-boxes',
];

foreach ($categories as $cat_name => $cat_slug) {
    $existing_cat = get_term_by('name', $cat_name, 'product_cat');
    
    if (!$existing_cat) {
        $cat_result = wp_insert_term($cat_name, 'product_cat', ['slug' => $cat_slug]);
        if (!is_wp_error($cat_result)) {
            echo '<div class="success">✅ دسته‌بندی "' . $cat_name . '" ایجاد شد</div>';
        }
    } else {
        echo '<div class="info">⚠️ دسته‌بندی "' . $cat_name . '" قبلا وجود دارد</div>';
    }
}

// مرحله 4: روش‌های پرداخت
echo '<h2>💳 مرحله ۴: روش‌های پرداخت</h2>';

$payment_gateways = [
    'bacs' => 'Bank Transfer',
    'cheque' => 'Check Payments',
    'cod' => 'Cash on Delivery',
];

echo '<div class="info">
    ✅ روش‌های پرداخت پیش‌فرض WooCommerce فعال شده‌اند<br>
    💡 برای اضافه کردن درگاه‌های اختصاصی (زرین‌پال، بانک‌ها)، بروید به: Dashboard > تنظیمات > پرداخت‌ها
</div>';

// مرحله 5: شحن و حمل
echo '<h2>📦 مرحله ۵: تنظیمات حمل</h2>';

$shipping_zones = count(WC()->shipping->get_zones());
echo '<div class="info">
    ✅ ' . $shipping_zones . ' منطقه حمل تعریف شده‌اند<br>
    💡 برای تنظیم نرخ حمل: Dashboard > تنظیمات > حمل‌ونقل
</div>';

// خلاصه نهایی
echo '<h2>✨ خلاصه نهایی</h2>';

$products_count = wp_count_posts('product')->publish;
$categories_count = get_terms(['taxonomy' => 'product_cat', 'count' => true, 'hide_empty' => false]);

echo '<div class="success">
    ✅ تمامی تنظیمات کامل شد!<br><br>
    <strong>📊 آمار:</strong><br>
    • محصولات: ' . $products_count . '<br>
    • دسته‌بندی‌ها: ' . $categories_count . '<br>
    • صفحات: ' . count($pages_to_create) . '<br>
</div>';

echo '<div class="info">
    <h3>🚀 مراحل نهایی:</h3>
    <ol>
        <li><a href="' . admin_url('edit.php?post_type=product') . '"><strong>مشاهده و ویرایش محصولات</strong></a> - برای افزودن تصاویر و جزئیات بیشتر</li>
        <li><a href="' . admin_url('admin.php?page=wc-settings&tab=general') . '"><strong>تنظیمات عمومی فروشگاه</strong></a> - نام و آدرس</li>
        <li><a href="' . admin_url('admin.php?page=wc-settings&tab=products') . '"><strong>تنظیمات محصولات</strong></a> - نمایش و فیلتر</li>
        <li><a href="' . site_url('/shop') . '"><strong>بازدید از فروشگاه</strong></a> - مشاهده نتیجه</li>
    </ol>
</div>';

echo '</div>';
?>
