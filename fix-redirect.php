<?php
/**
 * 🔧 اسکریپت حل redirect loop
 * 
 * آپ لود: /public_html/fix-redirect.php
 * اجرا: http://mivesf.ir/fix-redirect.php
 * یا: https://mivesf.ir/fix-redirect.php
 */

// Header
header('Content-Type: text/html; charset=utf-8');

// Suppress errors for now
error_reporting(0);

define('WP_ROOT', dirname(__FILE__));

?>
<!DOCTYPE html>
<html dir="rtl" lang="fa">
<head>
    <meta charset="UTF-8">
    <title>حل مسئله Redirect Loop</title>
    <style>
        body { font-family: Arial; direction: rtl; padding: 20px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; }
        h1 { color: #d32f2f; }
        .solution { padding: 15px; margin: 10px 0; border-left: 4px solid #1976d2; background: #e3f2fd; }
        .success { background: #c8e6c9; border-left-color: #388e3c; color: #1b5e20; }
        .info { background: #fff9c4; border-left-color: #f57f17; color: #332701; }
        code { background: #f5f5f5; padding: 2px 6px; border-radius: 3px; }
    </style>
</head>
<body>

<div class="container">
    <h1>🔧 حل مسئله Redirect Loop</h1>
    <p style="color: red;"><strong>مسئله:</strong> mivesf.ir بار و بار redirect می‌کند</p>

<?php

// Solution 1: Check if wp-config exists
echo '<h2>حل ۱: بررسی WordPress</h2>';

if (!file_exists(WP_ROOT . '/wp-config.php')) {
    echo '<div class="solution" style="background: #ffebee; border-left-color: #d32f2f; color: #b71c1c;">';
    echo '❌ فایل wp-config.php پیدا نشد!<br>';
    echo 'WordPress بر روی سرور نصب نشده است.';
    echo '</div>';
} else {
    echo '<div class="solution success">✅ WordPress نصب شده است</div>';
    
    // Read wp-config
    $wp_config = file_get_contents(WP_ROOT . '/wp-config.php');
    
    // Check for protocol
    if (strpos($wp_config, "define('WP_HOME'") !== false || strpos($wp_config, "define('SITEURL'") !== false) {
        echo '<div class="solution info">✅ wp-config.php دارای تنظیمات سفارشی است</div>';
    }
}

// Solution 2: Create .htaccess
echo '<h2>حل ۲: درست کردن .htaccess</h2>';

$htaccess_file = WP_ROOT . '/.htaccess';

// Create a clean .htaccess without forcing HTTPS
$htaccess_content = <<<'EOD'
# BEGIN WordPress
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase /
RewriteRule ^index\.html$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /index.php [L]
</IfModule>
# END WordPress
EOD;

// Try to write .htaccess
if (@file_put_contents($htaccess_file, $htaccess_content)) {
    echo '<div class="solution success">✅ فایل .htaccess بروز شد</div>';
} else {
    echo '<div class="solution info">⚠️ نتوانستیم .htaccess را بروز کنیم (اختیاری)</div>';
}

// Solution 3: Load WordPress and fix options
echo '<h2>حل ۳: تنظیمات WordPress</h2>';

if (file_exists(WP_ROOT . '/wp-load.php')) {
    // Load WordPress (suppress output)
    ob_start();
    require_once(WP_ROOT . '/wp-load.php');
    ob_end_clean();
    
    if (function_exists('get_option')) {
        echo '<div class="solution success">✅ WordPress بارگذاری شد</div>';
        
        // Get current configuration
        $siteurl = get_option('siteurl');
        $home = get_option('home');
        
        echo '<h3>تنظیمات فعلی:</h3>';
        echo '<div class="solution info">';
        echo 'siteurl: <code>' . htmlspecialchars($siteurl) . '</code><br>';
        echo 'home: <code>' . htmlspecialchars($home) . '</code>';
        echo '</div>';
        
        // Detect protocol
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
        $domain = 'mivesf.ir';
        $correct_url = $protocol . $domain;
        
        echo '<h3>تنظیمات صحیح باید باشدند:</h3>';
        echo '<div class="solution info">';
        echo 'siteurl: <code>' . htmlspecialchars($correct_url) . '</code><br>';
        echo 'home: <code>' . htmlspecialchars($correct_url) . '</code>';
        echo '</div>';
        
        // Check for mismatches
        if ($siteurl !== $correct_url || $home !== $correct_url) {
            echo '<h3>🔧 رفع مسئله:</h3>';
            
            // Try to update options
            if (update_option('siteurl', $correct_url) && update_option('home', $correct_url)) {
                echo '<div class="solution success">';
                echo '✅ تنظیمات درست شدند!<br>';
                echo 'siteurl و home اکنون: <code>' . htmlspecialchars($correct_url) . '</code>';
                echo '</div>';
            } else {
                echo '<div class="solution info">';
                echo '⚠️ نتوانستیم تنظیمات را بروز کنیم.<br>';
                echo 'روش دستی:<br>';
                echo '1. phpMyAdmin > Database > wp_options<br>';
                echo '2. سطر siteurl را پیدا کن و مقدار را به: <code>' . htmlspecialchars($correct_url) . '</code> تغییر بده<br>';
                echo '3. سطر home را پیدا کن و مقدار را به: <code>' . htmlspecialchars($correct_url) . '</code> تغییر بده';
                echo '</div>';
            }
        } else {
            echo '<div class="solution success">✅ تنظیمات درست هستند</div>';
        }
        
        // Clear cache
        echo '<h3>تمیز کردن کش:</h3>';
        if (function_exists('wp_cache_flush')) {
            wp_cache_flush();
            echo '<div class="solution success">✅ کش پاک شد</div>';
        }
        
    } else {
        echo '<div class="solution" style="background: #ffebee; border-left-color: #d32f2f; color: #b71c1c;">';
        echo '❌ نتوانستیم WordPress را بارگذاری کنیم';
        echo '</div>';
    }
} else {
    echo '<div class="solution" style="background: #ffebee; border-left-color: #d32f2f; color: #b71c1c;">';
    echo '❌ فایل wp-load.php پیدا نشد';
    echo '</div>';
}

// Final instructions
echo '<h2>📋 مراحل بعدی:</h2>';
echo '<div class="solution info">';
echo '<strong>۱. کش مرورگر را پاک کن:</strong><br>';
echo '• در مرورگر: Ctrl+Shift+Delete (یا Command+Shift+Delete در Mac)<br>';
echo '• "Cookies" و "Cache" را انتخاب کن<br>';
echo '• برای "All time" و "All sites" انتخاب کن<br><br>';

echo '<strong>۲. دوباره وارد شو:</strong><br>';
echo '👉 <code>http://mivesf.ir</code> یا<br>';
echo '👉 <code>https://mivesf.ir</code>';
echo '</div>';

// Cleanup
echo '<h2>🧹 پاک‌سازی:</h2>';
echo '<div class="solution info">';
echo 'پس از اینکه مشکل حل شد، این فایل را حذف کن:<br>';
echo '<code>fix-redirect.php</code>';
echo '</div>';

?>

</div>

</body>
</html>

<?php
// End
?>
