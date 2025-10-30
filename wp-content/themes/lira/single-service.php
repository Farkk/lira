<?
get_header();
$benefits = get_field('benefit');

$price = get_field('price');
$discount = get_field('price_discount');
$has_discount = !empty($discount) && $discount > 0;
$discounted_price = $has_discount ? $price - ($price * $discount / 100) : $price;

$desc_old = get_field('desc_old');

$price_children = get_field('price_children');
$desc_children = get_field('desc_children');
$text_children = get_field('text_children');

$pay = get_field('pay');
$pay_link = get_field('pay_link');
$text_before_button = get_field('text_before_button');
$order_button_text = get_field('order_button_text'); // Текст кнопки "Заказать услугу"

// Проверка: есть ли хоть что-то для отображения в блоке service-info-block
$has_service_info = !empty($price) || !empty($price_children) || !empty($pay) || !empty($order_button_text);

$sidebar_img = get_field('sidebar_img', 'option');
$sidebar_desc = get_field('sidebar_desc', 'option');
$sidebar_skill = get_field('sidebar_skill', 'option');
$sidebar_link = get_field('sidebar_link', 'option');

// Проверка: есть ли контент для блока author-info
$has_author_info = !empty($sidebar_img) || !empty($sidebar_desc) || !empty($sidebar_skill) || !empty($sidebar_link);

$recomends = get_field('recomends');

// Получаем данные для табов
$service_info = get_field('service_info');
$prepare_session = get_field('prepare_session');

// Проверка: есть ли контент для секции с табами
$has_tabs_content = !empty($service_info) || !empty($prepare_session);
?>


