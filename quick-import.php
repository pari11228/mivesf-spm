http://mivesf.ir/fruit-shop/wp-adminhttp://mivesf.ir/fruit-shop/wp-adminhttp://mivesf.ir/fruit-shop/wp-adminhttp://mivesf.ir/fruit-shop/wp-admin<?php
/**
 * آپلود مستقیم محصولات بدون نیاز به CSV
 * http://mivesf.ir/quick-import.php
 */

define('WP_ROOT', dirname(__FILE__));

if (!file_exists(WP_ROOT . '/wp-load.php')) {
    die('❌ WordPress پیدا نشد');
}

require_once(WP_ROOT . '/wp-load.php');

echo '<style>
    body { font-family: "Segoe UI"; direction: rtl; padding: 20px; background: #f5f5f5; }
    .container { max-width: 900px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; }
    .success { color: #27ae60; padding: 10px; background: #d5f4e6; border-left: 4px solid #27ae60; margin: 10px 0; }
    .error { color: #e74c3c; padding: 10px; background: #fadbd8; border-left: 4px solid #e74c3c; margin: 10px 0; }
    h1 { text-align: center; color: #2c3e50; }
    h2 { color: #2c3e50; border-bottom: 2px solid #3498db; padding-bottom: 10px; }
    table { width: 100%; border-collapse: collapse; margin: 10px 0; }
    th, td { border: 1px solid #ddd; padding: 10px; text-align: right; }
    th { background: #3498db; color: white; }
</style>';

echo '<div class="container">';
echo '<h1>🚀 آپلود مستقیم محصولات</h1>';

// محصولات
$products = [
    ['سیب قرمز تازه', 25000, 'میوه‌های فصلی', 'سیب‌های قرمز شیرین و تازه', 1, 100],
    ['پرتقال شیرین', 18000, 'میوه‌های فصلی', 'پرتقال‌های آب‌دار و شیرین', 1, 150],
    ['موز زرد', 35000, 'میوه‌های گرمسیری', 'موزهای زرد شیرین و آبدار', 1, 80],
    ['کیوی سبز', 28000, 'میوه‌های فصلی', 'کیوی‌های سبز تازه و خوش‌طعم', 1, 60],
    ['انگور سفید', 45000, 'میوه‌های فصلی', 'انگورهای سفید شیرین و بی‌دانه', 1, 40],
    ['هلو زرد', 32000, 'میوه‌های فصلی', 'هلوهای زرد آبدار و شیرین', 1, 70],
    ['طالبی', 22000, 'میوه‌های فصلی', 'طالبی‌های شیرین و خوش‌عطر', 1, 50],
    ['خربزه', 18000, 'میوه‌های فصلی', 'خربزه‌های آب‌دار و تازه', 1, 45],
    ['جعبه میوه اقتصادی', 150000, 'جعبه‌های اشتراک', 'جعبه میوه متنوع', 5, 20],
    ['جعبه میوه ویژه', 250000, 'جعبه‌های اشتراک', 'جعبه میوه ممتاز', 7, 15],
    ['گوجه فرنگی', 12000, 'سبزیجات تازه', 'گوجه‌های قرمز تازه', 1, 200],
    ['خیار', 8000, 'سبزیجات تازه', 'خیارهای تازه', 1, 180],
    ['سیب زمینی', 10000, 'سبزیجات تازه', 'سیب زمینی‌های زرد', 1, 300],
    ['پیاز', 7000, 'سبزیجات تازه', 'پیازهای قرمز تازه', 1, 250],
    ['پسته خام', 180000, 'خشکبار', 'پسته درجه یک', 0.5, 100],
    ['بادام درختی', 150000, 'خشکبار', 'بادام درختی تازه', 0.5, 80],
    ['گردو', 220000, 'خشکبار', 'گردوی ایرانی', 0.5, 60],
    ['انبه', 55000, 'میوه‌های گرمسیری', 'انبه‌های شیرین', 1, 30],
    ['آناناس', 48000, 'میوه‌های گرمسیری', 'آناناس‌های تازه', 1, 25],
];

echo '<h2>📦 آپلود محصولات</h2>';
echo '<table>';
echo '<tr><th>ردیف</th><th>نام</th><th>قیمت</th><th>دسته</th><th>وضعیت</th></tr>';

$count = 0;
$success = 0;

foreach ($products as $product) {
    $count++;
    $name = $product[0];
    $price = $product[1];
    $category = $product[2];
    $desc = $product[3];
    $weight = $product[4];
    $stock = $product[5];

    // بررسی موجود بودن
    $existing = get_page_by_title($name, OBJECT, 'product');

    if ($existing) {
        echo '<tr><td>' . $count . '</td><td>' . $name . '</td><td>' . number_format($price) . '</td><td>' . $category . '</td><td style="color: orange;">⚠️ موجود</td></tr>';
        continue;
    }

    // ایجاد محصول
    $product_id = wp_insert_post([
        'post_title' => $name,
        'post_content' => $desc,
        'post_type' => 'product',
        'post_status' => 'publish',
    ]);

    if ($product_id && !is_wp_error($product_id)) {
        update_post_meta($product_id, '_regular_price', $price);
        update_post_meta($product_id, '_price', $price);
        update_post_meta($product_id, '_stock', $stock);
        update_post_meta($product_id, '_manage_stock', 'yes');
        update_post_meta($product_id, '_stock_status', ($stock > 0) ? 'instock' : 'outofstock');
        update_post_meta($product_id, '_weight', $weight);
        update_post_meta($product_id, '_visibility', 'visible');

        wp_set_object_terms($product_id, 'simple', 'product_type');

        // دسته
        $cat = term_exists($category, 'product_cat');
        if (!$cat) {
            $cat = wp_insert_term($category, 'product_cat');
        }
        if (!is_wp_error($cat)) {
            wp_set_object_terms($product_id, (int)$cat['term_id'], 'product_cat');
        }

        echo '<tr><td>' . $count . '</td><td>' . $name . '</td><td>' . number_format($price) . '</td><td>' . $category . '</td><td style="color: green;">✅ اضافه:</td></tr>';
        $success++;
    } else {
        echo '<tr><td>' . $count . '</td><td>' . $name . '</td><td>' . number_format($price) . '</td><td>' . $category . '</td><td style="color: red;">❌ خطا</td></tr>';
    }
}

echo '</table>';

echo '<div class="success">✅ ' . $success . ' محصول از ' . count($products) . ' آپلود شد</div>';

$total_products = wp_count_posts('product')->publish;
echo '<div class="success"><strong>📊 کل محصولات: ' . $total_products . '</strong></div>';

echo '<div style="margin-top: 20px; text-align: center;">
    <a href="' . admin_url('edit.php?post_type=product') . '" style="padding: 10px 20px; background: #3498db; color: white; text-decoration: none; border-radius: 5px; display: inline-block;">
    📋 رفتن به لیست محصولات
    </a>
    &nbsp;&nbsp;&nbsp;
    <a href="' . site_url('/shop') . '" style="padding: 10px 20px; background: #27ae60; color: white; text-decoration: none; border-radius: 5px; display: inline-block;">
    🛒 مشاهده فروشگاه
    </a>
</div>';

echo '</div>';
?>
