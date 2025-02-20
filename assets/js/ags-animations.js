/**
 * Shared animations module for Animated Gutenberg Slider
 */
const AGSAnimations = {
    init(element, settings) {
        this.element = element;
        this.settings = settings;
        this.timeline = gsap.timeline();
        
        return this;
    },

    slideLeft() {
        return gsap.to(this.element, {
            x: '-50%',
            duration: this.settings.duration,
            ease: "none",
            repeat: -1
        });
    },

    slideRight() {
        return gsap.to(this.element, {
            x: '0%',
            duration: this.settings.duration,
            ease: "none",
            repeat: -1
        });
    },

    pause() {
        gsap.to(this.timeline, {
            timeScale: 0,
            duration: 0.2
        });
    },

    resume() {
        gsap.to(this.timeline, {
            timeScale: 1,
            duration: 0.2
        });
    },

    createSlideAnimation() {
        const direction = this.settings.direction || 'left';
        this.timeline = direction === 'left' ? this.slideLeft() : this.slideRight();
        return this.timeline;
    }
};

// Make it available globally
window.AGSAnimations = AGSAnimations;