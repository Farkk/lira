<?php

/**
 * Post Views Counter System
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
  exit;
}

/**
 * Track post views
 * Call this function on single post pages to increment view count
 *
 * @param int $post_id Post ID
 */
function lira_set_post_views($post_id)
{
  if (!$post_id) {
    return;
  }

  // Prevent counting if user is logged in and is admin (optional)
  // if (current_user_can('manage_options')) {
  //   return;
  // }

  $count_key = 'post_views_count';
  $count = get_post_meta($post_id, $count_key, true);

  if ($count == '') {
    $count = 1;
    add_post_meta($post_id, $count_key, '1');
  } else {
    $count++;
    update_post_meta($post_id, $count_key, $count);
  }
}

/**
 * Get post views count
 *
 * @param int $post_id Post ID
 * @return int Number of views
 */
function lira_get_post_views($post_id)
{
  $count_key = 'post_views_count';
  $count = get_post_meta($post_id, $count_key, true);

  if ($count == '') {
    delete_post_meta($post_id, $count_key);
    add_post_meta($post_id, $count_key, '0');
    return 0;
  }

  return (int) $count;
}

/**
 * Display formatted post views count
 *
 * @param int $post_id Post ID
 * @return string Formatted views count (e.g., "1 234" or "12 678")
 */
function lira_display_post_views($post_id)
{
  $count = lira_get_post_views($post_id);
  return number_format($count, 0, '', ' ');
}

/**
 * Track post views on single post page
 * Automatically called via wp hook
 */
function lira_track_post_views()
{
  // Only track on single post pages
  if (!is_singular()) {
    return;
  }

  // Get post ID
  global $post;

  if (!$post || !isset($post->ID)) {
    return;
  }

  $post_id = $post->ID;

  // Only track specific post types
  $post_type = get_post_type($post_id);
  if (in_array($post_type, array('service', 'blog', 'post'))) {
    lira_set_post_views($post_id);
  }
}
// Use wp hook which runs after query is set
add_action('wp', 'lira_track_post_views');

/**
 * Exclude views meta from WP_Query
 * This prevents view counts from being cached
 */
function lira_exclude_views_from_cache($query)
{
  if (!is_admin() && $query->is_main_query()) {
    $query->set('update_post_meta_cache', false);
  }
}
// Uncomment if you experience caching issues
// add_action('pre_get_posts', 'lira_exclude_views_from_cache');
