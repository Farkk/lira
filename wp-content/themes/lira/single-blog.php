<?
get_header();

$sidebar_img = get_field('sidebar_img', 'option');
$sidebar_desc = get_field('sidebar_desc', 'option');
$sidebar_skill = get_field('sidebar_skill', 'option');
$sidebar_link = get_field('sidebar_skill', 'option');

$recomends = get_field('recomends');
?>

<main>

  <? lira_breadcrumbs(); ?>


  <div class="page-content">
    <div class="page-content__container">
      <h1 class="entry-title"><?= the_title() ?></h1>
      <article id="post" class="post type-post">
        <div class="entry-content">
          <?= the_content() ?>
      </article>

      <aside id="sidebar-primary" class="sidebar widget-area">
        <div class="sidebar-wrapper">
          <section id="block-2" class="sidebar-block author-info">
            <div class="author-info__head">
              <fugure class="author-photo">
                <img src="<?= $sidebar_img ?>" alt="author" width="auto" height="auto">
              </fugure>
              <p><?= $sidebar_desc ?></p>
            </div>
            <div class="author-info__text">
              <p><?= $sidebar_skill ?></p>
              <a href="<?= $sidebar_link ?>">Подробнее обо мне</a>
              <p><b>Если есть вопросы по услугам, то напишите мне в мессенджеры</b></p>
            </div>
            <div class="author-info__foot">
              <a href="<?= get_field('link_wa', 'option') ?>" class="author-btn author-wpp" target="_blank">
                <span class="icon-whatsapp"></span>
                Ватсап
              </a>
              <a href="<?= get_field('link_tg', 'option') ?>" class="author-btn author-tg" target="_blank">
                <span class="icon-telegram"></span>
                Телеграм
              </a>
            </div>
          </section>
        </div>
      </aside>
    </div>
  </div>

  <!-- services -->
  <section id="sliders" class="slider-section">
    <div class="slider-section__container-w">

      <!-- recommendations -->
      <div class="slider-box">
        <div class="slider-heading">
          <h3>Рекомендую</h3>
          <div class="slider-navigation">
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
          </div>
        </div>


        <div class="services-slider-base">
          <div class="swiper services-slider">
            <div class="swiper-wrapper">
              <? if ($recomends && !empty($recomends)):
                foreach ($recomends as $post_id):
                  $price = get_field('price', $post_id); // Цена со скидкой (текущая)
                  $price_old = get_field('price_old', $post_id); // Цена без скидки (старая)

                  // Если основная цена пустая, но есть старая цена - используем её как основную
                  if (empty($price) && !empty($price_old)) {
                    $price = $price_old;
                    $price_old = '';
                  }

                  $thumbnail_id = get_post_thumbnail_id($post_id);
                  $item_categories = get_the_terms($post_id, 'service_category');
                  $badges = get_the_terms($post_id, 'service_badge');

                  // Проверяем наличие скидки
                  $has_discount = !empty($price_old) && !empty($price) && $price_old > $price;
                  // Автоматически вычисляем процент скидки
                  $discount_percent = $has_discount ? round((($price_old - $price) / $price_old) * 100) : 0;
              ?>
                  <div class="swiper-slide">
                    <a href="<?= get_permalink($post_id) ?>" class="slide-image">
                      <? if ($thumbnail_id): ?>
                        <img src="<?= kama_thumb_src('w=392&h=230', $thumbnail_id); ?>"
                          srcset="<?= kama_thumb_src('w=270&h=190', $thumbnail_id); ?> 270w,
                                  <?= kama_thumb_src('w=392&h=230', $thumbnail_id); ?> 392w"
                          sizes="(max-width: 1239px) 270px, 392px"
                          alt="<?= esc_attr(get_the_title($post_id)) ?>">
                      <? else: ?>
                        <img src="<?= get_template_directory_uri() ?>/img/article-thumb-1.webp" alt="<?= esc_attr(get_the_title($post_id)) ?>">
                      <? endif; ?>

                      <? if ($badges && !is_wp_error($badges)): ?>
                        <span class="img-badge" aria-label="<?= esc_attr($badges[0]->name) ?>"><?= $badges[0]->name ?></span>
                      <? endif; ?>
                    </a>

                    <div class="slide-inner">
                      <div class="slide-inner__top">
                        <div class="slide-info">
                          <? if ($item_categories && !is_wp_error($item_categories)): ?>
                            <a href="<?= get_term_link($item_categories[0]) ?>" class="slide-category"><?= $item_categories[0]->name ?></a>
                          <? endif; ?>

                          <? if ($has_discount): ?>
                            <span class="slide-badge sale-badge">Скидка <?= $discount_percent ?>%</span>
                          <? endif; ?>
                        </div>
                        <a href="<?= get_permalink($post_id) ?>" class="slide-title"><?= get_the_title($post_id) ?></a>
                      </div>

                      <div class="slide-inner__foot">
                        <div class="slide-price">
                          <? if ($price): ?>
                            <? if ($has_discount): ?>
                              <span class="current-price" aria-label="Текущая цена"><?= number_format($price, 0, '', ' ') ?> <span>₽</span></span>
                              <span class="old-price"><s><?= number_format($price_old, 0, '', ' ') ?> <span>₽</span></s></span>
                            <? else: ?>
                              <span class="current-price" aria-label="Текущая цена"><?= number_format($price, 0, '', ' ') ?> <span>₽</span></span>
                            <? endif; ?>
                          <? endif; ?>
                        </div>
                        <div class="slide-views">
                          <span class="icon-views" aria-hidden="true"></span>
                          <span class="views-count"><?= lira_display_post_views($post_id); ?></span>
                        </div>
                      </div>
                    </div>
                  </div>
              <? endforeach;
              endif; ?>
            </div>
            <div class="swiper-pagination"></div>
          </div>
        </div>



      </div>

      <!-- blog -->
      <?= do_shortcode('[blog_slider]'); ?>

    </div>
  </section>


</main>


<? get_footer(); ?>
