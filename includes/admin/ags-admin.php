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
        // Use add_settings_section and add_settings_field approach
        add_settings_section(
            'ags_general_settings',
            __('General Settings', 'animated-gutenberg-slider'),
            '__return_false',
            'animated-gutenberg-slider'
        );

        // Register individual settings without schema in register_setting
        register_setting(
            'ags_options',
            'ags_settings',
            [
                'type' => 'array',
                'sanitize_callback' => [$this, 'sanitize_settings'],
                'default' => $this->get_default_settings()
            ]
        );
        
        // Register individual fields for animation settings
        add_settings_field(
            'animation_duration',
            __('Animation Duration', 'animated-gutenberg-slider'),
            [$this, 'render_number_field'],
            'animated-gutenberg-slider',
            'ags_general_settings',
            [
                'field' => 'animation_duration',
                'min' => 1,
                'max' => 60,
                'default' => 30
            ]
        );
        
        add_settings_field(
            'animation_direction',
            __('Animation Direction', 'animated-gutenberg-slider'),
            [$this, 'render_radio_field'],
            'animated-gutenberg-slider',
            'ags_general_settings',
            [
                'field' => 'animation_direction',
                'options' => [
                    'left' => __('Slide to Left', 'animated-gutenberg-slider'),
                    'right' => __('Slide to Right', 'animated-gutenberg-slider')
                ],
                'default' => 'left'
            ]
        );
        
        // Continue with other fields...
    }
    
    /**
     * Helper method to render number input field
     */
    public function render_number_field($args) {
        $field = $args['field'];
        $min = isset($args['min']) ? $args['min'] : 0;
        $max = isset($args['max']) ? $args['max'] : 100;
        $default = isset($args['default']) ? $args['default'] : 0;
        
        $settings = get_option('ags_settings', $this->get_default_settings());
        $value = isset($settings[$field]) ? $settings[$field] : $default;
        
        printf(
            '<input type="number" id="%1$s" name="ags_settings[%1$s]" value="%2$s" min="%3$s" max="%4$s" class="ags-input">',
            esc_attr($field),
            esc_attr($value),
            esc_attr($min),
            esc_attr($max)
        );
    }
    
    /**
     * Helper method to render radio button field
     */
    public function render_radio_field($args) {
        $field = $args['field'];
        $options = $args['options'];
        $default = isset($args['default']) ? $args['default'] : '';
        
        $settings = get_option('ags_settings', $this->get_default_settings());
        $value = isset($settings[$field]) ? $settings[$field] : $default;
        
        echo '<div class="ags-radio-group">';
        foreach ($options as $option_value => $option_label) {
            printf(
                '<label class="ags-radio-label"><input type="radio" name="ags_settings[%1$s]" value="%2$s" %3$s> %4$s</label>',
                esc_attr($field),
                esc_attr($option_value),
                checked($value, $option_value, false),
                esc_html($option_label)
            );
        }
        echo '</div>';
    }
    
    /**
     * Get default settings
     * 
     * @return array Default plugin settings
     */
    public function get_default_settings() {
        return [
            'animation_duration' => 30,
            'animation_direction' => 'left',
            'use_grayscale' => true,
            'pause_on_hover' => true,
            'animation_style' => 'group',
            'gap_width' => 40,
            'logo_width' => 150,
            'mobile_logo_width' => 100,
            'transition_duration' => 0.3
        ];
    }
    
    /**
     * Sanitize all settings
     *
     * @param array $input The settings array to sanitize
     * @return array Sanitized settings
     */
    public function sanitize_settings($input) {
        if (!is_array($input)) {
            return $this->get_default_settings();
        }
        
        $sanitized = [];
        
        // Animation duration (seconds) - integer between 1-60
        $sanitized['animation_duration'] = isset($input['animation_duration']) ? 
            intval($input['animation_duration']) : 30;
        $sanitized['animation_duration'] = min(60, max(1, $sanitized['animation_duration']));
        
        // Animation direction - enum: left or right
        $allowed_directions = ['left', 'right'];
        $sanitized['animation_direction'] = isset($input['animation_direction']) && 
            in_array($input['animation_direction'], $allowed_directions, true) ? 
            sanitize_text_field($input['animation_direction']) : 'left';
        
        // Boolean settings
        $sanitized['use_grayscale'] = !empty($input['use_grayscale']);
        $sanitized['pause_on_hover'] = !empty($input['pause_on_hover']);
        
        // Gap width (px) - integer between 0-100
        $sanitized['gap_width'] = isset($input['gap_width']) ? 
            intval($input['gap_width']) : 40;
        $sanitized['gap_width'] = min(100, max(0, $sanitized['gap_width']));
        
        // Logo width (px) - integer between 50-500
        $sanitized['logo_width'] = isset($input['logo_width']) ? 
            intval($input['logo_width']) : 150;
        $sanitized['logo_width'] = min(500, max(50, $sanitized['logo_width']));
        
        // Logo height (px) - integer between 0-500 (0 means auto)
        $sanitized['logo_height'] = isset($input['logo_height']) ? 
            intval($input['logo_height']) : 0;
        $sanitized['logo_height'] = min(500, max(0, $sanitized['logo_height']));
        
        // Mobile logo width (px) - integer between 30-300
        $sanitized['mobile_logo_width'] = isset($input['mobile_logo_width']) ? 
            intval($input['mobile_logo_width']) : 100;
        $sanitized['mobile_logo_width'] = min(300, max(30, $sanitized['mobile_logo_width']));
        
        // Transition duration (seconds) - float between 0.1-2.0
        $sanitized['transition_duration'] = isset($input['transition_duration']) ? 
            (float) $input['transition_duration'] : 0.3;
        $sanitized['transition_duration'] = min(2.0, max(0.1, $sanitized['transition_duration']));
        
        // Animation style - defaults to 'group' if invalid
        $allowed_styles = ['group', 'individual'];
        $sanitized['animation_style'] = isset($input['animation_style']) && 
            in_array($input['animation_style'], $allowed_styles, true) ? 
            sanitize_text_field($input['animation_style']) : 'group';
        
        // Filter the sanitized settings
        return apply_filters('ags_sanitized_settings', $sanitized, $input);
    }

    public function render_admin_page() {
        // Get current settings
        $settings = get_option('ags_settings', $this->get_default_settings());
        
        // Include the admin view
        require_once AGS_PLUGIN_DIR . 'includes/admin/views/ags-admin.php';
    }
}