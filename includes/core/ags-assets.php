<?php
namespace AGS\Core;
if (!defined('ABSPATH')) {
    exit('Direct access not allowed.');
}

class AGS_Assets {
    private $gsap_version = '3.12.2';

    public function __construct() {
        add_action('wp_enqueue_scripts', [$this, 'register_frontend_assets']);
        add_action('admin_enqueue_scripts', [$this, 'register_admin_assets']);
    }

    public function register_frontend_assets() {
        if (!$this->should_load_gallery_assets()) {
            return;
        }
    
        // Get settings
        $settings = get_option('ags_settings');

        // Ensure defaults are set
        $default_settings = [
            'animation_duration' => 30,
            'animation_direction' => 'left',
            'use_grayscale' => true,
            'pause_on_hover' => true,
            'gap_width' => 40,
            'logo_width' => 150,
            'mobile_logo_width' => 100,
            'transition_duration' => 0.3
        ];

        // Merge with defaults
        $settings = wp_parse_args($settings, $default_settings);

        // Register GSAP from local vendor folder
        wp_register_script(
            'gsap',
            AGS_PLUGIN_URL . 'assets/js/vendor/gsap.min.js',
            [],
            $this->gsap_version,
            true
        );

        // Register plugin styles and scripts
        wp_register_style('ags-public', AGS_PLUGIN_URL . 'assets/css/ags-public.css', [], AGS_VERSION);
        wp_register_script('ags-public', AGS_PLUGIN_URL . 'assets/js/ags-public.js', ['gsap'], AGS_VERSION, true);

        // Enqueue all assets
        wp_enqueue_style('ags-public');
        wp_enqueue_script('gsap');
        wp_enqueue_script('ags-public');

        // Expose settings to the stylesheet as CSS custom properties
        wp_add_inline_style('ags-public', sprintf(
            '.ags-container{--ags-gap-width:%dpx;--ags-logo-width:%dpx;--ags-mobile-logo-width:%dpx;--ags-transition-duration:%ss;}',
            intval($settings['gap_width']),
            intval($settings['logo_width']),
            intval($settings['mobile_logo_width']),
            number_format(floatval($settings['transition_duration']), 1)
        ));

        // Pass settings to JavaScript
        wp_localize_script('ags-public', 'agsSettings', [
            'pluginUrl' => AGS_PLUGIN_URL,
            'settings' => [
                'duration' => intval($settings['animation_duration']),
                'direction' => $settings['animation_direction'],
                'useGrayscale' => (bool) $settings['use_grayscale'],
                'pauseOnHover' => (bool) $settings['pause_on_hover'],
                'gapWidth' => intval($settings['gap_width']),
                'logoWidth' => intval($settings['logo_width']),
                'mobileLogoWidth' => intval($settings['mobile_logo_width'])
            ]
        ]);
    }

    public function register_admin_assets($hook) {
        if (strpos($hook, 'animated-gutenberg-slider') === false) {
            return;
        }

        // Register GSAP from local vendor folder
        wp_register_script(
            'gsap',
            AGS_PLUGIN_URL . 'assets/js/vendor/gsap.min.js',
            [],
            $this->gsap_version,
            true
        );

        // Register admin styles
        wp_enqueue_style(
            'ags-admin',
            AGS_PLUGIN_URL . 'assets/css/ags-admin.css',
            [],
            AGS_VERSION
        );

        // Register admin scripts with GSAP dependency
        wp_enqueue_script('gsap');
        wp_enqueue_script(
            'ags-admin',
            AGS_PLUGIN_URL . 'assets/js/ags-admin.js',
            ['jquery', 'gsap'],
            AGS_VERSION,
            true
        );

        // Pass plugin URL to JavaScript
        wp_localize_script('ags-admin', 'agsSettings', [
            'pluginUrl' => AGS_PLUGIN_URL
        ]);
    }

    private function should_load_gallery_assets() {
        // Skip if we're in admin
        if (is_admin()) {
            return false;
        }
    
        // Load on singular pages that actually contain a slider
        if (is_singular()) {
            global $post;

            // Check for our container class in content
            if ($post && strpos($post->post_content, 'ags-container') !== false) {
                return true;
            }
        }
    
        // Check for the class in widgets
        if ($this->check_widgets_for_slider()) {
            return true;
        }
    
        return false;
    }

    private function check_widgets_for_slider() {
        $sidebars_widgets = wp_get_sidebars_widgets();
        
        foreach ($sidebars_widgets as $sidebar => $widgets) {
            if (!is_array($widgets)) {
                continue;
            }
            
            foreach ($widgets as $widget_id) {
                $parsed_id = $this->parse_widget_id($widget_id);
                if (!$parsed_id) {
                    continue;
                }
                
                $widget_instance = get_option('widget_' . $parsed_id['base_id']);
                if (!$widget_instance || !isset($widget_instance[$parsed_id['number']]['content'])) {
                    continue;
                }
                
                $content = $widget_instance[$parsed_id['number']]['content'];
                
                // Check for our container class in widget content
                if (strpos($content, 'ags-container') !== false) {
                    return true;
                }
            }
        }
        
        return false;
    }

    private function parse_widget_id($widget_id) {
        if (preg_match('/^(.+)-(\d+)$/', $widget_id, $matches)) {
            return [
                'base_id' => $matches[1],
                'number' => $matches[2]
            ];
        }
        return false;
    }
}