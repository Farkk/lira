<?php
/**
 * Service Advantages Shortcode
 *
 * Displays service advantages slider with Swiper
 * Usage: [service_advantages]
 */

function lira_service_advantages_shortcode() {
    // Get ACF field
    $advantages = get_field('advantages');

    // Check if data exists
    if (!$advantages || empty($advantages)) {
        return '';
    }

    // Start output buffering
    ob_start();
    ?>

    <div class="service-advantages">
        <div class="swiper service-advantages-slider">
            <div class="swiper-wrapper">
                <? foreach ($advantages as $item): ?>
                    <div class="swiper-slide">
                        <span><?= esc_html($item['title']) ?></span>
                        <p>
                            <?= wp_kses_post($item['desc']) ?>
                            <? if (!empty($item['text'])): ?>
                                <a href="#" class="help-link" data-text="<?= esc_attr($item['text']) ?>">?</a>
                            <? endif; ?>
                        </p>
                    </div>
                <? endforeach; ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>

    <?php
    return ob_get_clean();
}

// Register shortcode
add_shortcode('service_advantages', 'lira_service_advantages_shortcode');
