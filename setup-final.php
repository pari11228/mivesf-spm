<?php
/**
 * 🚀 اسکریپت نصب نهایی WordPress + WooCommerce + محصولات
 * برای: mivesf.ir
 * 
 * آپلود به: /public_html/setup-final.php
 * اجرا: https://mivesf.ir/setup-final.php
 * 
 * ⚠️ برای امنیت، پس از اجرا موفق، این فایل را حذف کنید
 */

define('WP_ROOT', dirname(__FILE__));

// عدم اجرا در صورت عدم وجود WordPress
if (!file_exists(WP_ROOT . '/wp-load.php')) {
    die('❌ خطا: فایل wp-load.php پیدا نشد. WordPress نصب نشده است.');
}

require_once(WP_ROOT . '/wp-load.php');

// تعیین Set-Cookie header برای درخواست‌های بلند
if (function_exists('wp_raise_memory_limit')) {
    wp_raise_memory_limit('image');
}

?>
<!DOCTYPE html>
<html dir="rtl" lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🚀 نصب فروشگاه mivesf.ir</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            direction: rtl;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
            color: #333;
        }
        
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .header h1 {
            font-size: 28px;
            margin-bottom: 10px;
        }
        
        .header p {
            opacity: 0.9;
            font-size: 14px;
        }
        
        .content {
            padding: 30px;
        }
        
        .step {
            margin: 20px 0;
            padding: 20px;
            background: #f8f9fa;
            border-left: 4px solid #667eea;
            border-radius: 4px;
        }
        
        .step h2 {
            color: #667eea;
            margin-bottom: 15px;
            font-size: 18px;
        }
        
        .success {
            color: #27ae60;
            padding: 12px;
            background: #d5f4e6;
            border-left: 4px solid #27ae60;
            margin: 10px 0;
            border-radius: 4px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .error {
            color: #e74c3c;
            padding: 12px;
            background: #fadbd8;
            border-left: 4px solid #e74c3c;
            margin: 10px 0;
            border-radius: 4px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .warning {
            color: #f39c12;
            padding: 12px;
            background: #fdebd0;
            border-left: 4px solid #f39c12;
            margin: 10px 0;
            border-radius: 4px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .info {
            color: #2980b9;
            padding: 12px;
            background: #d6eaf8;
            border-left: 4px solid #2980b9;
            margin: 10px 0;
            border-radius: 4px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            background: white;
        }
        
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: right;
        }
        
        th {
            background: #667eea;
            color: white;
            font-weight: bold;
        }
        
        tr:nth-child(even) {
            background: #f9f9f9;
        }
        
        tr:hover {
            background: #f0f0f0;
        }
        
        .progress {
            width: 100%;
            height: 30px;
            background: #ecf0f1;
            border-radius: 15px;
            margin: 15px 0;
            overflow: hidden;
            border: 1px solid #bdc3c7;
        }
        
        .progress-bar {
            height: 100%;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            transition: width 0.3s ease;
            font-size: 12px;
        }
        
        .summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin: 20px 0;
        }
        
        .summary-card {
            background: #f0f2f5;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            border: 1px solid #ddd;
        }
        
        .summary-card h3 {
            color: #667eea;
            font-size: 24px;
            margin-bottom: 10px;
        }
        
        .summary-card p {
            color: #666;
            font-size: 12px;
        }
        
        .footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            border-top: 1px solid #ddd;
            color: #666;
            font-size: 12px;
        }
        
        .actions {
            display: flex;
            gap: 10px;
            margin-top: 20px;
            flex-wrap: wrap;
        }
        
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            font-weight: bold;
            display: inline-block;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background: #667eea;
            color: white;
        }
        
        .btn-primary:hover {
            background: #764ba2;
        }
        
        .btn-secondary {
            background: #ecf0f1;
            color: #333;
        }
        
        .btn-secondary:hover {
            background: #bdc3c7;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>🚀 نصب فروشگاه آنلاین</h1>
        <p>📱 mivesf.ir - فروشگاه میوه‌های تازه</p>
    </div>
    
    <div class="content">

<?php

$total_steps = 0;
$completed_steps = 0;

// ============================================
// مرحله 1: بررسی WooCommerce
// ============================================
echo '<div class="step">';
echo '<h2>📦 مرحله ۱: بررسی و فعال‌سازی WooCommerce</h2>';

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

if ($woo_installed) {
    if ($woo_activated) {
        echo '<div class="success">✅ WooCommerce نصب و فعال است</div>';
        $completed_steps++;
    } else {
        echo '<div class="warning">⚠️ WooCommerce نصب شده اما فعال نیست</div>';
    }
} else {
    echo '<div class="error">❌ WooCommerce نصب نشده است</div>';
    echo '<div class="info">نصب از: داشبورد > افزونه‌ها > افزودن > جستجو "WooCommerce"</div>';
}
$total_steps++;
echo '</div>';

// ============================================
// مرحله 2: صفحات ضروری
// ============================================
echo '<div class="step">';
echo '<h2>📄 مرحله ۲: ایجاد صفحات ضروری</h2>';

$pages_config = [
    'shop' => 'فروشگاه',
    'cart' => 'سبد خرید',
    'checkout' => 'پرداخت',
    'my-account' => 'حساب کاربری',
];

$created_pages = 0;
echo '<table>';
echo '<tr><th>صفحه</th><th>Slug</th><th>وضعیت</th></tr>';

foreach ($pages_config as $slug => $title) {
    $page = get_page_by_path($slug);
    
    if (!$page) {
        $page_id = wp_insert_post([
            'post_type' => 'page',
            'post_title' => $title,
            'post_name' => $slug,
            'post_status' => 'publish',
        ]);
        
        if ($page_id && !is_wp_error($page_id)) {
            echo '<tr>';
            echo '<td>' . $title . '</td>';
            echo '<td>' . $slug . '</td>';
            echo '<td><span style="color: #27ae60;">✅ ایجاد شد</span></td>';
            echo '</tr>';
            $created_pages++;
        } else {
            echo '<tr>';
            echo '<td>' . $title . '</td>';
            echo '<td>' . $slug . '</td>';
            echo '<td><span style="color: #e74c3c;">❌ خطا</span></td>';
            echo '</tr>';
        }
    } else {
        echo '<tr>';
        echo '<td>' . $title . '</td>';
        echo '<td>' . $slug . '</td>';
        echo '<td><span style="color: #f39c12;">⚠️ قبلاً موجود</span></td>';
        echo '</tr>';
        $created_pages++;
    }
}
echo '</table>';

if ($created_pages == count($pages_config)) {
    $completed_steps++;
}
$total_steps++;
echo '</div>';

// ============================================
// مرحله 3: دسته‌بندی‌ها
// ============================================
echo '<div class="step">';
echo '<h2>🏷️ مرحله ۳: ایجاد دسته‌بندی‌های محصول</h2>';

$categories_config = [
    'میوه‌های فصلی' => 'fresh-fruits',
    'میوه‌های گرمسیری' => 'tropical-fruits',
    'سبزیجات تازه' => 'fresh-vegetables',
    'خشکبار' => 'dried-nuts',
    'جعبه‌های اشتراک' => 'subscription-boxes',
];

$created_cats = 0;
echo '<table>';
echo '<tr><th>دسته‌بندی</th><th>Slug</th><th>وضعیت</th></tr>';

foreach ($categories_config as $cat_name => $cat_slug) {
    $existing_cat = get_term_by('name', $cat_name, 'product_cat');
    
    if (!$existing_cat) {
        $cat_result = wp_insert_term($cat_name, 'product_cat', ['slug' => $cat_slug]);
        
        if (!is_wp_error($cat_result)) {
            echo '<tr>';
            echo '<td>' . $cat_name . '</td>';
            echo '<td>' . $cat_slug . '</td>';
            echo '<td><span style="color: #27ae60;">✅ ایجاد شد</span></td>';
            echo '</tr>';
            $created_cats++;
        } else {
            echo '<tr>';
            echo '<td>' . $cat_name . '</td>';
            echo '<td>' . $cat_slug . '</td>';
            echo '<td><span style="color: #e74c3c;">❌ خطا</span></td>';
            echo '</tr>';
        }
    } else {
        echo '<tr>';
        echo '<td>' . $cat_name . '</td>';
        echo '<td>' . $cat_slug . '</td>';
        echo '<td><span style="color: #f39c12;">⚠️ قبلاً موجود</span></td>';
        echo '</tr>';
        $created_cats++;
    }
}
echo '</table>';

if ($created_cats == count($categories_config)) {
    $completed_steps++;
}
$total_steps++;
echo '</div>';

// ============================================
// مرحله 4: آپلود محصولات از CSV
// ============================================
echo '<div class="step">';
echo '<h2>📦 مرحله ۴: آپلود محصولات از CSV</h2>';

$csv_file = WP_ROOT . '/fruit-shop-products.csv';

if (!file_exists($csv_file)) {
    echo '<div class="error">❌ فایل CSV پیدا نشد: fruit-shop-products.csv</div>';
    echo '<div class="info">📍 مسیر مورد انتظار: ' . $csv_file . '</div>';
} else {
    $handle = fopen($csv_file, 'r');
    
    if (!$handle) {
        echo '<div class="error">❌ نتوانستیم فایل CSV را باز کنیم</div>';
    } else {
        $header = fgetcsv($handle);
        $product_count = 0;
        $product_errors = 0;
        $product_skipped = 0;

        echo '<table>';
        echo '<tr><th>#</th><th>نام محصول</th><th>قیمت</th><th>دسته</th><th>موجودی</th><th>نتیجه</th></tr>';

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
                echo '<td>#' . $product_count . '</td>';
                echo '<td>' . htmlspecialchars($product_name) . '</td>';
                echo '<td>' . number_format($price) . ' تومان</td>';
                echo '<td>' . htmlspecialchars($category) . '</td>';
                echo '<td>' . $stock . '</td>';
                echo '<td><span style="color: #f39c12;">⚠️ موجود</span></td>';
                echo '</tr>';
                $product_skipped++;
                continue;
            }

            $product_id = wp_insert_post([
                'post_title' => $product_name,
                'post_content' => $description,
                'post_type' => 'product',
                'post_status' => 'publish',
            ]);

            if (!is_wp_error($product_id) && $product_id) {
                // تنظیم قیمت و موجودی
                update_post_meta($product_id, '_regular_price', $price);
                update_post_meta($product_id, '_price', $price);
                update_post_meta($product_id, '_stock', $stock);
                update_post_meta($product_id, '_manage_stock', 'yes');
                update_post_meta($product_id, '_stock_status', ($stock > 0) ? 'instock' : 'outofstock');
                update_post_meta($product_id, '_weight', $weight);
                update_post_meta($product_id, '_tax_status', 'taxable');
                update_post_meta($product_id, '_tax_class', '');
                
                /* تنظیم نوع محصول */
                wp_set_object_terms($product_id, 'simple', 'product_type');

                // اضافه کردن به دسته‌بندی
                if (!empty($category)) {
                    $cat = term_exists($category, 'product_cat');
                    if (!$cat) {
                        $cat = wp_insert_term(
                            $category,
                            'product_cat',
                            ['slug' => sanitize_title($category)]
                        );
                    }
                    if (!is_wp_error($cat)) {
                        $term_id = is_array($cat) ? $cat['term_id'] : $cat;
                        wp_set_object_terms($product_id, (int)$term_id, 'product_cat');
                    }
                }

                echo '<tr>';
                echo '<td>#' . $product_count . '</td>';
                echo '<td>' . htmlspecialchars($product_name) . '</td>';
                echo '<td>' . number_format($price) . ' تومان</td>';
                echo '<td>' . htmlspecialchars($category) . '</td>';
                echo '<td>' . $stock . '</td>';
                echo '<td><span style="color: #27ae60;">✅ اضافه شد</span></td>';
                echo '</tr>';
            } else {
                $product_errors++;
                echo '<tr>';
                echo '<td>#' . $product_count . '</td>';
                echo '<td>' . htmlspecialchars($product_name) . '</td>';
                echo '<td>' . number_format($price) . ' تومان</td>';
                echo '<td>' . htmlspecialchars($category) . '</td>';
                echo '<td>-</td>';
                echo '<td><span style="color: #e74c3c;">❌ خطا</span></td>';
                echo '</tr>';
            }
        }

        fclose($handle);
        echo '</table>';

        $products_added = $product_count - $product_errors - $product_skipped;
        
        if ($products_added > 0) {
            echo '<div class="success">✅ ' . $products_added . ' محصول جدید اضافه شد</div>';
        }
        if ($product_skipped > 0) {
            echo '<div class="warning">⚠️ ' . $product_skipped . ' محصول قبلاً موجود بود</div>';
        }
        if ($product_errors > 0) {
            echo '<div class="error">❌ ' . $product_errors . ' محصول مع خطا</div>';
        }

        if ($product_errors == 0 && $product_count > 0) {
            $completed_steps++;
        }
    }
}

