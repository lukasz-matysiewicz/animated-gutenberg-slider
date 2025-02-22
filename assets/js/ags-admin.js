(function($) {
    'use strict';

    let sliderAnimation;

    function initPreview() {
        const preview = document.getElementById('agsPreview');
        if (!preview) return;

        const settings = getSettings();

        // Create initial content
        const figures = `
            <figure class="wp-block-image">
                <img src="${agsSettings.pluginUrl}assets/images/logo1.webp" alt="Logo 1">
            </figure>
            <figure class="wp-block-image">
                <img src="${agsSettings.pluginUrl}assets/images/logo2.webp" alt="Logo 2">
            </figure>
            <figure class="wp-block-image">
                <img src="${agsSettings.pluginUrl}assets/images/logo3.webp" alt="Logo 3">
            </figure>
            <figure class="wp-block-image">
                <img src="${agsSettings.pluginUrl}assets/images/logo4.webp" alt="Logo 4">
            </figure>
            <figure class="wp-block-image">
                <img src="${agsSettings.pluginUrl}assets/images/logo5.webp" alt="Logo 5">
            </figure>
        `;

        // Double the content
        preview.innerHTML = figures + figures;

        // Set up initial styles
        preview.style.display = 'flex';
        preview.style.flexDirection = 'row';
        preview.style.gap = `${settings.gapWidth}px`;
        preview.style.flexWrap = 'nowrap';
        
        preview.querySelectorAll('.wp-block-image').forEach(figure => {
            figure.style.flex = '0 0 auto';
            figure.style.width = `${settings.logoWidth}px`;
            figure.style.margin = '0';
        });

        // Apply grayscale if needed
        if (settings.useGrayscale) {
            preview.querySelectorAll('img').forEach(img => {
                img.style.filter = 'grayscale(100%)';
            });
        }

        // Start animation after a brief delay
        setTimeout(updateAnimation, 100);
    }

    function getSettings() {
        return {
            duration: parseInt($('#animation_duration').val()) || 10,
            direction: $('input[name="ags_settings[animation_direction]"]:checked').val() || 'left',
            logoWidth: parseInt($('#logo_width').val()) || 150,
            gapWidth: parseInt($('#gap_width').val()) || 40,
            useGrayscale: $('input[name="ags_settings[use_grayscale]"]').prop('checked')
        };
    }

    function updateAnimation() {
        if (sliderAnimation) {
            sliderAnimation.kill();
        }

        const preview = document.getElementById('agsPreview');
        if (!preview) return;

        const settings = getSettings();

        // Calculate total width for one set
        const singleSetCount = preview.children.length / 2;
        const totalWidth = (settings.logoWidth * singleSetCount) + 
                          (settings.gapWidth * (singleSetCount - 1));

        // Reset position
        gsap.set(preview, {
            x: settings.direction === 'left' ? 0 : -totalWidth
        });

        // Create animation
        sliderAnimation = gsap.to(preview, {
            x: settings.direction === 'left' ? -totalWidth : 0,
            duration: settings.duration,
            ease: "none",
            repeat: -1
        });
    }

    // Event Listeners
    $(document).ready(function() {
        // Initial setup
        initPreview();

        // Handle all input changes
        $('#animation_duration, #gap_width, #logo_width').on('input change', function() {
            initPreview();
        });

        // Handle radio and checkbox changes
        $('input[name="ags_settings[animation_direction]"], input[name="ags_settings[use_grayscale]"]').on('change', function() {
            initPreview();
        });
    });
})(jQuery);