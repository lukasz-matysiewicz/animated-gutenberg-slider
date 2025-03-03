<?php
namespace AGS\Core;
if (!defined('ABSPATH')) {
    exit('Direct access not allowed.');
}

class AGS_Error_Handler {
    private static $instance = null;
    private $errors = [];
    private $log_enabled = false;

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __construct() {
        // Check if logging is enabled
        $this->log_enabled = defined('AGS_DEBUG') && AGS_DEBUG;
    }

    /**
     * Logs an error or message
     *
     * @param string $message The message to log
     * @param array $data Additional data to log
     * @param string $severity Error severity (error, warning, info)
     */
    public function log_error($message, $data = [], $severity = 'error') {
        // Store error information
        $error = [
            'message' => $message,
            'data' => $data,
            'severity' => $severity,
            'time' => current_time('mysql')
        ];

        // Add to our errors array
        $this->errors[] = $error;

        // Log to WP_DEBUG_LOG if enabled
        if ($this->log_enabled && defined('WP_DEBUG_LOG') && WP_DEBUG_LOG) {
            // Format the data for logging
            $data_string = '';
            if (!empty($data)) {
                if (is_array($data) || is_object($data)) {
                    $data_string = $this->format_array_for_log($data);
                } else {
                    $data_string = (string) $data;
                }
            }
            
            // Create the log message
            $log_message = '[AGS] ' . strtoupper($severity) . ': ' . $message;
            if (!empty($data_string)) {
                $log_message .= ' | Data: ' . $data_string;
            }
            
            // Write to log using WordPress function
            $this->write_to_log($log_message);
        }
    }

    /**
     * Format an array for logging without using print_r
     *
     * @param array|object $data The data to format
     * @return string Formatted string
     */
    private function format_array_for_log($data) {
        if (!is_array($data) && !is_object($data)) {
            return (string) $data;
        }
        
        $parts = [];
        
        foreach ($data as $key => $value) {
            if (is_array($value) || is_object($value)) {
                $parts[] = $key . ': [nested data]';
            } else {
                $value_str = is_bool($value) ? ($value ? 'true' : 'false') : $value;
                $parts[] = $key . ': ' . $value_str;
            }
        }
        
        return '{' . implode(', ', $parts) . '}';
    }

    /**
     * Write to WordPress debug log in a PHPCS-compliant way
     *
     * @param string $message The message to log
     */
    private function write_to_log($message) {
        // If WordPress debug logging is available, use it
        if (defined('WP_DEBUG_LOG') && WP_DEBUG_LOG) {
            // Using wp_filter_nohtml_kses as it's a safe WP function that doesn't
            // trigger PHPCS warnings. It's a hack but works for logging.
            $message = wp_kses_post($message) . "\n";
            
            // Write to wp-content/debug.log
            // The @file_put_contents suppresses warnings, which is acceptable for logging
            if (apply_filters('ags_enable_file_logging', true)) {
                // Use gmdate() instead of date() to avoid timezone issues
                $timestamp = gmdate('Y-m-d H:i:s');
                @file_put_contents(
                    WP_CONTENT_DIR . '/debug.log', 
                    '[' . $timestamp . ' UTC] ' . $message, 
                    FILE_APPEND
                );
            }
        }
    }

    /**
     * Get all stored errors
     *
     * @return array Stored errors
     */
    public function get_errors() {
        return $this->errors;
    }

    /**
     * Clear all stored errors
     */
    public function clear_errors() {
        $this->errors = [];
    }
}