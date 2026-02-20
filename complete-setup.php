<?php
/**
 * اسکریپت نصب کامل WordPress + WooCommerce + محصولات
 * آپلود کنید: /public_html/complete-setup.php
 * اجرا کنید: http://mivesf.ir/complete-setup.php
 */

define('WP_ROOT', dirname(__FILE__));

// بررسی WordPress
if (!file_exists(WP_ROOT . '/wp-load.php')) {
    die('❌ فایل wp-load.php پیدا نشد. WordPress نصب نشده است.');
}

require_once(WP_ROOT . '/wp-load.php');

echo '<style>
    body { font-family: "Segoe UI", Tahoma; direction: rtl; padding: 20px; background: #f5f5f5; }
    .container { max-width: 900px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
    .success { color: #27ae60; padding: 10px; background: #d5f4e6; border-left: 4px solid #27ae60; margin: 10px 0; border-radius: 4px; }
    .error { color: #e74c3c; padding: 10px; background: #fadbd8; border-left: 4px solid #e74c3c; margin: 10px 0; border-radius: 4px; }
    .info { color: #2980b9; padding: 10px; background: #d6eaf8; border-left: 4px solid #2980b9; margin: 10px 0; border-radius: 4px; }
    h1 { color: #2c3e50; text-align: center; }
    h2 { color: #2c3e50; border-bottom: 2px solid #3498db; padding-bottom: 10px; margin-top: 20px; }
    .step { margin: 15px 0; padding: 15px; background: #ecf0f1; border-radius: 4px; }
    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    th, td { border: 1px solid #bdc3c7; padding: 10px; text-align: right; }
    th { background: #3498db; color: white; }
    tr:nth-child(even) { background: #f9f9f9; }
    .progress { width: 100%; height: 30px; background: #ecf0f1; border-radius: 15px; margin: 10px 0; overflow: hidden; }
    .progress-bar { height: 100%; background: #27ae60; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; }
</style>';

echo '<div class="container">';
echo '<h1>🚀 نصب کامل فروشگاه آنلاین</h1>';

$total_steps = 0;
$completed_steps = 0;

// ===== مرحله 1: بررسی WooCommerce =====
echo '<div class="step"><h2>📦 مرحله ۱: بررسی و نصب WooCommerce</h2>';

$installed_plugins = get_plugins();
$woo_installed = false;
$woo_activated = false;
$active_plugins = get_option('active_plugins', []);

foreach ($installed_plugins as $plugin => $plugin_data) {
    if (strpos($plugin, 'woocommerce') !== false) {
        $woo_installed = true;
        if (in_array($plugin, $active_plugins)) {
            $woo_activated = true;
        }
        break;
    }
}

if ($woo_activated) {
    echo '<div class="success">✅ WooCommerce نصب و فعال است</div>';
    $completed_steps++;
} else {
    echo '<div class="info">⚠️ WooCommerce احتیاج به نصب یا فعال‌سازی دارد - برروید به Dashboard > Plugins</div>';
}
$total_steps++;

echo '</div>';

// ===== مرحله 2: صفحات ضروری =====
echo '<div class="step"><h2>📄 مرحله ۲: ایجاد صفحات ضروری</h2>';

$pages = [
    'shop' => 'فروشگاه',
    'cart' => 'سبد خرید',
    'checkout' => 'پرداخت',
    'my-account' => 'حساب کاربری',
];

$created_pages = 0;
foreach ($pages as $slug => $title) {
    $page = get_page_by_path($slug);
    if (!$page) {
        $page_id = wp_insert_post([
            'post_type' => 'page',
            'post_title' => $title,
            'post_name' => $slug,
            'post_status' => 'publish',
        ]);
        if ($page_id && !is_wp_error($page_id)) {
            echo '<div class="success">✅ صفحه "' . $title . '" ایجاد شد</div>';
            $created_pages++;
        }
    } else {
        echo '<div class="info">⚠️ صفحه "' . $title . '" قبلا وجود دارد</div>';
        $created_pages++;
    }
}

if ($created_pages == count($pages)) {
    $completed_steps++;
}
$total_steps++;

echo '</div>';

// ===== مرحله 3: دسته‌بندی‌ها =====
echo '<div class="step"><h2>🏷️ مرحله ۳: ایجاد دسته‌بندی‌های محصول</h2>';

$categories = [
    'میوه‌های فصلی' => 'fresh-fruits',
    'میوه‌های گرمسیری' => 'tropical-fruits',
    'سبزیجات تازه' => 'fresh-vegetables',
    'خشکبار' => 'dried-nuts',
    'جعبه‌های اشتراک' => 'subscription-boxes',
];

$created_cats = 0;
foreach ($categories as $cat_name => $cat_slug) {
    $existing_cat = get_term_by('name', $cat_name, 'product_cat');
    if (!$existing_cat) {
        $cat_result = wp_insert_term($cat_name, 'product_cat', ['slug' => $cat_slug]);
        if (!is_wp_error($cat_result)) {
            echo '<div class="success">✅ دسته "' . $cat_name . '" ایجاد شد</div>';
            $created_cats++;
        }
    } else {
        $created_cats++;
    }
}

if ($created_cats == count($categories)) {
    $completed_steps++;
}
$total_steps++;

echo '</div>';

// ===== مرحله 4: آپلود محصولات =====
echo '<div class="step"><h2>📦 مرحله ۴: آپلود محصولات از CSV</h2>';

$csv_file = WP_ROOT . '/fruit-shop-products.csv';

if (!file_exists($csv_file)) {
    echo '<div class="error">❌ فایل CSV پیدا نشد: ' . $csv_file . '</div>';
} else {
    $handle = fopen($csv_file, 'r');
    $header = fgetcsv($handle);
    $product_count = 0;
    $product_errors = 0;

    echo '<table>';
    echo '<tr><th>ردیف</th><th>نام محصول</th><th>قیمت</th><th>دسته</th><th>موجودی</th><th>نتیجه</th></tr>';

    while (($row = fgetcsv($handle)) !== false) {
        $product_name = trim($row[0] ?? '');
        $price = (int)($row[1] ?? 0);
        $category = trim($row[2] ?? '');
        $description = trim($row[3] ?? '');
        $weight = (float)($row[4] ?? 1);
        $stock = (int)($row[5] ?? 0);

        if (empty($product_name)) continue;

        $product_count++;
        $existing = get_page_by_title($product_name, OBJECT, 'product');

        if ($existing) {
            echo '<tr>';
            echo '<td>' . $product_count . '</td>';
            echo '<td>' . htmlspecialchars($product_name) . '</td>';
            echo '<td>' . number_format($price) . '</td>';
            echo '<td>' . htmlspecialchars($category) . '</td>';
            echo '<td>' . $stock . '</td>';
            echo '<td><span style="color: #f39c12;">⚠️ موجود</span></td>';
            echo '</tr>';
            continue;
        }

        $product_id = wp_insert_post([
            'post_title' => $product_name,
            'post_content' => $description,
            'post_type' => 'product',
            'post_status' => 'publish',
        ]);

        if (!is_wp_error($product_id) && $product_id) {
            update_post_meta($product_id, '_regular_price', $price);
            update_post_meta($product_id, '_price', $price);
            update_post_meta($product_id, '_stock', $stock);
            update_post_meta($product_id, '_manage_stock', 'yes');
            update_post_meta($product_id, '_stock_status', ($stock > 0) ? 'instock' : 'outofstock');
            update_post_meta($product_id, '_weight', $weight);
            wp_set_object_terms($product_id, 'simple', 'product_type');

            if (!empty($category)) {
                $cat = term_exists($category, 'product_cat');
                if (!$cat) {
                    $cat = wp_insert_term($category, 'product_cat');
                }
                if (!is_wp_error($cat)) {
                    wp_set_object_terms($product_id, (int)$cat['term_id'], 'product_cat');
                }
            }

            echo '<tr>';
            echo '<td>' . $product_count . '</td>';
            echo '<td>' . htmlspecialchars($product_name) . '</td>';
            echo '<td>' . number_format($price) . '</td>';
            echo '<td>' . htmlspecialchars($category) . '</td>';
            echo '<td>' . $stock . '</td>';
            echo '<td><span style="color: #27ae60;">✅ اضافه</span></td>';
            echo '</tr>';
        } else {
            $product_errors++;
            echo '<tr>';
            echo '<td>' . $product_count . '</td>';
            echo '<td>' . htmlspecialchars($product_name) . '</td>';
            echo '<td>' . number_format($price) . '</td>';
            echo '<td>' . htmlspecialchars($category) . '</td>';
            echo '<td>-</td>';
            echo '<td><span style="color: #e74c3c;">❌ خطا</span></td>';
            echo '</tr>';
        }
    }

    fclose($handle);
    echo '</table>';

    echo '<div class="success">✅ ' . ($product_count - $product_errors) . ' محصول اضافه شد</div>';
    if ($product_errors > 0) {
        echo '<div class="error">❌ ' . $product_errors . ' خطا</div>';
    }

    if ($product_errors == 0 && $product_count > 0) {
        $completed_steps++;
    }
}

$total_steps++;

echo '</div>';

// ===== مرحله 5: تنظیمات =====
echo '<div class="step"><h2>⚙️ مرحله ۵: تنظیمات نهایی</h2>';

$settings = [
    'woocommerce_currency' => 'IRR',
    'blogname' => 'فروشگاه میوه آنلاین',
    'blogdescription' => 'فروش میوه، سبزیجات و خشکبار تازه و باکیفیت',
];

foreach ($settings as $key => $value) {
    update_option($key, $value);
    echo '<div class="success">✅ تنظیم ' . $key . ' به "' . $value . '" اعمال شد</div>';
}

$completed_steps++;
$total_steps++;

echo '</div>';

// ===== خلاصه نهایی =====
echo '<div class="step"><h2>✨ خلاصه نتایج</h2>';

$percent = ($completed_steps / $total_steps) * 100;
echo '<div class="progress">';
echo '<div class="progress-bar" style="width: ' . $percent . '%">' . round($percent) . '%</div>';
echo '</div>';

$total_products = wp_count_posts('product')->publish;
$total_categories = get_terms(['taxonomy' => 'product_cat', 'count' => true, 'hide_empty' => false]);

echo '<div class="success">
    <h3>✅ نتایج نهایی:</h3>
    <ul>
        <li>📦 محصولات: <strong>' . $total_products . '</strong></li>
        <li>🏷️ دسته‌بندی‌ها: <strong>' . $total_categories . '</strong></li>
        <li>📄 صفحات: <strong>' . count($pages) . '</strong></li>
        <li>🛒 WooCommerce: <strong>' . ($woo_activated ? '✅ فعال' : '⚠️ نیاز به فعال‌سازی') . '</strong></li>
    </ul>
</div>';

echo '<div class="info"><h3>🔗 لینک‌های مهم:</h3>' .
    '<ul>' .
    '<li><a href="' . admin_url('edit.php?post_type=product') . '" target="_blank"><strong>📋 لیست محصولات</strong></a></li>' .
    '<li><a href="' . site_url('/shop') . '" target="_blank"><strong>🛒 مشاهده فروشگاه</strong></a></li>' .
    '<li><a href="' . admin_url('admin.php?page=wc-settings') . '" target="_blank"><strong>⚙️ تنظیمات WooCommerce</strong></a></li>' .
    '<li><a href="' . admin_url() . '" target="_blank"><strong>📊 داشبورد</strong></a></li>' .
    '</ul></div>';

if (!$woo_activated) {
    echo '<div class="error"><strong>⚠️ اهم:</strong> برروید به Dashboard > Plugins و WooCommerce را فعال کنید</div>';
}

echo '<hr style="margin-top: 30px;">';
echo '<p style="text-align: center; color: #7f8c8d;">✅ نصب تکمیل شد - ' . date('Y-m-d H:i:s') . '</p>';

echo '</div>';
?>