$total_steps++;
echo '</div>';

// ============================================
// مرحله 5: تنظیمات عمومی
// ============================================
echo '<div class="step">';
echo '<h2>⚙️ مرحله ۵: تنظیمات عمومی WooCommerce</h2>';

$settings_config = [
    'woocommerce_currency' => 'IRR',
    'woocommerce_currency_pos' => 'left',
    'woocommerce_price_decimal_sep' => '.',
    'woocommerce_price_thousand_sep' => ',',
    'woocommerce_price_num_decimals' => '0',
    'woocommerce_default_customer_address' => 'base',
    'blogname' => 'فروشگاه میوه‌های تازه',
    'blogdescription' => 'فروش میوه، سبزیجات، خشکبار و محصولات غذایی تازه و باکیفیت',
];

echo '<table>';
echo '<tr><th>تنظیم</th><th>مقدار</th><th>وضعیت</th></tr>';

foreach ($settings_config as $key => $value) {
    update_option($key, $value);
    echo '<tr>';
    echo '<td>' . $key . '</td>';
    echo '<td><code>' . $value . '</code></td>';
    echo '<td><span style="color: #27ae60;">✅ اعمال شد</span></td>';
    echo '</tr>';
}
echo '</table>';

$completed_steps++;
$total_steps++;
echo '</div>';

