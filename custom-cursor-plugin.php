<?php
/**
 * Plugin Name: Custom Cursor Plugin
 * Description: Replace the default mouse cursor with a custom image.
 * Version: 1.0.0
 * Requires at least: 5.0
 * Requires PHP: 7.2
 * Author: Kashif Watto
 * Author URI: https://kashifwatto.com/
 * License: GPLv2 or later
 * Text Domain: custom-cursor-plugin
 */

if (!defined('ABSPATH')) exit;

define('CCP_PATH', plugin_dir_path(__FILE__));
define('CCP_URL', plugin_dir_url(__FILE__));

require_once CCP_PATH . 'includes/class-ccp-settings.php';

/**
 * Allow SVG upload (Admin only)
 */
add_filter('upload_mimes', function ($mimes) {
    if (current_user_can('manage_options')) {
        $mimes['svg'] = 'image/svg+xml';
    }
    return $mimes;
});

add_action('plugins_loaded', function () {
    new CCP_Settings();
});