<main>
  <? lira_breadcrumbs(); ?>

  <div class="page-content">
    <div class="page-content__container">
      <h1 class="entry-title"><?= the_title(); ?></h1>
      <article id="post" class="post type-post">
        <? if ($benefits && !empty($benefits)): ?>
          <header class="entry-header">
            <div class="service-benefits">
              <? foreach ($benefits as $item): ?>
                <div class="service-benefits__item">
                  <figure class="service-benefits__icon">
                    <img src="<?= wp_get_attachment_image_url($item['icon'], 'full'); ?>"
                      srcset="<?= kama_thumb_src('w=20', $item['icon']); ?> 20w,
                      <?= kama_thumb_src('w=28', $item['icon']); ?>?> 28w" sizes="(min-width: 1240px) 28px, 20px"
                      alt="benefit">
                  </figure>
                  <span class="service-benefits__text">
                    <?= $item['title'] ?>
                    <? if ($item['text'] != ''): ?>
                      <a href="#" class="help-link"
                        data-text="<?= $item['text'] ?>">?</a>
                    <? endif; ?>
                  </span>
                </div>
              <? endforeach; ?>
            </div>
          </header>
        <? endif; ?>
        <div class="entry-content">
          <?= the_content(); ?>
        </div>
		  
		  <?=do_shortcode('[service_accordions]')?>
		  <?=do_shortcode('[service_advantages]')?>
      </article>

      <aside id="sidebar-primary" class="sidebar widget-area">
        <? if ($has_service_info): ?>
          <div class="sidebar-title">Заказать услугу —</div>
        <? endif; ?>

        <div class="sidebar-wrapper">
          <? if ($has_service_info): ?>
            <section id="block-1" class="sidebar-block service-info-block">
              <?
              // Получаем бейджи текущего поста
              $badges = get_the_terms(get_the_ID(), 'service_badge');
              ?>
              <? if ($badges && !is_wp_error($badges)): ?>
                <div class="service-bages">
                  <? foreach ($badges as $badge):
                    $badge_color = get_field('badge_color', 'service_badge_' . $badge->term_id); // CSS класс, например: servicebage-red
                    $badge_icon = get_field('badge_icon', 'service_badge_' . $badge->term_id); // CSS класс иконки, например: icon-percent
                  ?>
                    <span class="servicebage <?= $badge_color ? $badge_color : 'servicebage-green' ?>">
                      <? if ($badge_icon): ?>
                        <span class="<?= $badge_icon ?>"></span>
                      <? endif; ?>
                      <?= $badge->name ?>
                    </span>
                  <? endforeach; ?>
                </div>
              <? endif; ?>

              <? if (!empty($price) || !empty($price_children)): ?>
                <div class="service-prices">
                  <? if (!empty($price)): ?>
                    <div class="block-price">
                      <p class="block-price-title">Стоимость в росс. рублях —</p>
                      <div class="block-price-row">
                        <span class="price"><?= $price ?> <span><span>₽</span></span></span>
                        <? if ($has_discount): ?>
                          <span class="sale-price">-<?= $discount ?><p>%</p></span>
                          <s><?= $discounted_price ?> <span><span>₽</span></span></s>
                        <? endif; ?>
                      </div>
                      <? if ($desc_old != ''): ?>
                        <p><?= $desc_old ?></p>
                      <? endif; ?>
                    </div>
                  <? endif; ?>

                  <? if (!empty($price_children) && $price_children > 0): ?>
                    <div class="block-price">
                      <span class="price"><?= $price_children ?> <span><span>₽</span></span></span>
                      <p>
                        <?= $desc_children ?>
                        <? if ($text_children != ''): ?>
                          <a href="#" class="help-link" data-text="<?= $text_children ?>">?</a>
                        <? endif; ?>
                      </p>
                    </div>
                  <? endif; ?>
                </div>
              <? endif; ?>

              <? if (!empty($pay) || !empty($order_button_text)): ?>
                <div class="service-footer">
                  <? if (!empty($pay)): ?>
                    <p><?= $pay ?></p>
                  <? endif; ?>

                  <? if (!empty($order_button_text)): ?>
                    <div class="service-order-box">
                      <? if ($text_before_button != ''): ?>
                        <p><?= $text_before_button ?></p>
                      <? endif; ?>
                      <a href="<?= $pay_link != '' ? $pay_link : '#callback' ?>" class="button button-primary <? $pay_link != '' ? '' : 'fancybox' ?>">
                        <span class="icon-cart"></span>
                        <?= $order_button_text ?>
                      </a>
                    </div>
                  <? endif; ?>
                </div>
              <? endif; ?>
            </section>
          <? endif; ?>

          <? if ($has_author_info): ?>
            <section id="block-2" class="sidebar-block author-info">
              <? if (!empty($sidebar_img) || !empty($sidebar_desc)): ?>
                <div class="author-info__head">
                  <? if (!empty($sidebar_img)): ?>
                    <fugure class="author-photo">
                      <img src="<?= $sidebar_img ?>" alt="author" width="auto" height="auto">
                    </fugure>
                  <? endif; ?>
                  <? if (!empty($sidebar_desc)): ?>
                    <p><?= $sidebar_desc ?></p>
                  <? endif; ?>
                </div>
              <? endif; ?>

              <? if (!empty($sidebar_skill) || !empty($sidebar_link)): ?>
                <div class="author-info__text">
                  <? if (!empty($sidebar_skill)): ?>
                    <p><?= $sidebar_skill ?></p>
                  <? endif; ?>
                  <? if (!empty($sidebar_link)): ?>
                    <a href="<?= $sidebar_link ?>">Подробнее обо мне</a>
                  <? endif; ?>
                  <p><b>Если есть вопросы по услугам, то напишите мне в мессенджеры</b></p>
                </div>
              <? endif; ?>

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
          <? endif; ?>
        </div>
      </aside>
    </div>
  </div>

  <? if ($has_tabs_content): ?>
    <section class="service-fullinfo">
      <div class="service-fullinfo__container">
        <div class="tabs" data-group="1">
          <ul class="tabs-nav">
            <? if (!empty($service_info)): ?>
              <li data-tab="tab-1-group1" class="active">Подробнее об услуге</li>
            <? endif; ?>
            <? if (!empty($prepare_session)): ?>
              <li data-tab="tab-2-group1" <? if (empty($service_info)): ?>class="active" <? endif; ?>>Как подготовиться</li>
            <? endif; ?>
            <li data-tab="tab-3-group1" <? if (empty($service_info) && empty($prepare_session)): ?>class="active" <? endif; ?>>Вопросы и ответы</li>
          </ul>

          <div class="tabs-content">
            <? if (!empty($service_info)): ?>
              <div id="tab-1-group1" class="tab-item active">
                <div class="tab-content">
                  <div class="collapsible">
                    <?= $service_info ?>
                  </div>
                </div>
              </div>
            <? endif; ?>

            <? if (!empty($prepare_session)): ?>
              <div id="tab-2-group1" class="tab-item <? if (empty($service_info)): ?>active<? endif; ?>">
                <div class="tab-content">
                  <div class="tab-content-col">
                    <div class="collapsible">
                      <?= $prepare_session ?>
                    </div>
                  </div>
                </div>
              </div>
            <? endif; ?>

            <div id="tab-3-group1" class="tab-item <? if (empty($service_info) && empty($prepare_session)): ?>active<? endif; ?>">
              <div class="tab-content">
                <div class="tab-content-col">
                  <?= do_shortcode('[faq_section]'); ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  <? endif; ?>

  <!-- videos  -->
  <?= do_shortcode('[videos_section]'); ?>

  <!-- myservices -->
  <?= do_shortcode('[myservices_section]'); ?>

  <!-- reviews -->
  <?= do_shortcode('[reviews_section]'); ?>

  <!-- contactform7 -->
  <?= do_shortcode('[getconsult_section]'); ?>

  <!-- recommendations -->
  <? if ($recomends && !empty($recomends)): ?>
    <section id="sliders" class="slider-section">
      <div class="slider-section__container-w">
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
                <? foreach ($recomends as $post_id):
                  $price = get_field('price', $post_id);
                  $discount = get_field('price_discount', $post_id);
                  $thumbnail_id = get_post_thumbnail_id($post_id);
                  $item_categories = get_the_terms($post_id, 'service_category');
                  $badges = get_the_terms($post_id, 'service_badge');

                  $has_discount = !empty($discount) && $discount > 0;
                  $discounted_price = $has_discount ? $price - ($price * $discount / 100) : $price;
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
                            <span class="slide-badge sale-badge">Скидка <?= round($discount) ?>%</span>
                          <? endif; ?>
                        </div>
                        <a href="<?= get_permalink($post_id) ?>" class="slide-title"><?= get_the_title($post_id) ?></a>
                      </div>

                      <div class="slide-inner__foot">
                        <div class="slide-price">
                          <? if ($price): ?>
                            <? if ($has_discount): ?>
                              <span class="current-price" aria-label="Текущая цена"><?= number_format($discounted_price, 0, '', ' ') ?> <span>₽</span></span>
                              <span class="old-price"><s><?= number_format($price, 0, '', ' ') ?> <span>₽</span></s></span>
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
                <? endforeach; ?>
              </div>
              <div class="swiper-pagination"></div>
            </div>
          </div>



        </div>
        <!-- blog -->
        <?= do_shortcode('[blog_slider]'); ?>
      </div>
    </section>
  <? endif; ?>


</main>

<? get_footer() ?>
