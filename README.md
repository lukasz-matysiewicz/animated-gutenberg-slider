# === Animated Gutenberg Slider ===
Requires at least: 6.4
Tested up to: 6.7
Requires PHP: 7.0
Stable tag: 1.0.6
**License:** Commercial License ([See License Terms](#licensing))  

# Animated Gutenberg Slider

Beautiful GSAP-powered infinite slider for WordPress Gutenberg columns.

## Description
Add professional infinite sliding animations to your WordPress column blocks with GSAP animations. Perfect for logo carousels, partner showcases, and image sliders.

## Actions & Filters
- `ags_slider_settings` - Filter slider settings before output
- `ags_animation_options` - Modify available animation options
- `ags_slider_defaults` - Modify default slider settings

## Installation & Activation  
1. **Download & Install**  
   - Purchase the plugin from [Matysiewicz Studio](https:/ags.matysiewicz.studio).  
   - Download the `.zip` file from your account dashboard.  
   - Upload the plugin via **Plugins > Add New > Upload Plugin** in WordPress.  
   - Click **Activate Plugin**.  

2. **License Activation (Required)**  
   - After activation, you'll be prompted to **enter your license key**.  
   - Enter the key provided in your account after purchase.  
   - Click **Activate** to enable updates & support.  

💡 **Note:** You must activate the license to receive automatic updates & support.  

## Requirements
- WordPress 6.4 or higher
- PHP 7.4 or higher
- Modern browsers supporting CSS3 animations and GSAP

## Usage
1. Create a column block in WordPress
2. Add images to the column
3. The slider animation will be automatically applied
4. Customize settings in the AG Slider settings page

## Structure
```
animated-gutenberg-slider/
├── assets/                 # Frontend resources
│   ├── css/                # Stylesheets
│   │   ├── ags-admin.css   # Admin styles
│   │   └── ags-public.css  # Public styles
│   ├── js/                 # JavaScript files
│   │   ├── ags-admin.js    # Admin scripts
│   │   ├── ags-animations.js # Shared animations
│   │   └── ags-public.js   # Public scripts
│   └── images/             # Images and icons
├── includes/               # PHP classes
│   ├── admin/              # Admin functionality
│   │   ├── ags-admin.php
│   │   └── views/
│   ├── core/               # Core functionality
│   │   ├── ags-activator.php
│   │   ├── ags-assets.php
│   │   └── ...
│   └── frontend/           # Frontend functionality
├── languages/              # Translations
└── animated-gutenberg-slider.php
```

## Licensing  
This plugin is sold under a **Commercial License** and requires a valid **Freemius license key** for activation.  

### **License Types**  
- **Single-Site License:** Use on **1 website**  
- **Three-Site License:** Use on **up to 3 websites**  
- **Unlimited License:** Use on **unlimited websites**  
- **Annual License:** Includes **1 year of updates & support** (must renew to continue receiving updates)
- **Lifetime License:** Includes **lifetime updates & support** (one-time payment)

🔹 Your license can be **managed in your account** at https://matysiewicz.studio/my-account/
🔹 Licenses can be **moved between sites** via the **Freemius dashboard**  

📜 **Read full license terms in LICENSE.txt**  

## Support
For support inquiries:
- Email: support@matysiewicz.studio
- Website: https://matysiewicz.studio

## Version History
- 1.0.6: wp security checks
- 1.0.5: Fixed bug with resize window - speed calculation
- 1.0.4: Added Contact
- 1.0.3: Account changes, readme details
- 1.0.2: Added pause on hover functionality
- 1.0.1: Added Freemius functionality
- 1.0.0: Initial release

## Credits
Created by Matysiewicz Studio
Copyright (c) 2024 Matysiewicz Studio