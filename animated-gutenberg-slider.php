<?php
/**
 * Plugin Name: Animated Gutenberg Slider
 * Plugin URI: https://matysiewicz.studio
 * Description: Create beautiful infinite sliders for Gutenberg columns
 * Version: 1.0.0
 * Author: Matysiewicz Studio
 * Author URI: https://matysiewicz.studio
 * License: GPL v2 or later
 * Text Domain: animated-gutenberg-slider
 * Domain Path: /languages
 */

if (!defined('WPINC')) {
    die;
}

define('AGS_VERSION', '1.0.0');
define('AGS_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('AGS_PLUGIN_URL', plugin_dir_url(__FILE__));

// Initialize the plugin
require_once AGS_PLUGIN_DIR . 'includes/core/ags-init.php';

function run_ags() {
    $plugin = new AGS\Core\AGS_Init();
    $plugin->run();
}

run_ags();