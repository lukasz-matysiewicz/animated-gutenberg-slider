<?php
/**
 * Plugin Name: Animated Gutenberg Slider
 * Plugin URI: https://matysiewicz.studio
 * Description: Create beautiful infinite sliders for Gutenberg columns. Transform your column blocks into smooth, professional sliders with GSAP animations. Perfect for logo carousels, partner showcases, and sliding content. Features include: infinite scrolling, grayscale effect, pause on hover, customizable speed and direction.
 * Version: 1.1.0
 * Author: Matysiewicz Studio
 * Author URI: https://matysiewicz.studio
 * License: GPL v2 or later
 * Text Domain: animated-gutenberg-slider
 * Domain Path: /languages
 */
if (!defined('WPINC')) {
    die;
}

define('AGS_VERSION', '1.1.0');
define('AGS_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('AGS_PLUGIN_URL', plugin_dir_url(__FILE__));
// define('AGS_DEBUG', false);

// Activation / deactivation
require_once AGS_PLUGIN_DIR . 'includes/core/ags-activator.php';
require_once AGS_PLUGIN_DIR . 'includes/core/ags-deactivator.php';

register_activation_hook(__FILE__, ['AGS\Core\AGS_Activator', 'activate']);
register_deactivation_hook(__FILE__, ['AGS\Core\AGS_Deactivator', 'deactivate']);

// Initialize the plugin
require_once AGS_PLUGIN_DIR . 'includes/core/ags-init.php';

function run_ags() {
    $plugin = new AGS\Core\AGS_Init();
    $plugin->run();
}

run_ags();