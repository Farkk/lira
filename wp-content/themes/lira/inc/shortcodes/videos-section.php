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
 * Usage: [videos_section] или [videos_section post_id="current"]
 *
 * Pulls data from ACF fields:
 * - videos_title
 * - videos_tabs (repeater: name)
 * - videos_tabs_content (repeater: frame_videos)
 * - videos_links_title
 * - videos_links (repeater: name, link)
 *
 * Если post_id="current" - берёт данные из текущего поста
 * Если данных нет на текущем посте - откатывается к странице ID 7
 */
function lira_videos_section_shortcode($atts)
{
  // Парсим атрибуты
  $atts = shortcode_atts([
    'post_id' => 7, // По умолчанию страница ID 7
  ], $atts);

  // Если указан current - берём текущий пост
  if ($atts['post_id'] === 'current') {
    $post_id = get_the_ID();
  } else {
    $post_id = intval($atts['post_id']);
  }

  // ID страницы для fallback (главная страница)
  $fallback_id = 7;

  // Для каждого поля проверяем: если есть на текущей странице - берём оттуда, если нет - с главной

  // videos_title
  $videos_title = get_field('videos_title', $post_id);
  if (empty($videos_title) && $post_id != $fallback_id) {
    $videos_title = get_field('videos_title', $fallback_id);
  }

  // videos_tabs
  $videos_tabs = get_field('videos_tabs', $post_id);
  if ((!$videos_tabs || empty($videos_tabs)) && $post_id != $fallback_id) {
    $videos_tabs = get_field('videos_tabs', $fallback_id);
  }

  // videos_tabs_content
  $videos_tabs_content = get_field('videos_tabs_content', $post_id);
  if ((!$videos_tabs_content || empty($videos_tabs_content)) && $post_id != $fallback_id) {
    $videos_tabs_content = get_field('videos_tabs_content', $fallback_id);
  }

  // videos_links_title
  $videos_links_title = get_field('videos_links_title', $post_id);
  if (empty($videos_links_title) && $post_id != $fallback_id) {
    $videos_links_title = get_field('videos_links_title', $fallback_id);
  }

  // videos_links
  $videos_links = get_field('videos_links', $post_id);
  if ((!$videos_links || empty($videos_links)) && $post_id != $fallback_id) {
    $videos_links = get_field('videos_links', $fallback_id);
  }

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

      <div class="tabs" data-group="videos">
        <ul class="tabs-nav">
          <? foreach ($videos_tabs as $key => $item) : ?>
            <li data-tab="tab-<?= $key + 1 ?>-groupvideos" class="<?= $key === 0 ? 'active' : '' ?>"><?= $item['name'] ?></li>
          <? endforeach ?>
        </ul>

        <div class="tabs-content">
          <? foreach ($videos_tabs_content as $key => $item) : ?>
            <div id="tab-<?= $key + 1 ?>-groupvideos" class="tab-item <?= $key === 0 ? 'active' : '' ?>">
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
