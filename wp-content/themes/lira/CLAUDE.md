# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a WordPress theme called "Lira" (version 1.0.0) designed for a service-based business website. The theme is built using classic WordPress template structure with PHP templates, custom post types, shortcodes, and modular CSS/JS architecture.

## Technology Stack

- **CMS**: WordPress 5.4+
- **PHP**: 5.6+ (as specified in style.css)
- **Frontend**: jQuery, Swiper.js, Fancybox
- **Fonts**: SF Pro Display, Nunito Sans
- **Icons**: Custom icon font (in `/icons`)
- **Development Environment**: Local by Flywheel (based on path structure)

## Theme Architecture

### Core Files Structure

- **functions.php** - Central theme initialization file that includes:
  - `/inc/enqueue.php` - Asset loading system
  - `/inc/custom-post-types.php` - Custom post type and taxonomy registration
  - `/inc/shortcodes/init.php` - Shortcode loader
  - `/inc/components/breadcrumbs.php` - Breadcrumb navigation component
  - `/inc/post-views.php` - Post view tracking system

### Custom Post Types

The theme registers two custom post types:

1. **service** - Services offered by the business
   - Custom fields via ACF (Advanced Custom Fields)
   - Taxonomy: `service_category` (hierarchical)
   - Taxonomy: `service_badge` (non-hierarchical, tag-style)
   - Template: `single-service.php`
   - Archive: `taxonomy-service_category.php`

2. **blog** - Blog posts (separate from WordPress default posts)
   - Taxonomy: `blog_category` (hierarchical)
   - Template: `single-blog.php`
   - Archive: `archive-blog.php`

### Template Hierarchy

- `front-page.php` - Homepage template
- `page.php` - Default page template
- `single-service.php` - Single service template
- `single-blog.php` - Single blog post template
- `archive-blog.php` - Blog archive template
- `taxonomy-service_category.php` - Service category archive
- `search.php` - Search results template
- `404.php` - 404 error page
- `header.php` - Site header
- `footer.php` - Site footer

### Shortcodes System

All shortcodes are located in `/inc/shortcodes/` and loaded via `init.php`:

- `service-accordions.php` - FAQ/accordion sections
- `service-advantages.php` - Service benefits display
- `faq-section.php` - FAQ section
- `videos-section.php` - Video gallery section
- `myservices-section.php` - Services listing
- `reviews-section.php` - Customer reviews
- `getconsult-section.php` - Consultation form section
- `blog-section.php` - Blog posts section
- `blog-slider.php` - Blog posts slider

### Asset Loading Strategy

The theme uses a sophisticated asset loading system (`/inc/enqueue.php`) with:

- **Priority-based loading** - Styles and scripts are loaded in specific order based on priority values
- **Conditional loading** - Some assets only load on specific page types (e.g., single-services.css only on service pages)
- **Footer optimization** - Most CSS files are moved to footer for performance
- **Version control** - Uses `filemtime()` for cache busting

#### CSS Loading Order:
1. `style.css` (base WordPress styles)
2. Font stylesheets (SF Pro, Nunito Sans)
3. `main.css` (global styles)
4. `header.css`
5. `hero.css`
6. Conditional styles (breadcrumbs, single-services, sidebar, blog)
7. Footer section styles (problems, howwork, slider, videos, FAQ, etc.)
8. Library styles (Swiper, Fancybox)

#### JavaScript Loading:
- All scripts load in footer
- jQuery loads first (bundled version)
- Then libraries (Swiper, Fancybox)
- Finally `script.js` (custom theme scripts)

### Menu Locations

The theme registers 6 menu locations:
- `menu-1` - Primary navigation
- `footer-menu-base` - Footer main menu
- `footer-menu-advanced` - Footer advanced menu
- `footer-menu-bottom` - Footer bottom menu
- `advanced-menu` - Advanced menu
- `social-menu` - Social media links

### ACF (Advanced Custom Fields) Integration

