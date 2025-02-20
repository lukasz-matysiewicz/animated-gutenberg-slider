document.addEventListener('DOMContentLoaded', function() {
    const containers = document.querySelectorAll('.cgs-container .wp-block-column');
    if (containers.length === 0) return;

    const settings = {
        duration: Number(window.agsSettings.duration) || 30,
        direction: window.agsSettings.direction || 'left',
        useGrayscale: Boolean(window.agsSettings.useGrayscale)
    };

    containers.forEach(container => {
        const content = container.innerHTML;
        container.innerHTML = content + content;

        container.querySelectorAll('img').forEach(img => {
            if (settings.useGrayscale) {
                img.style.filter = 'grayscale(1)';
                img.style.transition = 'filter 0.3s ease-in-out';
                img.addEventListener('mouseenter', () => img.style.filter = 'grayscale(0)');
                img.addEventListener('mouseleave', () => img.style.filter = 'grayscale(1)');
            } else {
                img.style.filter = 'none';
            }
        });

        gsap.set(container, {
            x: settings.direction === 'left' ? '0%' : '-50%'
        });

        gsap.killTweensOf(container);

        const tween = gsap.to(container, {
            x: settings.direction === 'left' ? '-50%' : '0%',
            duration: settings.duration,
            repeat: -1,
            ease: "none",
            paused: true
        });

        setTimeout(() => {
            tween.play();
        }, 100);

        container.addEventListener('mouseenter', () => {
            gsap.to(tween, { timeScale: 0, duration: 0.5 });
        });

        container.addEventListener('mouseleave', () => {
            gsap.to(tween, { timeScale: 1, duration: 0.5 });
        });
    });
});