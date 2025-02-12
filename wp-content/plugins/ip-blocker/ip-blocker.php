<?php
/**
 * Plugin Name: IP Blocker
 * Description: Redirects users away if their IP starts with 77.29.
 * Version: 1.0
 * Author: Fasih
 */

if (!defined('ABSPATH')) {
    exit; // Prevent direct access
}

function ip_block_redirect() {
    $user_ip = $_SERVER['REMOTE_ADDR']; // Get user IP

    if (strpos($user_ip, '77.29') === 0) { // Check if IP starts with 77.29
        wp_redirect('https://www.google.com'); // Redirect (change URL as needed)
        exit;
    }
}

add_action('template_redirect', 'ip_block_redirect');
