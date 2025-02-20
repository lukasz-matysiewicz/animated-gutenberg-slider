<?php
namespace AGS\Core;
if (!defined('ABSPATH')) {
    exit('Direct access not allowed.');
}

class AGS_Init {
    protected $loader;

    public function __construct() {
        $this->load_dependencies();
        $this->init_components();
    }

    private function load_dependencies() {
        require_once AGS_PLUGIN_DIR . 'includes/core/ags-assets.php';
        require_once AGS_PLUGIN_DIR . 'includes/core/ags-error-handler.php';
        
        if (is_admin()) {
            require_once AGS_PLUGIN_DIR . 'includes/admin/ags-admin.php';
        }
    }

    private function init_components() {
        // Initialize core components
        new AGS_Assets();
        
        // Initialize admin if in admin area
        if (is_admin()) {
            new \AGS\Admin\AGS_Admin();
        }
    }

    public function run() {
        // Plugin initialization logic
        do_action('ags_init');
    }
}