<?php
// WordPress Fruit Shop Auto Installer
// This script will automatically install WordPress with WooCommerce and fruit shop data

// Database configuration - UPDATE THESE VALUES
$db_name = 'your_database_name';
$db_user = 'your_database_user';
$db_pass = 'your_database_password';
$db_host = 'localhost';

// Site configuration
$site_url = 'http://delip.ir/shop';
$site_title = 'میوه‌فروشی آنلاین';
$admin_user = 'admin';
$admin_pass = 'admin123';
$admin_email = 'admin@delip.ir';

// Download WordPress
echo "Downloading WordPress Persian...\n";
$wp_zip = file_get_contents('https://fa.wordpress.org/latest-fa_IR.zip');
file_put_contents('wordpress-fa.zip', $wp_zip);

// Extract WordPress
$zip = new ZipArchive;
if ($zip->open('wordpress-fa.zip') === TRUE) {
    $zip->extractTo('./');
    $zip->close();
    echo "WordPress extracted successfully\n";
} else {
    echo "Failed to extract WordPress\n";
}

// Create wp-config.php
$wp_config = "<?php\n";
$wp_config .= "define('DB_NAME', '$db_name');\n";
$wp_config .= "define('DB_USER', '$db_user');\n";
$wp_config .= "define('DB_PASSWORD', '$db_pass');\n";
$wp_config .= "define('DB_HOST', '$db_host');\n";
$wp_config .= "define('DB_CHARSET', 'utf8mb4');\n";
$wp_config .= "define('DB_COLLATE', 'utf8mb4_persian_ci');\n";
$wp_config .= "\n";
$wp_config .= "define('AUTH_KEY',         '" . wp_generate_password(64, true) . "');\n";
$wp_config .= "define('SECURE_AUTH_KEY',  '" . wp_generate_password(64, true) . "');\n";
$wp_config .= "define('LOGGED_IN_KEY',     '" . wp_generate_password(64, true) . "');\n";
$wp_config .= "define('NONCE_KEY',         '" . wp_generate_password(64, true) . "');\n";
$wp_config .= "\n";
$wp_config .= "\$table_prefix = 'wp_';\n";
$wp_config .= "\n";
$wp_config .= "define('WP_DEBUG', false);\n";
$wp_config .= "\n";
$wp_config .= "if ( !defined('ABSPATH') )\n";
$wp_config .= "    define('ABSPATH', dirname(__FILE__) . '/');\n";
$wp_config .= "\n";
$wp_config .= "require_once(ABSPATH . 'wp-settings.php');\n";

file_put_contents('wordpress/wp-config.php', $wp_config);

echo "WordPress configuration created!\n";
echo "Next steps:\n";
echo "1. Upload the 'wordpress' folder to your host\n";
echo "2. Visit $site_url to complete installation\n";
echo "3. Install WooCommerce plugin\n";
echo "4. Import fruit shop data\n";
?>
