(function($) {
    'use strict';

    const defaultSettings = window.agsSettings?.settings || {
        duration: 30,
        direction: 'left',
        useGrayscale: true,
        pauseOnHover: true,
        gapWidth: 40,
        logoWidth: 150,
        mobileLogoWidth: 100
    };

    function initSlider() {
        const containers = document.querySelectorAll('.ags-container .wp-block-column');
        if (!containers.length) return;

        containers.forEach(container => {
            try {
                const parentContainer = container.closest('.ags-container');
                if (!parentContainer || container.hasAttribute('data-ags-initialized')) {
                    return;
                }

                const settings = {
                    direction: defaultSettings.direction,
                    duration: defaultSettings.duration,
                    useGrayscale: defaultSettings.useGrayscale,
                    pauseOnHover: defaultSettings.pauseOnHover,
                    gapWidth: defaultSettings.gapWidth,
                    logoWidth: defaultSettings.logoWidth
                };

                const originalImages = container.querySelectorAll('.wp-block-image');
                const originalContent = container.innerHTML;

                container.innerHTML = originalContent + originalContent;

                const totalWidth = (settings.logoWidth * originalImages.length) + 
                                 (settings.gapWidth * (originalImages.length - 1));

                if (settings.useGrayscale) {
                    container.querySelectorAll('img').forEach(img => {
                        img.classList.add('grayscale');
                    });
                }

                gsap.set(container, {
                    x: settings.direction === 'left' ? 0 : -totalWidth
                });

                container.animation = gsap.to(container, {
                    x: settings.direction === 'left' ? -totalWidth : 0,
                    duration: settings.duration,
                    ease: "none",
                    repeat: -1
                });

                // Add hover pause functionality
                if (settings.pauseOnHover) {
                    parentContainer.addEventListener('mouseenter', () => {
                        if (container.animation) {
                            container.animation.pause();
                        }
                    });

                    parentContainer.addEventListener('mouseleave', () => {
                        if (container.animation) {
                            container.animation.play();
                        }
                    });
                }

                container.setAttribute('data-ags-initialized', 'true');

            } catch (error) {
                console.error('AGS Slider initialization error:', error);
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initSlider);
    } else {
        initSlider();
    }

    let resizeTimer;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            document.querySelectorAll('.wp-block-column[data-ags-initialized]')
                .forEach(el => el.removeAttribute('data-ags-initialized'));
            initSlider();
        }, 250);
    });

})(jQuery);