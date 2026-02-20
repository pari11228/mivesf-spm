<?php
/**
 * 🚀 اسکریپت نصب ساده‌شده برای mivesf.ir
 * 
 * آپلود به: /public_html/setup-simple.php
 * اجرا: http://mivesf.ir/setup-simple.php (بدون https)
 * 
 * این اسکریپت:
 * ✅ کار می‌کند با http یا https
 * ✅ ساده‌تر از setup-final.php
 * ✅ خودکار تمام چیزها را نصب می‌کند
 */

// تنظیمات صفحه
header('Content-Type: text/html; charset=utf-8');

// اشتباه handling شروع
error_reporting(E_ALL);
ini_set('display_errors', 1);

define('WP_ROOT', dirname(__FILE__));

// بررسی WordPress
if (!file_exists(WP_ROOT . '/wp-load.php')) {
    die('<h1 style="color:red; direction:rtl; font-family:arial;">❌ خطا: فایل wp-load.php پیدا نشد در: ' . htmlspecialchars(WP_ROOT) . '/wp-load.php</h1>');
}

// لود کردن WordPress
require_once(WP_ROOT . '/wp-load.php');

// بررسی اینکه WordPress کامل لوড شد
if (!function_exists('wp_insert_post')) {
    die('<h1 style="color:red; direction:rtl; font-family:arial;">❌ خطا: WordPress درست لود نشد</h1>');
}

