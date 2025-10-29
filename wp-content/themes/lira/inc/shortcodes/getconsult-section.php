<?php

/**
 * Get Consult Section Shortcode
 *
 * Displays consultation form section with images from ACF fields
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
  exit;
}

/**
 * Get Consult Section Shortcode
 * Usage: [getconsult_section]
 *
 * Pulls data from ACF fields:
 * - form_images from options (array of images)
 * Note: Contact Form 7 shortcode is hardcoded in the template
 */
function lira_getconsult_section_shortcode($atts)
{
  // Get ACF fields from options
  $images = get_field('form_images', 'option');

  // Start output buffering
  ob_start();
?>
  <section id="getconsult" class="getconsult">
    <div class="getconsult__container">

      <div class="getconsult__image">
        <? if ($images && !empty($images)):
          foreach ($images as $key => $image): ?>
            <img src="<?= $image['url'] ?>"
              alt="<?= $image['alt'] != '' ? $image['alt'] : 'form image' ?>"
              class="getconsult__image-img<?= ($key + 1) === 1 ? 'first' : 'second' ?>"
              width="auto" height="auto">
          <? endforeach;
        endif; ?>
      </div>

      <div class="getconsult__formbox">
        <?= do_shortcode('[contact-form-7 id="03e0dcc" title="Заявка на консультацию"]'); ?>
      </div>
    </div>
  </section>
<?

  return ob_get_clean();
}
add_shortcode('getconsult_section', 'lira_getconsult_section_shortcode');
