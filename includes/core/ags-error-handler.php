<?php
namespace AGS\Core;
if (!defined('ABSPATH')) {
    exit('Direct access not allowed.');
}

class AGS_Error_Handler {
    private static $instance = null;
    private $errors = [];

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function log_error($message, $data = [], $severity = 'error') {
        $error = [
            'message' => $message,
            'data' => $data,
            'severity' => $severity,
            'time' => current_time('mysql'),
            'trace' => debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS)
        ];

        $this->errors[] = $error;

        if (defined('WP_DEBUG') && WP_DEBUG) {
            error_log(sprintf(
                '[AGS] %s: %s | Data: %s',
                strtoupper($severity),
                $message,
                print_r($data, true)
            ));
        }
    }

    public function get_errors() {
        return $this->errors;
    }

    public function clear_errors() {
        $this->errors = [];
    }
}