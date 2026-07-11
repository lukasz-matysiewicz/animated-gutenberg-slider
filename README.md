# Animated Gutenberg Slider

Beautiful GSAP-powered infinite slider for WordPress Gutenberg columns.

Free and open source — licensed under GPLv2 or later.

## Description

Add professional infinite sliding animations to your WordPress column blocks with GSAP animations. Perfect for logo carousels, partner showcases, and image sliders.

**Features:**
- Infinite, seamless scrolling
- Slide left or right
- Adjustable animation speed
- Optional grayscale effect (color on hover)
- Pause on hover
- Configurable logo size, mobile logo size, and gap
- Live preview in the settings page

## Requirements

- WordPress 6.4 or higher
- PHP 7.4 or higher
- Modern browsers supporting CSS3 animations and GSAP

## Installation

1. Download the latest `.zip` from the [releases page](https://github.com/lukasz-matysiewicz/animated-gutenberg-slider/releases), or clone this repository into `wp-content/plugins/`.
2. Upload the plugin via **Plugins → Add New → Upload Plugin** in WordPress (skip if you cloned).
3. Click **Activate Plugin**.

## Usage

1. Add a **Columns** block to a post or page.
2. Fill a column with **Image** blocks (e.g. logos).
3. Select the Columns block, open **Settings → Advanced → Additional CSS class(es)** and add the class: `ags-container`
4. Publish — the column content now scrolls as an infinite slider.
5. Customize speed, direction, sizes, and effects in **AG Slider** in the WordPress admin menu.

## Hooks

- `ags_init` — action fired after the plugin is initialized
- `ags_sanitized_settings` — filter the sanitized settings before they are saved

## Structure

```
animated-gutenberg-slider/
├── assets/
│   ├── css/                      # Stylesheets (SCSS + compiled CSS)
│   ├── images/                   # Demo logos for the admin preview
│   └── js/
│       ├── ags-admin.js          # Settings page live preview
│       ├── ags-public.js         # Frontend slider
│       └── vendor/gsap.min.js    # Bundled GSAP
├── includes/
│   ├── admin/                    # Settings page
│   │   ├── ags-admin.php
│   │   └── views/ags-admin.php
│   └── core/                     # Core functionality
│       ├── ags-activator.php
│       ├── ags-assets.php
│       ├── ags-deactivator.php
│       └── ags-init.php
├── languages/                    # Translations
├── animated-gutenberg-slider.php # Main plugin file
└── uninstall.php                 # Cleanup on uninstall
```

## Licensing

This plugin is free and open source, licensed under the **GPLv2 or later**. Use it on as many sites as you like. See the [LICENSE](LICENSE) file for full terms.

The bundled [GSAP](https://gsap.com) library is distributed under its own (free) license — see https://gsap.com/licensing/ for details.

## Support

- Issues: [GitHub issue tracker](https://github.com/lukasz-matysiewicz/animated-gutenberg-slider/issues)
- Email: support@matysiewicz.studio
- Website: https://matysiewicz.studio

## Version History

- 1.1.0: Removed Freemius — the plugin is now free and open source (GPLv2 or later). Fixed activation hooks, removed broken/dead code, assets now load only on pages that use the slider, slider settings applied via CSS custom properties, fixed event-handler leak on window resize.
- 1.0.6: WP security checks
- 1.0.5: Fixed bug with resize window - speed calculation
- 1.0.4: Added Contact
- 1.0.3: Account changes, readme details
- 1.0.2: Added pause on hover functionality
- 1.0.1: Added Freemius functionality
- 1.0.0: Initial release

## Credits

Created by [Matysiewicz Studio](https://matysiewicz.studio)
