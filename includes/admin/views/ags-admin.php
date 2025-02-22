<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="wrap ags-admin-wrap">
    <!-- Header Section -->
    <div class="ags-header">
        <img src="<?php echo esc_url(AGS_PLUGIN_URL . 'assets/images/logo-ags.webp'); ?>" 
             alt="<?php echo esc_attr__('Animated Gutenberg Slider Logo', 'animated-gutenberg-slider'); ?>" 
             class="ags-logo">
        <h1 class="ags-admin-title"><?php esc_html_e('Animated Gutenberg Slider', 'animated-gutenberg-slider'); ?></h1>
    </div>

    <form method="post" action="options.php" class="ags-form">
        <?php settings_fields('ags_options'); ?>

        <div class="ags-settings-content">
            <!-- Preview Section -->
            <div class="ags-preview-section">
                <h2 class="ags-section-title">Live Preview</h2>
                <div class="ags-preview-container">
                    <div id="agsPreview" class="wp-block-gallery" 
                        data-direction="<?php echo esc_attr($settings['animation_direction']); ?>"
                        data-speed="<?php echo esc_attr($settings['animation_duration']); ?>"
                        data-grayscale="<?php echo $settings['use_grayscale'] ? 'true' : 'false'; ?>">
                        <!-- Content will be populated by JavaScript -->
                    </div>
                </div>
            </div>

            <!-- Main Settings Section -->
            <div class="ags-main-settings">
                <div class="ags-section">
                    <h2 class="ags-section-title"><?php esc_html_e('Animation Settings', 'animated-gutenberg-slider'); ?></h2>
                    
                    <div class="ags-input-group">
                        <label class="ags-input-label" for="animation_duration">
                            <?php esc_html_e('Animation Duration (seconds) (depending on the number of logos)', 'animated-gutenberg-slider'); ?>
                        </label>
                        <input type="number" 
                               id="animation_duration" 
                               name="ags_settings[animation_duration]" 
                               value="<?php echo esc_attr($settings['animation_duration']); ?>" 
                               min="1" 
                               max="60" 
                               class="ags-input">
                    </div>

                    <div class="ags-input-group">
                        <span class="ags-input-label"><?php esc_html_e('Animation Direction', 'animated-gutenberg-slider'); ?></span>
                        <div class="ags-radio-group">
                            <label class="ags-radio-label">
                                <input type="radio" 
                                       name="ags_settings[animation_direction]" 
                                       value="left" 
                                       <?php checked($settings['animation_direction'], 'left'); ?>>
                                <?php esc_html_e('Slide to Left', 'animated-gutenberg-slider'); ?>
                            </label>
                            <label class="ags-radio-label">
                                <input type="radio" 
                                       name="ags_settings[animation_direction]" 
                                       value="right" 
                                       <?php checked($settings['animation_direction'], 'right'); ?>>
                                <?php esc_html_e('Slide to Right', 'animated-gutenberg-slider'); ?>
                            </label>
                        </div>
                    </div>

                    <div class="ags-input-group">
                        <span class="ags-input-label"><?php esc_html_e('Effects', 'animated-gutenberg-slider'); ?></span>
                        <div class="ags-checkbox-group">
                            <label class="ags-checkbox-label">
                                <input type="checkbox" 
                                       name="ags_settings[use_grayscale]" 
                                       value="1" 
                                       <?php checked($settings['use_grayscale'], true); ?>>
                                <?php esc_html_e('Enable grayscale effect', 'animated-gutenberg-slider'); ?>
                            </label>
                            <label class="ags-checkbox-label">
                                <input type="checkbox" 
                                       name="ags_settings[pause_on_hover]" 
                                       value="1" 
                                       <?php checked(isset($settings['pause_on_hover']) ? $settings['pause_on_hover'] : true, true); ?>>
                                <?php esc_html_e('Pause on hover', 'animated-gutenberg-slider'); ?>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="ags-section">
                    <h2 class="ags-section-title"><?php esc_html_e('Slider Variables', 'animated-gutenberg-slider'); ?></h2>
                    
                    <div class="ags-input-group">
                        <label class="ags-input-label" for="gap_width">
                            <?php esc_html_e('Gap between Logos (px)', 'animated-gutenberg-slider'); ?>
                        </label>
                        <input type="number" 
                               id="gap_width" 
                               name="ags_settings[gap_width]" 
                               value="<?php echo esc_attr($settings['gap_width']); ?>" 
                               min="0" 
                               max="100" 
                               class="ags-input">
                    </div>

                    <div class="ags-input-group">
                        <label class="ags-input-label" for="logo_width">
                            <?php esc_html_e('Single Logo Width (px)', 'animated-gutenberg-slider'); ?>
                        </label>
                        <input type="number" 
                               id="logo_width" 
                               name="ags_settings[logo_width]" 
                               value="<?php echo esc_attr($settings['logo_width']); ?>" 
                               min="50" 
                               max="500" 
                               class="ags-input">
                    </div>

                    <div class="ags-input-group">
                        <label class="ags-input-label" for="mobile_logo_width">
                            <?php esc_html_e('Mobile Logo Width (px)', 'animated-gutenberg-slider'); ?>
                        </label>
                        <input type="number" 
                               id="mobile_logo_width" 
                               name="ags_settings[mobile_logo_width]" 
                               value="<?php echo esc_attr($settings['mobile_logo_width']); ?>" 
                               min="30" 
                               max="300" 
                               class="ags-input">
                    </div>

                    <?php submit_button(__('Save Changes', 'animated-gutenberg-slider'), 'primary ags-submit'); ?>
                </div>
            </div>
        </div>
    </form>

    <footer class="ags-footer">
        <p>
            <?php esc_html_e('Need help? Contact support at', 'animated-gutenberg-slider'); ?>
            <a href="mailto:support@matysiewicz.studio">support@matysiewicz.studio</a>
        </p>
    </footer>
</div>