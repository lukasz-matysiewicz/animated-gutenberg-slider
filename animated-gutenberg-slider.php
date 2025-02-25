<?php
/**
 * Plugin Name: Animated Gutenberg Slider
 * Plugin URI: https://matysiewicz.studio
 * Description: Create beautiful infinite sliders for Gutenberg columns. Transform your column blocks into smooth, professional sliders with GSAP animations. Perfect for logo carousels, partner showcases, and sliding content. Features include: infinite scrolling, grayscale effect, pause on hover, customizable speed and direction.
 * Version: 1.0.4
 * Author: Matysiewicz Studio
 * Author URI: https://matysiewicz.studio
 * License: GPL v2 or later
 * Text Domain: animated-gutenberg-slider
 * Domain Path: /languages
 */
if (!defined('WPINC')) {
    die;
}
if ( ! function_exists( 'ags_fs' ) ) {
    // Create a helper function for easy SDK access.
    function ags_fs() {
        global $ags_fs;

        if ( ! isset( $ags_fs ) ) {
            // Include Freemius SDK.
            require_once dirname( __FILE__ ) . '/vendor/freemius/start.php';
            $ags_fs = fs_dynamic_init( array(
                'id'                  => '17998',
                'slug'                => 'animated-gutenberg-slider',
                'type'                => 'plugin',
                'public_key'          => 'pk_3ba60898184252cceb054c5e63b94',
                'is_premium'          => true,
                'is_premium_only'     => true,
                'has_addons'          => false,
                'has_paid_plans'      => true,
                'menu'                => array(
                    'slug'       => 'animated-gutenberg-slider',
                    'contact'    => true,
                    'support'    => false,
                    'pricing'    => false,
                    'account'    => true,
                    'parent'     => array(
                        'slug' => 'animated-gutenberg-slider',
                    ),
                ),
                'is_live'            => true,
                'premium_suffix'      => '',
                'info'               => array(
                    'description'     => 'Upgrade Animated Gutenberg Slider to sddd latest.',
                    'short_description' => 'Create beautiful infinite sliders for Gutenberg columns. Transform your column blocks into smooth, professional sliders with GSAP animations. Perfect for logo carousels, partner showcases, and sliding content.',
                    'author'          => 'Matysiewicz Studio',
                    'author_uri'      => 'https://matysiewicz.studio',
                    'plugin_uri'      => 'https://ags.matysiewicz.studio',
                    'version'         => '1.0.4',
                    'support_email'   => 'support@matysiewicz.studio',
                )
            ) );
        }

        return $ags_fs;
    }

    // Init Freemius.
    ags_fs();
    // Signal that SDK was initiated.
    do_action( 'ags_fs_loaded' );
}

define('AGS_VERSION', '1.0.4');
define('AGS_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('AGS_PLUGIN_URL', plugin_dir_url(__FILE__));

// Initialize the plugin
require_once AGS_PLUGIN_DIR . 'includes/core/ags-init.php';

function run_ags() {
    $plugin = new AGS\Core\AGS_Init();
    $plugin->run();
}

run_ags();