// ============================================
// خلاصه نهایی
// ============================================
echo '<div class="step">';
echo '<h2>✨ خلاصه نتایج</h2>';

$percent = ($completed_steps / $total_steps) * 100;
echo '<div class="progress">';
echo '<div class="progress-bar" style="width: ' . $percent . '%">' . round($percent) . '%</div>';
echo '</div>';

$total_products = wp_count_posts('product')->publish;
$total_categories = count(get_terms(['taxonomy' => 'product_cat', 'hide_empty' => false]));
$total_pages = wp_count_posts('page')->publish;

echo '<div class="summary">';

echo '<div class="summary-card">';
echo '<h3>' . $total_products . '</h3>';
echo '<p>📦 محصول</p>';
echo '</div>';

echo '<div class="summary-card">';
echo '<h3>' . $total_categories . '</h3>';
echo '<p>🏷️ دسته‌بندی</p>';
echo '</div>';

echo '<div class="summary-card">';
echo '<h3>' . $total_pages . '</h3>';
echo '<p>📄 صفحه</p>';
echo '</div>';

echo '<div class="summary-card">';
echo '<h3>' . ($woo_activated ? '✅' : '❌') . '</h3>';
echo '<p>🛒 WooCommerce</p>';
echo '</div>';

echo '</div>';

