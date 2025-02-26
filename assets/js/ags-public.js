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

    // Keep track of initialized sliders
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

                // Check if this container was previously initialized
                if (initializedSliders.has(container)) {
                    // Clean up the old animation before reinitializing
                    const animation = initializedSliders.get(container);
                    if (animation) {
                        animation.kill();
                    }
                    
                    // Reset container to original state
                    container.innerHTML = container.getAttribute('data-original-content') || container.innerHTML;
                    gsap.set(container, { x: 0 }); // Reset position
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

                // Store the animation in our Map
                initializedSliders.set(container, animation);

                // Clean up previous event listeners
                const oldMouseEnter = container.getAttribute('data-mouseenter-handler');
                const oldMouseLeave = container.getAttribute('data-mouseleave-handler');
                
                if (oldMouseEnter) {
                    parentContainer.removeEventListener('mouseenter', window[oldMouseEnter]);
                }
                
                if (oldMouseLeave) {
                    parentContainer.removeEventListener('mouseleave', window[oldMouseLeave]);
                }

                // Add hover pause functionality with namespaced handlers
                if (settings.pauseOnHover) {
                    // Create unique handler names
                    const mouseEnterHandlerName = 'mouseEnter_' + Math.random().toString(36).substring(2, 9);
                    const mouseLeaveHandlerName = 'mouseLeave_' + Math.random().toString(36).substring(2, 9);
                    
                    // Create handlers on the window object so they can be referenced by string
                    window[mouseEnterHandlerName] = () => {
                        if (animation) {
                            animation.pause();
                        }
                    };
                    
                    window[mouseLeaveHandlerName] = () => {
                        if (animation) {
                            animation.play();
                        }
                    };
                    
                    // Store handler references for future cleanup
                    container.setAttribute('data-mouseenter-handler', mouseEnterHandlerName);
                    container.setAttribute('data-mouseleave-handler', mouseLeaveHandlerName);
                    
                    // Add event listeners
                    parentContainer.addEventListener('mouseenter', window[mouseEnterHandlerName]);
                    parentContainer.addEventListener('mouseleave', window[mouseLeaveHandlerName]);
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

})(jQuery);