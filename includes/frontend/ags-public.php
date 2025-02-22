<?php
namespace AGS\Frontend;
if (!defined('ABSPATH')) {
    exit('Direct access not allowed.');
}

class AGS_Slider {
    private $slider;

    public function __construct() {
        add_filter('render_block', [$this, 'modify_columns_block'], 10, 2);
        $this->slider = new AGS_Slider();
    }

    class AGS_Slider {
        public function modify_columns_block($block_content, $block) {
            if ($block['blockName'] !== 'core/columns') {
                return $block_content;
            }
        
            $settings = get_option('ags_settings', [
                'animation_duration' => 30,
                'animation_direction' => 'left',
                'use_grayscale' => true,
                'pause_on_hover' => true,
                'gap_width' => 40,
                'logo_width' => 150,
                'mobile_logo_width' => 100,
                'transition_duration' => 0.3
            ]);
        
            // Create container with inline styles and data attributes
            $output = sprintf(
                '<div class="ags-container" 
                    style="
                        --ags-gap-width: %dpx;
                        --ags-logo-width: %dpx;
                        --ags-mobile-logo-width: %dpx;
                        --ags-transition-duration: %ss;
                    "
                    data-settings="%s">
                    %s
                </div>',
                intval($settings['gap_width']),
                intval($settings['logo_width']),
                intval($settings['mobile_logo_width']),
                number_format($settings['transition_duration'], 1),
                esc_attr(json_encode([
                    'direction' => $settings['animation_direction'],
                    'duration' => intval($settings['animation_duration']),
                    'useGrayscale' => (bool) $settings['use_grayscale']
                ])),
                $block_content
            );
        
            return $output;
        }
    }
}