The theme heavily relies on ACF for custom fields. Common field groups:

**Options Page Fields** (`'option'`):
- `logo` - Site logo
- `logo_text` - Logo text
- `phone` - Contact phone
- `link_wa` - WhatsApp link
- `link_tg` - Telegram link
- `mobile_text` - Mobile header text
- `time_work` - Working hours
- `banner_text` - Top banner text
- `banner_link` - Top banner link
- `sidebar_img` - Sidebar image
- `sidebar_desc` - Sidebar description
- `sidebar_skill` - Sidebar skills

**Service Post Fields**:
- `benefit` - Service benefits (repeater)
- `price` - Service price
- `price_discount` - Discount percentage
- `price_children` - Children's price
- `desc_children` - Children's description
- `text_children` - Children's text
- `pay` - Payment options
- `pay_link` - Payment link
- `recomends` - Recommendations

### Post Views System

The theme includes a custom post view tracking system (`/inc/post-views.php`):
- Automatically tracks views for `service`, `blog`, and `post` types
- Functions:
  - `lira_set_post_views($post_id)` - Increment view count
  - `lira_get_post_views($post_id)` - Get view count
  - `lira_display_post_views($post_id)` - Get formatted view count

### Contact Form 7 Customization

The theme includes custom CF7 integration:
- Auto-removes `<p>` tags from form output
- Generates contact links (WhatsApp, Telegram, phone) based on form submission
- Uses `[contact-links]` placeholder in email templates

### Search Functionality

Search is extended to include custom post types:
- Searches both `blog` and `service` post types
- Implemented via `lira_extend_search()` filter

### Body Classes

Custom body classes are added via `lira_add_custom_body_classes()`:
- Service pages get `topbaractive` class
- Blog pages get standard WordPress blog classes
- Search pages get search-specific classes

## Development Workflow

### Local Development

The theme is designed to run on Local by Flywheel:
- Path: `/Users/pavel/Local Sites/lira/app/public/wp-content/themes/lira`
- No build process required - direct file editing
- Cache busting handled via `filemtime()` in enqueue system

### Making Changes

**Adding New Styles:**
1. Create new CSS file in `/css/` directory
2. Add entry to `$styles` array in `/inc/enqueue.php`
3. Set appropriate dependencies and priority
4. Use `condition` key if style should only load on specific pages

**Adding New Scripts:**
1. Add JS file to `/js/` directory
2. Add entry to `$scripts` array in `/inc/enqueue.php`
3. Set dependencies (usually include 'lira-jquery')

**Creating New Shortcodes:**
1. Create PHP file in `/inc/shortcodes/`
2. Add `require_once` in `/inc/shortcodes/init.php`
3. Use standard WordPress shortcode API

**Adding New Templates:**
- Follow WordPress template hierarchy
- Include ACF field handling as needed
- Call `get_header()` and `get_footer()`

### Important Notes

- **No Gutenberg**: The theme has `show_in_rest => false` for custom post types - uses Classic Editor
- **Short PHP tags**: The theme uses `<?` instead of `<?php` throughout - maintain consistency
- **ACF Required**: Theme functionality depends on Advanced Custom Fields plugin
- **Kama Thumbnail Plugin**: Used for responsive images via `kama_thumb_src()` function
- **Russian Language**: UI text is primarily in Russian

### Common Tasks

**Debug Mode:**
- Check `functions.php` for `error_log()` calls - there's debug logging for body classes

**Asset Cache Issues:**
- Assets use `filemtime()` versioning - touch the file to clear cache
- Check that file path exists in `/inc/enqueue.php` conditions

**Custom Post Type Changes:**
- After modifying `/inc/custom-post-types.php`, flush permalinks via Settings > Permalinks in WordPress admin

**Troubleshooting Shortcodes:**
- Check `/inc/shortcodes/init.php` for proper file inclusion
- Verify shortcode registration function is called
