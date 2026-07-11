(function() {
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

    // Keep track of initialized sliders: container -> { animation, listeners, parent }
    const initializedSliders = new Map();

    function initSlider() {
        const containers = document.querySelectorAll('.ags-container .wp-block-column');
        if (!containers.length) return;

        containers.forEach(container => {
            try {
                const parentContainer = container.closest('.ags-container');
                if (!parentContainer) {
                    return;
                }

                // Clean up a previous initialization (e.g. after a resize)
                const previous = initializedSliders.get(container);
                if (previous) {
                    if (previous.animation) {
                        previous.animation.kill();
                    }
                    previous.listeners.forEach(([event, handler]) => {
                        previous.parent.removeEventListener(event, handler);
                    });
                    container.innerHTML = container.getAttribute('data-original-content') || container.innerHTML;
                    gsap.set(container, { x: 0 });
                    initializedSliders.delete(container);
                }

                const settings = {
                    direction: defaultSettings.direction,
                    duration: defaultSettings.duration,
                    useGrayscale: defaultSettings.useGrayscale,
                    pauseOnHover: defaultSettings.pauseOnHover,
                    gapWidth: defaultSettings.gapWidth,
                    logoWidth: defaultSettings.logoWidth
                };

                // Store original content before duplicating
                const originalContent = container.innerHTML;
                container.setAttribute('data-original-content', originalContent);

                // Get original images before duplicating content
                const originalImages = container.querySelectorAll('.wp-block-image');

                // Double the content for the infinite effect
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

                const animation = gsap.to(container, {
                    x: settings.direction === 'left' ? -totalWidth : 0,
                    duration: settings.duration,
                    ease: "none",
                    repeat: -1
                });

                // Add hover pause functionality
                const listeners = [];
                if (settings.pauseOnHover) {
                    const onMouseEnter = () => animation.pause();
                    const onMouseLeave = () => animation.play();

                    parentContainer.addEventListener('mouseenter', onMouseEnter);
                    parentContainer.addEventListener('mouseleave', onMouseLeave);

                    listeners.push(['mouseenter', onMouseEnter], ['mouseleave', onMouseLeave]);
                }

                initializedSliders.set(container, {
                    animation: animation,
                    listeners: listeners,
                    parent: parentContainer
                });

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

    // Debounce function to limit resize events
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // Debounced resize handler
    const handleResize = debounce(() => {
        initSlider();
    }, 250);

    window.addEventListener('resize', handleResize);

})();
