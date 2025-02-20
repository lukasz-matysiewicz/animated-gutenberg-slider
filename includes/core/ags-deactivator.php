<?php
namespace AGS\Core;
if (!defined('ABSPATH')) {
    exit('Direct access not allowed.');
}

class AGS_Deactivator {
    public static function deactivate() {
        // Cleanup if needed
        flush_rewrite_rules();
    }
}