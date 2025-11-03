<?php

/**
 * Breadcrumbs Component
 *
 * Displays breadcrumbs navigation
 */
// Exit if accessed directly
if (!defined('ABSPATH')) {
  exit;
}
/**
 * Display breadcrumbs
 *
 * @param int|null $post_id Post ID (optional, uses current post if not provided)
 */
function lira_breadcrumbs($post_id = null)
{
  // Get home URL
  $home_url = home_url('/');

  // Start output
  ob_start();
?>
  <div class="breadcrumbs">
    <div class="breadcrumbs__container">
      <ul class="breadcrumbs__list">
        <!-- Home link -->
        <li class="breadcrumbs__item">
          <a href="<?= esc_url($home_url) ?>" class="breadcrumbs__link"><u>Главная</u></a>
        </li>
        <?php
        // Check if we're on a taxonomy archive page
        if (is_tax('service_category') || is_tax('blog_category')) {
          $current_term = get_queried_object();
        ?>
          <li class="breadcrumbs__item breadcrumbs__item--current">
            <span class="breadcrumbs__current"><?= esc_html($current_term->name) ?></span>
          </li>
        <?php
        }
        // Check if we're on a search page
        elseif (is_search()) {
        ?>
          <li class="breadcrumbs__item breadcrumbs__item--current">
            <span class="breadcrumbs__current">Результаты поиска</span>
          </li>
        <?php
        }
        // Check if we're on blog archive
        elseif (is_post_type_archive('blog')) {
        ?>
          <li class="breadcrumbs__item breadcrumbs__item--current">
            <span class="breadcrumbs__current">Блог</span>
          </li>
          <?php
        }
        // For single posts/pages
        else {
          // Get post ID if not provided
          if (!$post_id) {
            $post_id = get_the_ID();
          }
          // Get post object
          $post = get_post($post_id);
          if (!$post) {
          ?>
      </ul>
    </div>
  </div>
  <?php
            echo ob_get_clean();
            return;
          }

          // For service post type, show category
          if ($post->post_type === 'service') {
            $categories = get_the_terms($post_id, 'service_category');
            if ($categories && !is_wp_error($categories)) {
              $category = $categories[0]; // Get first category
  ?>
    <li class="breadcrumbs__item">
      <a href="<?= esc_url(get_term_link($category)) ?>" class="breadcrumbs__link"><u><?= esc_html($category->name) ?></u></a>
    </li>
  <?php
            }
          }
          // For blog post type, show blog archive and category
          elseif ($post->post_type === 'blog') {
            // Get blog archive URL
            $blog_archive_url = get_post_type_archive_link('blog');
  ?>
  <li class="breadcrumbs__item">
    <a href="<?= esc_url($blog_archive_url) ?>" class="breadcrumbs__link"><u>Блог</u></a>
  </li>
  <?php
            $categories = get_the_terms($post_id, 'blog_category');
            if ($categories && !is_wp_error($categories)) {
              $category = $categories[0]; // Get first category
  ?>
    <!-- <li class="breadcrumbs__item">
      <a href="<?= esc_url(get_term_link($category)) ?>" class="breadcrumbs__link"><u><?= esc_html($category->name) ?></u></a>
    </li> -->
  <?php
            }
          }
          // For regular posts, show category
          elseif ($post->post_type === 'post') {
            $categories = get_the_category($post_id);
            if ($categories) {
              $category = $categories[0]; // Get first category
  ?>
    <li class="breadcrumbs__item">
      <a href="<?= esc_url(get_category_link($category->term_id)) ?>" class="breadcrumbs__link"><u><?= esc_html($category->name) ?></u></a>
    </li>
  <?php
            }
          }
          // For pages, show parent pages hierarchy
          elseif ($post->post_type === 'page') {
            // Get parent pages
            $parents = array();
            $parent_id = $post->post_parent;

            while ($parent_id) {
              $parent = get_post($parent_id);
              $parents[] = array(
                'id' => $parent->ID,
                'title' => $parent->post_title,
                'url' => get_permalink($parent->ID)
              );
              $parent_id = $parent->post_parent;
            }

            // Reverse to show from top to bottom
            $parents = array_reverse($parents);

            // Output parent pages
            foreach ($parents as $parent) {
  ?>
    <li class="breadcrumbs__item">
      <a href="<?= esc_url($parent['url']) ?>" class="breadcrumbs__link"><u><?= esc_html($parent['title']) ?></u></a>
    </li>
<?php
            }
          }

          // Current page/post title (without link)
?>
<!-- <li class="breadcrumbs__item breadcrumbs__item--current">
  <span class="breadcrumbs__current"><?= esc_html($post->post_title) ?></span>
</li> -->
<?php
        } // end else for single posts/pages
?>
</ul>
</div>
</div>
<?php
  echo ob_get_clean();
}
