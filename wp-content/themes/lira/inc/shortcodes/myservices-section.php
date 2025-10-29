<?php

/**
 * My Services Section Shortcode
 *
 * Displays my services section with slider from ACF fields
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
  exit;
}

/**
 * My Services Section Shortcode
 * Usage: [myservices_section]
 *
 * Pulls data from ACF fields from page ID 7:
 * - myservices_title
 * - myservices_items (repeater: icon, title, desc)
 * - myservices_img
 * - myservices_quote
 * - myservices_quote_desktop
 */
function lira_myservices_section_shortcode($atts)
{
  // Get data from page ID 7
  $page_id = 7;

  // Get ACF fields
  $myservices_title = get_field('myservices_title', $page_id);
  $myservices_items = get_field('myservices_items', $page_id);
  $myservices_img = get_field('myservices_img', $page_id);
  $myservices_quote = get_field('myservices_quote', $page_id);
  $myservices_quote_desktop = get_field('myservices_quote_desktop', $page_id);
  $link = get_field('sidebar_link', 'option');

  // Check if we have data
  if (!$myservices_items || empty($myservices_items)) {
    return '';
  }

  // Start output buffering
  ob_start();
?>
  <section id="myservices" class="myservices">
    <div class="myservices__container">
      <? if ($myservices_title): ?>
        <div class="myservices__title">
          <?= $myservices_title ?>
        </div>
      <? endif; ?>

      <div class="myservices__list">
        <div class="swiper myservices-slider">
          <div class="swiper-wrapper">
            <? foreach ($myservices_items as $item): ?>
              <div class="swiper-slide myservices-item">
                <div class="myservices-item__icon">
                  <img src="<?= $item['icon']['url'] ?>" alt="<?= $item['icon']['alt'] != '' ? $item['icon']['alt'] : 'service-icon' ?>" width="auto" height="auto">
                </div>
                <div class="myservices-item__title"><?= $item['title'] ?></div>
                <div class="myservices-item__desc"><?= $item['desc'] ?></div>
              </div>
            <? endforeach; ?>
          </div>
          <div class="swiper-pagination"></div>
        </div>
      </div>

      <div class="myservices__contactinfo">
        <? if ($myservices_img): ?>
          <figure class="contactinfo-photo">
            <img src="<?= $myservices_img['url'] ?>"
              alt="<?= $myservices_img['alt'] != '' ? $myservices_img['alt'] : 'photo' ?>" width="100%" height="100%">
          </figure>
        <? endif; ?>
        <div class="contactinfo-quote">
          <? if ($myservices_quote): ?>
            <p><?= $myservices_quote ?></p>
          <? endif; ?>
          <? if ($myservices_quote_desktop): ?>
            <figure class="quote-desktop"><img src="<?= $myservices_quote_desktop['url'] ?>"
                alt="<?= $myservices_quote_desktop['alt'] != '' ? $myservices_quote_desktop['alt'] : 'quote' ?>" width="100%"
                height="100%"></figure>
          <? endif; ?>
        </div>

        <a href="<?=$link?>" class="button-accent">
          Подробнее обо мне
          <span class="icon-round-arrow"></span>
        </a>
      </div>
    </div>
  </section>
<?

  return ob_get_clean();
}
add_shortcode('myservices_section', 'lira_myservices_section_shortcode');