?>
<!DOCTYPE html>
<html dir="rtl" lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نصب فروشگاه mivesf.ir</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            direction: rtl;
            background: #f5f5f5;
            padding: 20px;
            margin: 0;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            text-align: center;
            border-bottom: 3px solid #007cba;
            padding-bottom: 15px;
        }
        .status {
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
        }
        .success {
            background: #d4edda;
            color: #155724;
            border-left: 4px solid #28a745;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
        }
        .info {
            background: #d1ecf1;
            color: #0c5460;
            border-left: 4px solid #17a2b8;
        }
        .warning {
            background: #fff3cd;
            color: #856404;
            border-left: 4px solid #ffc107;
        }
        .section {
            margin: 20px 0;
            padding: 15px;
            background: #f9f9f9;
            border-left: 4px solid #007cba;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: right;
        }
        th {
            background: #007cba;
            color: white;
        }
        .progress {
            width: 100%;
            height: 25px;
            background: #ddd;
            border-radius: 4px;
            overflow: hidden;
            margin: 15px 0;
        }
        .progress-bar {
            height: 100%;
            background: #28a745;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 12px;
            transition: width 0.3s;
        }
        .summary {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin: 20px 0;
        }
        .summary-item {
            padding: 15px;
            background: #f0f0f0;
            border-radius: 4px;
            text-align: center;
        }
        .summary-item h3 {
            font-size: 24px;
            color: #007cba;
            margin: 0;
        }
        .summary-item p {
            margin: 5px 0 0 0;
            color: #666;
            font-size: 12px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>🚀 نصب فروشگاه mivesf.ir</h1>

<?php

// متغیرهای شمارش
$total = 5;
$completed = 0;
$messages = [];

// ============================================
// مرحله 1: بررسی WooCommerce
// ============================================
echo '<div class="section"><h2>📦 مرحله ۱: بررسی WooCommerce</h2>';

try {
    // بارگذاری توابع افزونه
    if (!function_exists('get_plugins')) {
        require_once(ABSPATH . 'wp-admin/includes/plugin.php');
    }
    
    $plugins = get_plugins();
    $woo_active = false;

    foreach ($plugins as $plugin => $data) {
        if (strpos($plugin, 'woocommerce') !== false) {
            if (is_plugin_active($plugin)) {
                $woo_active = true;
                echo '<div class="status success">✅ WooCommerce نصب و فعال است</div>';
                $completed++;
                break;
            }
        }
    }

    if (!$woo_active) {
        echo '<div class="status error">❌ WooCommerce فعال نیست!</div>';
        echo '<div class="status info">راه حل: داشبورد > افزونه‌ها > WooCommerce > فعال</div>';
    }
} catch (Exception $e) {
    echo '<div class="status warning">⚠️ نتوانستیم وضعیت WooCommerce را بررسی کنیم: ' . htmlspecialchars($e->getMessage()) . '</div>';
}

echo '</div>';

// ============================================
// مرحله 2: صفحات
// ============================================
echo '<div class="section"><h2>📄 مرحله ۲: صفحات ضروری</h2>';

$pages = [
    'shop' => 'فروشگاه',
    'cart' => 'سبد خرید',
    'checkout' => 'پرداخت',
];

$page_count = 0;
echo '<table><tr><th>صفحه</th><th>وضعیت</th></tr>';

try {
    foreach ($pages as $slug => $title) {
        // بررسی صفحه موجود
        $existing = get_posts([
            'name' => $slug,
            'post_type' => 'page',
            'numberposts' => 1,
        ]);
        
        if (empty($existing)) {
            $pid = wp_insert_post([
                'post_type' => 'page',
                'post_title' => $title,
                'post_name' => $slug,
                'post_status' => 'publish',
            ]);
            
            if ($pid && !is_wp_error($pid)) {
                echo '<tr><td>' . $title . '</td><td style="color: green;">✅ ایجاد</td></tr>';
                $page_count++;
            } else {
                echo '<tr><td>' . $title . '</td><td style="color: red;">❌ خطا</td></tr>';
            }
        } else {
            echo '<tr><td>' . $title . '</td><td style="color: orange;">⚠️ موجود</td></tr>';
            $page_count++;
        }
    }
} catch (Exception $e) {
    echo '<tr><td colspan="2" style="color: red;">❌ خطا: ' . htmlspecialchars($e->getMessage()) . '</td></tr>';
}

echo '</table>';

if ($page_count == count($pages)) {
    echo '<div class="status success">✅ تمام صفحات آماده‌اند</div>';
    $completed++;
} else {
    echo '<div class="status warning">⚠️ برخی صفحات مشکل دارند</div>';
}

echo '</div>';

// ============================================
// مرحله 3: دسته‌بندی
// ============================================
echo '<div class="section"><h2>🏷️ مرحله ۳: دسته‌بندی‌های محصول</h2>';

$categories = [
    'میوه‌های فصلی' => 'fresh-fruits',
    'میوه‌های گرمسیری' => 'tropical-fruits',
    'سبزیجات تازه' => 'fresh-vegetables',
    'خشکبار' => 'dried-nuts',
    'جعبه‌های اشتراک' => 'subscription',
];

$cat_count = 0;
echo '<table><tr><th>دسته</th><th>وضعیت</th></tr>';

try {
    foreach ($categories as $name => $slug) {
        $cat = get_term_by('name', $name, 'product_cat');
        
        if (!$cat) {
            $result = wp_insert_term($name, 'product_cat', ['slug' => $slug]);
            if (!is_wp_error($result)) {
                echo '<tr><td>' . htmlspecialchars($name) . '</td><td style="color: green;">✅ ایجاد</td></tr>';
                $cat_count++;
            } else {
                echo '<tr><td>' . htmlspecialchars($name) . '</td><td style="color: red;">❌ ' . htmlspecialchars($result->get_error_message()) . '</td></tr>';
            }
        } else {
            echo '<tr><td>' . htmlspecialchars($name) . '</td><td style="color: orange;">⚠️ موجود</td></tr>';
            $cat_count++;
        }
    }
} catch (Exception $e) {
    echo '<tr><td colspan="2" style="color: red;">❌ خطا: ' . htmlspecialchars($e->getMessage()) . '</td></tr>';
}

echo '</table>';

if ($cat_count == count($categories)) {
    echo '<div class="status success">✅ تمام دسته‌بندی‌ها آماده‌اند</div>';
    $completed++;
} else {
    echo '<div class="status warning">⚠️ برخی دسته‌بندی‌ها مشکل دارند</div>';
}

echo '</div>';

// ============================================
// مرحله 4: محصولات
// ============================================
echo '<div class="section"><h2>📦 مرحله ۴: آپلود محصولات</h2>';

$csv_file = WP_ROOT . '/fruit-shop-products.csv';

if (!file_exists($csv_file)) {
    echo '<div class="status error">❌ فایل CSV پیدا نشد</div>';
    echo '<div class="status info">مسیر: ' . htmlspecialchars($csv_file) . '</div>';
    echo '<div class="status warning">⚠️ لطفاً fruit-shop-products.csv را آپلود کنید</div>';
} else {
    try {
        $handle = @fopen($csv_file, 'r');
        
        if (!$handle) {
            echo '<div class="status error">❌ نتوانستیم فایل CSV را باز کنیم</div>';
        } else {
            $header = fgetcsv($handle);
            $count = 0;
            $errors = 0;
            
            echo '<table><tr><th>#</th><th>محصول</th><th>قیمت</th><th>وضعیت</th></tr>';
            
            while (($row = fgetcsv($handle)) !== false && $count < 25) {
                $name = trim($row[0] ?? '');
                if (empty($name)) continue;
                
                $price = (int)($row[1] ?? 0);
                $category = trim($row[2] ?? '');
                $desc = trim($row[3] ?? '');
                $stock = (int)($row[5] ?? 0);
                
                // بررسی محصول موجود
                $existing = get_posts([
                    'title' => $name,
                    'post_type' => 'product',
                    'numberposts' => 1,
                ]);
                
                if (!empty($existing)) {
                    echo '<tr>';
                    echo '<td>' . ++$count . '</td>';
                    echo '<td>' . htmlspecialchars($name) . '</td>';
                    echo '<td>' . number_format($price) . '</td>';
                    echo '<td style="color: orange;">⚠️ موجود</td>';
                    echo '</tr>';
                    continue;
                }
                
                try {
                    $pid = wp_insert_post([
                        'post_title' => $name,
                        'post_content' => $desc,
                        'post_type' => 'product',
                        'post_status' => 'publish',
                    ]);
                    
                    if ($pid && !is_wp_error($pid)) {
                        update_post_meta($pid, '_regular_price', $price);
                        update_post_meta($pid, '_price', $price);
                        update_post_meta($pid, '_stock', $stock);
                        update_post_meta($pid, '_manage_stock', 'yes');
                        update_post_meta($pid, '_stock_status', $stock > 0 ? 'instock' : 'outofstock');
                        wp_set_object_terms($pid, 'simple', 'product_type');
                        
                        if (!empty($category)) {
                            $cat = term_exists($category, 'product_cat');
                            if (!$cat) {
                                $cat = wp_insert_term($category, 'product_cat');
                            }
                            if (!is_wp_error($cat)) {
                                $term_id = is_array($cat) ? $cat['term_id'] : $cat;
                                wp_set_object_terms($pid, (int)$term_id, 'product_cat');
                            }
                        }
                        
                        echo '<tr>';
                        echo '<td>' . ++$count . '</td>';
                        echo '<td>' . htmlspecialchars($name) . '</td>';
                        echo '<td>' . number_format($price) . '</td>';
                        echo '<td style="color: green;">✅ اضافه</td>';
                        echo '</tr>';
                    } else {
                        $errors++;
                        echo '<tr>';
                        echo '<td>' . ++$count . '</td>';
                        echo '<td>' . htmlspecialchars($name) . '</td>';
                        echo '<td>-</td>';
                        echo '<td style="color: red;">❌ خطا</td>';
                        echo '</tr>';
                    }
                } catch (Exception $e) {
                    $errors++;
                    echo '<tr><td colspan="4" style="color: red;">❌ ' . htmlspecialchars($e->getMessage()) . '</td></tr>';
                }
            }
            
            fclose($handle);
            echo '</table>';
            
            if ($count > 0) {
                echo '<div class="status success">✅ ' . $count . ' محصول اضافه شد</div>';
                if ($errors == 0) {
                    $completed++;
                }
            }
        }
    } catch (Exception $e) {
        echo '<div class="status error">❌ خطا در پردازش CSV: ' . htmlspecialchars($e->getMessage()) . '</div>';
    }
}

echo '</div>';

// ============================================
// مرحله 5: تنظیمات
// ============================================
echo '<div class="section"><h2>⚙️ مرحله ۵: تنظیمات</h2>';

try {
    $options = [
        'woocommerce_currency' => 'IRR',
        'woocommerce_price_num_decimals' => '0',
        'blogname' => 'فروشگاه میوه mivesf.ir',
    ];

    foreach ($options as $key => $val) {
        update_option($key, $val);
    }

    echo '<div class="status success">✅ تنظیمات اعمال شد</div>';
    $completed++;
} catch (Exception $e) {
    echo '<div class="status warning">⚠️ مشکل در اعمال تنظیمات: ' . htmlspecialchars($e->getMessage()) . '</div>';
}

echo '</div>';

// ============================================
// خلاصه
// ============================================
echo '<div class="section"><h2>✨ خلاصه نتایج</h2>';

$percent = ($completed / $total) * 100;
echo '<div class="progress">';
echo '<div class="progress-bar" style="width:' . $percent . '%">' . round($percent) . '%</div>';
echo '</div>';

try {
    $total_products = wp_count_posts('product')->publish ?? 0;
    $total_cats = count(get_terms(['taxonomy' => 'product_cat', 'hide_empty' => false]));
} catch (Exception $e) {
    $total_products = 0;
    $total_cats = 0;
}

echo '<div class="summary">';
echo '<div class="summary-item"><h3>' . intval($total_products) . '</h3><p>محصول</p></div>';
echo '<div class="summary-item"><h3>' . intval($total_cats) . '</h3><p>دسته‌بندی</p></div>';
echo '<div class="summary-item"><h3>' . (isset($woo_active) && $woo_active ? '✅' : '❌') . '</h3><p>WooCommerce</p></div>';
echo '<div class="summary-item"><h3>' . $completed . '/' . $total . '</h3><p>مراحل</p></div>';
echo '</div>';

if ($completed >= $total) {
    echo '<div class="status success"><h3>✅ نصب موفق بود!</h3>';
    echo '<p>فروشگاه شما آماده است. اکنون می‌توانید:</p>';
    echo '<ul>';
    echo '<li>🛒 فروشگاه را بازدید کنید: <strong>' . htmlspecialchars(site_url('/shop')) . '</strong></li>';
    echo '<li>📊 داشبورد: <strong>' . htmlspecialchars(admin_url()) . '</strong></li>';
    echo '<li>💳 تنظیمات WooCommerce</li>';
    echo '<li>📦 افزودن محصولات جدید</li>';
    echo '</ul>';
    echo '</div>';
} else {
    echo '<div class="status warning"><h3>⚠️ نصب نیمه‌تمام</h3>';
    echo '<p>مراحل تکمیل شده: ' . $completed . ' از ' . $total . '</p>';
    echo '</div>';
}

if (isset($woo_active) && !$woo_active) {
    echo '<div class="status error"><strong>⚠️ نکته مهم:</strong> WooCommerce فعال نیست!</div>';
    echo '<div class="status info">روش حل: داشبورد > افزونه‌ها > WooCommerce > دکمه "فعال کن"</div>';
}

echo '</div>';

// پایان
echo '<div style="text-align: center; margin-top: 30px; color: #666; font-size: 12px;">';
echo '<p>✅ نصب تکمیل شد - ' . date('Y-m-d H:i:s') . '</p>';
echo '<p>برای امنیت، این فایل را بعداً حذف کنید</p>';
echo '<p>متن خطای موجود را بالا ببینید و به پشتیبانی ارسال کنید</p>';
echo '</div>';

?>

</div>

</body>
</html>
