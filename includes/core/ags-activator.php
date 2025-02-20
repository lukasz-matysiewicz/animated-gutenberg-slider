<?php
namespace AGS\Core;
if (!defined('ABSPATH')) {
    exit('Direct access not allowed.');
}

class AGS_Activator {
    public static function activate() {
        $default_options = array(
            'animation_duration' => 30,
            'animation_direction' => 'left',
            'use_grayscale' => true,
            'animation_style' => 'group'
        );

        if (!get_option('ags_settings')) {
            add_option('ags_settings', $default_options);
        }
        
        add_option('ags_version', AGS_VERSION);
        flush_rewrite_rules();
    }
}