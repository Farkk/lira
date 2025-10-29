<?php

/**
 * Blog Section Shortcode
 *
 * Displays blog posts slider
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
  exit;
}

/**
 * Blog Section Shortcode
 * Usage: [blog_section count="5"]
 *
 * Retrieves blog posts from custom post type 'blog'
 *
 * @param int count - Количество постов для вывода (по умолчанию -1, все посты)
 */
function lira_blog_section_shortcode($atts)
{
  // Параметры шорткода
  $atts = shortcode_atts(
    array(
      'count' => -1, // По умолчанию все посты
    ),
    $atts,
    'blog_section'
  );

  // Get blog posts
  $blog_posts = get_posts([
    'post_type' => 'blog',
    'posts_per_page' => intval($atts['count']),
    'orderby' => 'date',
    'order' => 'DESC'
  ]);

  // Start output buffering
  ob_start();
?>
  <section id="blog" class="slider-section blog">
    <div class="slider-section__container-w">
      <div class="slider-box">
        <div class="slider-heading">
          <h3>Блог</h3>
          <div class="slider-navigation">
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
          </div>
        </div>

        <div class="services-slider-base">
          <div class="swiper blog-slider">
            <div class="swiper-wrapper">
              <? if ($blog_posts && count($blog_posts) > 0):
                foreach ($blog_posts as $post):
                  setup_postdata($post);
                  $thumbnail_id = get_post_thumbnail_id($post->ID);
                  $categories = get_the_terms($post->ID, 'blog_category');
              ?>
                  <div class="swiper-slide">
                    <a href="<?= get_permalink($post->ID) ?>" class="slide-image">
                      <? if ($thumbnail_id): ?>
                        <img src="<?= kama_thumb_src('w=392&h=230', $thumbnail_id); ?>"
                          srcset="<?= kama_thumb_src('w=270&h=190', $thumbnail_id); ?> 270w,
                                  <?= kama_thumb_src('w=392&h=230', $thumbnail_id); ?> 392w"
                          sizes="(max-width: 1239px) 270px, 392px"
                          alt="<?= esc_attr(get_the_title($post->ID)) ?>">
                      <? else: ?>
                        <img src="<?= get_template_directory_uri() ?>/img/blog-thumb-1.webp" alt="<?= esc_attr(get_the_title($post->ID)) ?>">
                      <? endif; ?>
                    </a>

                    <div class="slide-inner">
                      <div class="slide-inner__top">
                        <? if ($categories && !is_wp_error($categories)): ?>
                          <a href="<?= get_term_link($categories[0]) ?>" class="slide-category"><?= $categories[0]->name ?></a>
                        <? endif; ?>
                        <a href="<?= get_permalink($post->ID) ?>" class="slide-title"><?= get_the_title($post->ID) ?></a>
                      </div>

                      <div class="slide-inner__foot">
                        <a href="<?= get_permalink($post->ID) ?>" class="slide-permalink">Прочитать</a>
                        <div class="slide-views">
                          <span class="icon-views" aria-hidden="true"></span>
                          <span class="views-count"><?= lira_display_post_views($post->ID); ?></span>
                        </div>
                      </div>
                    </div>
                  </div>
                <? endforeach;
                wp_reset_postdata();
              else: ?>
                <div class="swiper-slide">
                  <p>Записей блога пока нет</p>
                </div>
              <? endif; ?>
            </div>
            <div class="swiper-pagination"></div>
          </div>
        </div>

      </div>
    </div>
  </section>
<?

  return ob_get_clean();
}
add_shortcode('blog_section', 'lira_blog_section_shortcode');
