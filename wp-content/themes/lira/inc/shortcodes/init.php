<?php
/**
 * Shortcodes Initialization
 *
 * Central file for loading all theme shortcodes
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Include shortcode files
require_once get_template_directory() . '/inc/shortcodes/service-accordions.php';
require_once get_template_directory() . '/inc/shortcodes/service-advantages.php';
require_once get_template_directory() . '/inc/shortcodes/faq-section.php';
require_once get_template_directory() . '/inc/shortcodes/videos-section.php';
require_once get_template_directory() . '/inc/shortcodes/myservices-section.php';
require_once get_template_directory() . '/inc/shortcodes/reviews-section.php';
require_once get_template_directory() . '/inc/shortcodes/getconsult-section.php';
require_once get_template_directory() . '/inc/shortcodes/blog-section.php';
require_once get_template_directory() . '/inc/shortcodes/blog-slider.php';
