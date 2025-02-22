<?php
namespace AGS\Core;
if (!defined('ABSPATH')) {
    exit('Direct access not allowed.');
}

class AGS_Activator {
    public static function activate() {
        $default_options = [
            'animation_duration' => 30,
            'animation_direction' => 'left',
            'use_grayscale' => true,
            'pause_on_hover' => true,
            'gap_width' => 40,
            'logo_width' => 150,
            'mobile_logo_width' => 100,
            'transition_duration' => 0.3,
            'animation_style' => 'group'
        ];

        // Check if settings exist
        $existing_settings = get_option('ags_settings');
        
        if ($existing_settings === false) {
            // No settings exist, add new ones
            add_option('ags_settings', $default_options);
        } else {
            // Merge existing settings with defaults
            $merged_settings = wp_parse_args($existing_settings, $default_options);
            update_option('ags_settings', $merged_settings);
        }
        
        add_option('ags_version', AGS_VERSION);
        flush_rewrite_rules();
    }
}