<?php
/**
 * Fired when the plugin is uninstalled.
 */
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

delete_option('ags_settings');
delete_option('ags_version');
