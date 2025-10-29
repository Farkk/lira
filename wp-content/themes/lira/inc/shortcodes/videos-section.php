<?php

/**
 * Videos Section Shortcode
 *
 * Displays videos section with tabs from ACF fields
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
  exit;
}

/**
 * Videos Section Shortcode
 * Usage: [videos_section]
 *
 * Pulls data from ACF fields from page ID 7:
 * - videos_title
 * - videos_tabs (repeater: name)
 * - videos_tabs_content (repeater: frame_videos)
 * - videos_links_title
 * - videos_links (repeater: name, link)
 */
function lira_videos_section_shortcode($atts)
{
  // Get data from page ID 7
  $page_id = 7;

  // Get ACF fields
  $videos_title = get_field('videos_title', $page_id);
  $videos_tabs = get_field('videos_tabs', $page_id);
  $videos_tabs_content = get_field('videos_tabs_content', $page_id);
  $videos_links_title = get_field('videos_links_title', $page_id);
  $videos_links = get_field('videos_links', $page_id);

  // Check if we have data
  if (!$videos_tabs || empty($videos_tabs)) {
    return '';
  }

  // Start output buffering
  ob_start();
?>
  <section id="howtovideos" class="howtovideos">
    <div class="howtovideos__container-s">
      <? if ($videos_title): ?>
        <div class="howtovideos__title"><?= $videos_title ?></div>
      <? endif; ?>

      <div class="tabs" data-group="1">
        <ul class="tabs-nav">
          <? foreach ($videos_tabs as $key => $item) : ?>
            <li data-tab="tab-<?= $key + 1 ?>-group1" class="<?= $key === 0 ? 'active' : '' ?>"><?= $item['name'] ?></li>
          <? endforeach ?>
        </ul>

        <div class="tabs-content">
          <? foreach ($videos_tabs_content as $key => $item) : ?>
            <div id="tab-<?= $key + 1 ?>-group1" class="tab-item <?= $key === 0 ? 'active' : '' ?>">
              <div class="tab-content">
                <div class="videolist">
                  <? foreach ($item['frame_videos'] as $video): ?>
                    <div class="video-box">
                      <?= $video['frame_video'] ?>
                    </div>
                  <? endforeach; ?>
                </div>
              </div>
            </div>
          <? endforeach; ?>
        </div>
      </div>

      <? if ($videos_links_title || $videos_links): ?>
        <div class="howtovideos__info">
          <? if ($videos_links_title): ?>
            <div class="howtovideos__info-title"><?= $videos_links_title ?></div>
          <? endif; ?>
          <? if ($videos_links): ?>
            <div class="howtovideos__info-text">
              <? foreach ($videos_links as $item): ?>
                <a href="<?= $item['link'] ?>" class="howtovideos__info-link"><?= $item['name'] ?>
                  <u><?= $item['link'] ?></u></a>
              <? endforeach; ?>
            </div>
          <? endif; ?>
        </div>
      <? endif; ?>
    </div>
  </section>
<?

  return ob_get_clean();
}
add_shortcode('videos_section', 'lira_videos_section_shortcode');
