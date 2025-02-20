class AGSAdmin {
    constructor() {
        this.initializeElements();
        this.addEventListeners();
        this.updatePreview();
    }
    
    initializeElements() {
        this.buttons = document.querySelectorAll('.ags-button');
        this.durationInput = document.querySelector('.ags-duration-input');
        this.grayscaleCheckbox = document.querySelector('input[name="ags_settings[use_grayscale]"]');
        this.saveReminder = document.querySelector('.ags-save-reminder');
    }
    
    addEventListeners() {
        this.buttons.forEach(button => {
            button.addEventListener('click', (e) => this.handleButtonClick(e));
        });
        
        this.durationInput.addEventListener('input', () => this.handleDurationChange());
        this.grayscaleCheckbox.addEventListener('change', () => this.showSaveReminder());
    }
    
    handleButtonClick(e) {
        const button = e.target;
        const group = button.closest('.ags-button-group');
        const input = group.querySelector('input[type="hidden"]');
        
        // Update active state
        group.querySelectorAll('.ags-button').forEach(btn => {
            btn.classList.remove('active');
        });
        button.classList.add('active');
        
        // Update hidden input
        input.value = button.dataset.value;
        
        this.showSaveReminder();
        this.updatePreview();
    }
    
    handleDurationChange() {
        let value = parseFloat(this.durationInput.value);
        if (value < 0.1) value = 0.1;
        if (value > 60) value = 60;
        this.durationInput.value = value;
        
        this.showSaveReminder();
        this.updatePreview();
    }
    
    showSaveReminder() {
        gsap.to(this.saveReminder, {
            display: 'block',
            opacity: 1,
            duration: 0.3
        });
    }
    
    updatePreview() {
        // Update preview section with current settings
        // Implementation depends on preview requirements
    }
}

// Initialize on DOM load
document.addEventListener('DOMContentLoaded', () => {
    new AGSAdmin();
});