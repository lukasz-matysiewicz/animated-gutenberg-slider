<?php
namespace AGS\Frontend;
if (!defined('ABSPATH')) {
    exit('Direct access not allowed.');
}

class AGS_Public {
    public function __construct() {
        add_action('wp_enqueue_scripts', [$this, 'register_assets']);
    }

    public function register_assets() {
        // Frontend assets are handled by AGS_Assets class
    }
}