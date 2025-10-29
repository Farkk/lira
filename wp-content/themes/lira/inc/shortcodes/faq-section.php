<?php

/**
 * FAQ Section Shortcode
 *
 * Displays FAQ section with data from ACF fields
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
  exit;
}

/**
 * FAQ Section Shortcode
 * Usage: [faq_section]
 *
 * Pulls data from ACF fields on the page where the shortcode is used:
 * - faq_title
 * - faq_items (repeater: question, answer)
 */
function lira_faq_section_shortcode($atts)
{
  // Get current page ID
  $page_id = 7;

  // Get ACF fields from current page
  $faq_title = get_field('faq_title', $page_id);
  $faq_items = get_field('faq_items', $page_id);

  // Check if we have data
  if (!$faq_items || empty($faq_items)) {
    return '';
  }

  // Start output buffering
  ob_start();
?>
  <section id="faq" class="faq">
    <div class="faq__container">
      <? if ($faq_title): ?>
        <div class="faq__title"><?= $faq_title ?></div>
      <? endif; ?>

      <div class="faq-wrapper">
        <? foreach ($faq_items as $key => $item): ?>
          <article class="faq-item">
            <h4 class="faq-title" id="faq<?= $key + 1 ?>"><?= $item['question'] ?></h4>
            <p><?= $item['answer'] ?></p>
          </article>
        <? endforeach; ?>
      </div>

      <a href="#callback" class="button-primary btn-medium fancybox">
        <span class="icon-question-r"></span>
        Задать свой вопрос
      </a>
    </div>
  </section>
<?

  return ob_get_clean();
}
add_shortcode('faq_section', 'lira_faq_section_shortcode');
