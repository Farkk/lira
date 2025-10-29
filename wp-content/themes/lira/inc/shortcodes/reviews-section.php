<?php

/**
 * Reviews Section Shortcode
 *
 * Displays reviews section with slider from ACF fields
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
  exit;
}

/**
 * Reviews Section Shortcode
 * Usage: [reviews_section]
 *
 * Pulls data from ACF fields from page ID 7:
 * - reviews_title
 * - reviews_desc
 * - reviews_images (array of image IDs)
 */
function lira_reviews_section_shortcode($atts)
{
  // Get data from page ID 7
  $page_id = 7;

  // Get ACF fields
  $reviews_title = get_field('reviews_title', $page_id);
  $reviews_desc = get_field('reviews_desc', $page_id);
  $testimonials = get_field('reviews_images', $page_id);

  // Check if we have data
  if (!$testimonials || empty($testimonials)) {
    return '';
  }

  // Start output buffering
  ob_start();
?>
  <section id="reviews" class="reviews">
    <div class="reviews__container">
      <div class="reviews__heading">
        <? if ($reviews_title): ?>
          <div class="reviews__title"><?= $reviews_title ?></div>
        <? endif; ?>
        <? if ($reviews_desc): ?>
          <p><?= $reviews_desc ?></p>
        <? endif; ?>
      </div>

      <div class="reviews__list">
        <div class="swiper reviews-slider">
          <div class="swiper-wrapper">
            <? foreach ($testimonials as $item): ?>
              <div class="swiper-slide reviews-item">
                <a href="<?= wp_get_attachment_image_url($item, 'full'); ?>" class="reviews-item__img" data-fancybox="reviews">
                  <img src="<?= kama_thumb_src('w=255&h=327', $item); ?>" alt="review-image" width="255" height="327">
                </a>
              </div>
            <? endforeach; ?>
          </div>
          <div class="swiper-scrollbar"></div>
          <div class="swiper-pagination"></div>
          <div class="slider-navigation">
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
          </div>
        </div>
      </div>
    </div>
  </section>
<?

  return ob_get_clean();
}
add_shortcode('reviews_section', 'lira_reviews_section_shortcode');
