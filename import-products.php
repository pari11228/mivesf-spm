<?php
/**
 * اسکریپت خودکار آپلود محصولات به WooCommerce
 * فایلها را آپلود کنید و از مرورگر دسترسی پیدا کنید
 * مثال: https://mivesf.ir/import-products.php
 */

define('WP_ROOT', dirname(__FILE__));

if (!file_exists(WP_ROOT . '/wp-load.php')) {
    die('❌ خطا: فایل wp-load.php پیدا نشد.');
}

require_once(WP_ROOT . '/wp-load.php');

echo '<style>
    body { font-family: "Segoe UI"; direction: rtl; padding: 20px; background: #f5f5f5; }
    .container { max-width: 800px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; }
    .success { color: #27ae60; padding: 10px; background: #d5f4e6; border-left: 4px solid #27ae60; margin: 10px 0; }
    .error { color: #e74c3c; padding: 10px; background: #fadbd8; border-left: 4px solid #e74c3c; margin: 10px 0; }
    .info { color: #2980b9; padding: 10px; background: #d6eaf8; border-left: 4px solid #2980b9; margin: 10px 0; }
    h2 { color: #2c3e50; border-bottom: 2px solid #3498db; padding-bottom: 10px; }
    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    th, td { border: 1px solid #ddd; padding: 10px; text-align: right; }
    th { background: #3498db; color: white; }
    tr:nth-child(even) { background: #f9f9f9; }
</style>';

echo '<div class="container">';
echo '<h1>🛒 آپلود محصولات WooCommerce</h1>';

// دریافت مسیر فایل CSV
$csv_file = WP_ROOT . '/fruit-shop-products.csv';

if (!file_exists($csv_file)) {
    die('<div class="error">❌ فایل fruit-shop-products.csv پیدا نشد.</div>');
}

echo '<h2>📂 بارگذاری محصولات از CSV</h2>';

$handle = fopen($csv_file, 'r');
$header = fgetcsv($handle);
$count = 0;
$errors = 0;

echo '<table>';
echo '<tr><th>ردیف</th><th>نام محصول</th><th>قیمت</th><th>دسته</th><th>نتیجه</th></tr>';

while (($row = fgetcsv($handle)) !== false) {
    $count++;
    
    $product_name = $row[0] ?? '';
    $price = $row[1] ?? 0;
    $category = $row[2] ?? '';
    $description = $row[3] ?? '';
    $weight = $row[4] ?? 1;
    $stock = $row[5] ?? 0;

    if (empty($product_name)) continue;

    // بررسی اینکه محصول قبلا اضافه شده یا نه
    $existing = get_page_by_title($product_name, OBJECT, 'product');
    
    if ($existing) {
        echo '<tr>';
        echo '<td>' . $count . '</td>';
        echo '<td>' . $product_name . '</td>';
        echo '<td>' . number_format($price) . '</td>';
        echo '<td>' . $category . '</td>';
        echo '<td><span style="color: #f39c12;">⚠️ قبلا اضافه شده</span></td>';
        echo '</tr>';
        continue;
    }

    // ایجاد محصول
    $product_id = wp_insert_post([
        'post_title'   => $product_name,
        'post_content' => $description,
        'post_type'    => 'product',
        'post_status'  => 'publish',
    ]);

    if (!is_wp_error($product_id)) {
        // تنظیم قیمت
        update_post_meta($product_id, '_regular_price', $price);
        update_post_meta($product_id, '_sale_price', '');
        update_post_meta($product_id, '_price', $price);
        
        // تنظیم موجودی
        update_post_meta($product_id, '_stock', $stock);
        update_post_meta($product_id, '_manage_stock', 'yes');
        update_post_meta($product_id, '_stock_status', ($stock > 0) ? 'instock' : 'outofstock');
        
        // تنظیم وزن
        update_post_meta($product_id, '_weight', $weight);
        
        // تنظیم نوع محصول
        wp_set_object_terms($product_id, 'simple', 'product_type');
        
        // اضافه کردن به دسته‌بندی
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
        echo '<td>' . $count . '</td>';
        echo '<td>' . $product_name . '</td>';
        echo '<td>' . number_format($price) . '</td>';
        echo '<td>' . $category . '</td>';
        echo '<td><span style="color: #27ae60;">✅ اضافه شد</span></td>';
        echo '</tr>';
    } else {
        $errors++;
        echo '<tr>';
        echo '<td>' . $count . '</td>';
        echo '<td>' . $product_name . '</td>';
        echo '<td>' . number_format($price) . '</td>';
        echo '<td>' . $category . '</td>';
        echo '<td><span style="color: #e74c3c;">❌ خطا</span></td>';
        echo '</tr>';
    }
}

fclose($handle);
echo '</table>';

echo '<div class="success">✅ پردازش تمام شد!<br>
✅ محصولات اضافه شده: <strong>' . ($count - $errors) . '</strong><br>
❌ خطاها: <strong>' . $errors . '</strong></div>';

echo '<h2>📋 مراحل بعدی:</h2>';
echo '<div class="info">
    <ul>
        <li>✅ محصولات اضافه شدند با قیمت و موجودی</li>
        <li>📸 برای افزودن تصویر، بروید به: <strong>محصولات > محصول را ویرایش کنید</strong></li>
        <li>🔗 <a href="' . admin_url('edit.php?post_type=product') . '">بروید به لیست محصولات</a></li>
    </ul>
</div>';

echo '</div>';
?>