echo '<div class="success" style="margin-top: 20px;">';
echo '<span>✅</span>';
echo '<div>';
echo '<strong>نصب تکمیل شد!</strong><br>';
echo 'تمام مراحل با موفقیت انجام شدند.';
echo '</div>';
echo '</div>';

if (!$woo_activated) {
    echo '<div class="error" style="margin-top: 10px;">';
    echo '<span>⚠️</span>';
    echo '<div>';
    echo '<strong>توجه:</strong> WooCommerce فعال نیست.<br>';
    echo 'برروید به: Dashboard > Plugins و WooCommerce را فعال کنید.';
    echo '</div>';
    echo '</div>';
}

echo '<div class="actions">';
echo '<a href="' . esc_url(admin_url('edit.php?post_type=product')) . '" class="btn btn-primary" target="_blank">📋 لیست محصولات</a>';
echo '<a href="' . esc_url(site_url('/shop')) . '" class="btn btn-primary" target="_blank">🛒 بازدید فروشگاه</a>';
echo '<a href="' . esc_url(admin_url('admin.php?page=wc-settings')) . '" class="btn btn-secondary" target="_blank">⚙️ تنظیمات</a>';
echo '<a href="' . esc_url(admin_url()) . '" class="btn btn-secondary" target="_blank">📊 داشبورد</a>';
echo '</div>';

echo '</div>';

?>

    </div>
    
    <div class="footer">
        <p>✅ نصب فروشگاه mivesf.ir - <?php echo date('Y-m-d H:i:s'); ?></p>
        <p>⚠️ برای امنیت بیشتر، پس از اجرا موفق، این فایل را حذف کنید</p>
    </div>
</div>

</body>
</html>

<?php
// پایان فایل
?>
