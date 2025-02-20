<?php
namespace AGS\Core;

class AGS_Assets {
    private $gsap_version = '3.12.2';

    public function __construct() {
        add_action('wp_enqueue_scripts', [$this, 'register_frontend_assets']);
        add_action('admin_enqueue_scripts', [$this, 'register_admin_assets']);
    }

    public function register_frontend_assets() {
        // Register GSAP Core
        wp_enqueue_script(
            'gsap',
            'https://cdnjs.cloudflare.com/ajax/libs/gsap/' . $this->gsap_version . '/gsap.min.js',
            [],
            $this->gsap_version,
            true
        );
    
        // Register public styles
        wp_enqueue_style(
            'ags-public',
            AGS_PLUGIN_URL . 'assets/css/ags-public.css',
            [],
            AGS_VERSION
        );
    
        // Get saved settings with defaults
        $saved_settings = get_option('ags_settings', [
            'animation_duration' => 30,
            'animation_direction' => 'left',
            'use_grayscale' => true,
            'gap_width' => 40,
            'logo_width' => 150,
            'mobile_logo_width' => 100
        ]);
    
        // Add inline CSS variables
        $custom_css = sprintf(
            '.cgs-container {
                --ags-gap-width: %dpx;
                --ags-logo-width: %dpx;
                --ags-mobile-logo-width: %dpx;
            }',
            $saved_settings['gap_width'],
            $saved_settings['logo_width'],
            $saved_settings['mobile_logo_width']
        );
    
        wp_add_inline_style('ags-public', $custom_css);
    
        // Animation settings for JavaScript
        $animation_settings = [
            'duration' => absint($saved_settings['animation_duration']),
            'direction' => $saved_settings['animation_direction'],
            'useGrayscale' => (bool)$saved_settings['use_grayscale']
        ];
    
        // Register public script
        wp_enqueue_script(
            'ags-public',
            AGS_PLUGIN_URL . 'assets/js/ags-public.js',
            ['jquery', 'gsap'],
            AGS_VERSION,
            true
        );
    
        // Pass settings to JavaScript
        wp_localize_script('ags-public', 'agsSettings', $animation_settings);
    }

    public function register_admin_assets($hook) {
        if (strpos($hook, 'animated-gutenberg-slider') === false) {
            return;
        }

        wp_enqueue_style(
            'ags-admin',
            AGS_PLUGIN_URL . 'assets/css/ags-admin.css',
            [],
            AGS_VERSION
        );

        wp_enqueue_script(
            'ags-admin',
            AGS_PLUGIN_URL . 'assets/js/ags-admin.js',
            ['jquery'],
            AGS_VERSION,
            true
        );
    }
}