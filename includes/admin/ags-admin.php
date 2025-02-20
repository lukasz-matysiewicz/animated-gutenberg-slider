<?php
namespace AGS\Admin;
if (!defined('ABSPATH')) {
    exit('Direct access not allowed.');
}

class AGS_Admin {
    public function __construct() {
        add_action('admin_menu', [$this, 'add_plugin_page']);
        add_action('admin_init', [$this, 'register_settings']);
    }

    public function add_plugin_page() {
        add_menu_page(
            __('Animated Gutenberg Slider', 'animated-gutenberg-slider'),
            __('AG Slider', 'animated-gutenberg-slider'),
            'manage_options',
            'animated-gutenberg-slider',
            [$this, 'render_admin_page'],
            'dashicons-slides',
            30
        );
    }

    public function register_settings() {
        register_setting(
            'ags_options',
            'ags_settings',
            [
                'type' => 'array',
                'sanitize_callback' => [$this, 'sanitize_settings'],
                'default' => [
                    'animation_duration' => 30,
                    'animation_direction' => 'left',
                    'use_grayscale' => true,
                    'animation_style' => 'group'
                ]
            ]
        );
    }

    public function sanitize_settings($input) {
        $sanitized = [];
        
        // Animation settings
        $sanitized['animation_duration'] = isset($input['animation_duration']) ? 
            min(60, max(1, absint($input['animation_duration']))) : 30;
        
        $sanitized['animation_direction'] = isset($input['animation_direction']) && 
            in_array($input['animation_direction'], ['left', 'right']) ? 
            $input['animation_direction'] : 'left';
        
        $sanitized['use_grayscale'] = !empty($input['use_grayscale']);
        
        // Style variables
        $sanitized['gap_width'] = isset($input['gap_width']) ? 
            min(100, max(0, absint($input['gap_width']))) : 40;
        
        $sanitized['logo_width'] = isset($input['logo_width']) ? 
            min(500, max(50, absint($input['logo_width']))) : 150;
        
        $sanitized['logo_height'] = isset($input['logo_height']) ? 
            min(500, max(0, absint($input['logo_height']))) : 55;
        
        $sanitized['mobile_logo_width'] = isset($input['mobile_logo_width']) ? 
            min(300, max(30, absint($input['mobile_logo_width']))) : 100;
        
        $sanitized['transition_duration'] = isset($input['transition_duration']) ? 
            min(2, max(0.1, floatval($input['transition_duration']))) : 0.3;
        
        return $sanitized;
    }

    public function render_admin_page() {
        // Get current settings
        $settings = get_option('ags_settings', [
            'animation_duration' => 30,
            'animation_direction' => 'left',
            'use_grayscale' => true,
            'animation_style' => 'group'
        ]);
        
        // Include the admin view
        require_once AGS_PLUGIN_DIR . 'includes/admin/views/ags-admin.php';
    }
}