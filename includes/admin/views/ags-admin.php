<div class="wrap ags-admin-wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    
    <form method="post" action="options.php">
        <?php 
        settings_fields('ags_options');
        
        // Define all defaults
        $defaults = [
            'animation_duration' => 30,
            'animation_direction' => 'left',
            'use_grayscale' => true,
            'gap_width' => 40,
            'logo_width' => 150,
            'mobile_logo_width' => 100
        ];
        
        // Get settings with defaults
        $settings = wp_parse_args(
            get_option('ags_settings', []),
            $defaults
        );
        ?>

        <!-- Animation Settings -->
        <div class="ags-section">
            <h2><?php _e('Animation Settings', 'animated-gutenberg-slider'); ?></h2>
            <table class="form-table">
                <tr>
                    <th><label for="animation_duration"><?php _e('Animation Duration / Speed (seconds)', 'animated-gutenberg-slider'); ?></label></th>
                    <td><input type="number" id="animation_duration" name="ags_settings[animation_duration]" value="<?php echo esc_attr($settings['animation_duration']); ?>" min="1" max="60" class="small-text"></td>
                </tr>
                <tr>
                    <th><?php _e('Animation Direction', 'animated-gutenberg-slider'); ?></th>
                    <td>
                        <label><input type="radio" name="ags_settings[animation_direction]" value="left" <?php checked($settings['animation_direction'], 'left'); ?>> <?php _e('Slide to Left', 'animated-gutenberg-slider'); ?></label><br>
                        <label><input type="radio" name="ags_settings[animation_direction]" value="right" <?php checked($settings['animation_direction'], 'right'); ?>> <?php _e('Slide to Right', 'animated-gutenberg-slider'); ?></label>
                    </td>
                </tr>
                <tr>
                    <th><?php _e('Grayscale Effect', 'animated-gutenberg-slider'); ?></th>
                    <td>
                        <label><input type="checkbox" name="ags_settings[use_grayscale]" value="1" <?php checked($settings['use_grayscale'], true); ?>> <?php _e('Enable grayscale effect', 'animated-gutenberg-slider'); ?></label>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Style Variables -->
        <div class="ags-section">
            <h2><?php _e('Slider Variables', 'animated-gutenberg-slider'); ?></h2>
            <table class="form-table">
                <tr>
                    <th><label for="gap_width"><?php _e('Gap between Logos (px)', 'animated-gutenberg-slider'); ?></label></th>
                    <td><input type="number" id="gap_width" name="ags_settings[gap_width]" value="<?php echo esc_attr($settings['gap_width']); ?>" min="0" max="100" class="small-text"></td>
                </tr>
                <tr>
                    <th><label for="logo_width"><?php _e('Single Logo Width (px)', 'animated-gutenberg-slider'); ?></label></th>
                    <td><input type="number" id="logo_width" name="ags_settings[logo_width]" value="<?php echo esc_attr($settings['logo_width']); ?>" min="50" max="500" class="small-text"></td>
                </tr>
                <tr>
                    <th><label for="mobile_logo_width"><?php _e('Mobile Logo Width (px)', 'animated-gutenberg-slider'); ?></label></th>
                    <td><input type="number" id="mobile_logo_width" name="ags_settings[mobile_logo_width]" value="<?php echo esc_attr($settings['mobile_logo_width']); ?>" min="30" max="300" class="small-text"></td>
                </tr>
            </table>
        </div>

        <?php submit_button(); ?>
    </form>
</div>