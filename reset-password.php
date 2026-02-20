<?php
require_once('wp-config.php');
require_once('wp-blog-header.php');

// Reset admin password to '123456'
$user = get_user_by('login', 'admin');
if ($user) {
    wp_set_password('123456', $user->ID);
    echo "Password reset successfully! New password: 123456";
} else {
    echo "Admin user not found!";
}
?>
