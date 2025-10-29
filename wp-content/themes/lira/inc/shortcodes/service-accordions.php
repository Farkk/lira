<?php

/**
 * Service Accordions Shortcode
 *
 * Displays accordions section with title and list items
 * Usage: [service_accordions]
 */

function lira_service_accordions_shortcode()
{
  // Get ACF fields
  $accordions_title = get_field('accordions_title');
  $accordions_list = get_field('accordions_list');

  // Check if data exists
  if (!$accordions_list || empty($accordions_list)) {
    return '';
  }

  // Start output buffering
  ob_start();
?>

  <h2><?= wp_kses_post($accordions_title) ?></h2>

  <div class="accordions">
    <? foreach ($accordions_list as $item): ?>
      <div class="accordion">
        <div class="accordion-title"><?= wp_kses_post($item['title']) ?></div>
        <div class="accordion-content">
          <p><?= wp_kses_post($item['text']) ?></p>
        </div>
      </div>
    <? endforeach; ?>
  </div>

<?php
  return ob_get_clean();
}

// Register shortcode
add_shortcode('service_accordions', 'lira_service_accordions_shortcode');
