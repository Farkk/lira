<?
get_header();
$benefits = get_field('benefit');

$price = get_field('price'); // Цена со скидкой (текущая цена)
$price_old = get_field('price_old'); // Цена без скидки (старая цена)

// Если основная цена пустая, но есть старая цена - используем её как основную
if (empty($price) && !empty($price_old)) {
  $price = $price_old;
  $price_old = '';
}

// Проверяем наличие скидки: если есть старая цена и она больше текущей
$has_discount = !empty($price_old) && !empty($price) && $price_old > $price;

// Автоматически вычисляем процент скидки с округлением до единиц
$discount_percent = $has_discount ? round((($price_old - $price) / $price_old) * 100) : 0;

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

$question_title = get_field('question_title');
$questions = get_field('questions');

$videos_title = get_field('videos_title');
$videos_tabs = get_field('videos_tabs');
$videos_tabs_content = get_field('videos_tabs_content');

$reviews_title = get_field('reviews_title');
$reviews_desc = get_field('reviews_desc');
$reviews_images = get_field('reviews_images');
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
          <?= $service_info; ?>
        </div>

        <?= do_shortcode('[service_accordions]') ?>
        <?= do_shortcode('[service_advantages]') ?>
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
                        <span class="price"><?= number_format($price, 0, '', ' ') ?> <span><span>₽</span></span></span>
                        <? if ($has_discount): ?>
                          <span class="sale-price">-<?= $discount_percent ?><p>%</p></span>
                          <s class=""><?= number_format($price_old, 0, '', ' ') ?> <span><span>₽</span></span></s>
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
                      <a href="<?= $pay_link != '' ? $pay_link : '#callback' ?>" class="button button-primary <?= $pay_link != '' ? '' : 'fancybox' ?>">
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
            <? if (!empty(get_the_content())): ?>
              <li data-tab="tab-1-group1" class="active">Подробнее об услуге</li>
            <? endif; ?>
            <? if (!empty($prepare_session)): ?>
              <li data-tab="tab-2-group1" <? if (empty($service_info)): ?>class="active" <? endif; ?>>Как подготовиться</li>
            <? endif; ?>
            <? if (!empty($question_title) || !empty($questions)) : ?>
              <li data-tab="tab-3-group1" <? if (empty($service_info) && empty($prepare_session)): ?>class="active" <? endif; ?>>Вопросы и ответы</li>
            <? endif; ?>
            <? if (!empty($videos_title) || !empty($videos_tabs) || !empty($videos_tabs_content)) : ?>
              <li data-tab="tab-4-group1" <? if (empty($service_info) && empty($prepare_session) && (!empty($question_title) || !empty($questions))): ?>class="active" <? endif; ?>>Видео</li>
            <? endif; ?>
            <? if (!empty($reviews_title) || !empty($reviews_images)) : ?>
              <li data-tab="tab-5-group1" <? if (empty($service_info) && empty($prepare_session) && (!empty($question_title) || !empty($questions))): ?>class="active" <? endif; ?>>Отзывы</li>
            <? endif; ?>
          </ul>

          <div class="tabs-content">
            <? if (!empty(get_the_content())): ?>
              <div id="tab-1-group1" class="tab-item active">
                <div class="tab-content">
                  <div class="collapsible">

                    <?= the_content(); ?>
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
            <? if (!empty($question_title) || !empty($questions)): ?>
              <div id="tab-3-group1" class="tab-item <? if (empty($service_info) && empty($prepare_session)): ?>active<? endif; ?>">
                <div class="tab-content">
                  <div class="tab-content-col">
                    <div class="faq-list">
                      <div class="faq__title"><?= $question_title ?></div>

                      <div class="faq-wrapper">
                        <? foreach ($questions as $quest): ?>
                          <article class="faq-item">
                            <h4 class="faq-title" id="faq1"><?= $quest['question'] ?></h4>
                            <p><?= $quest['ansver'] ?></p>
                          </article>
                        <? endforeach; ?>
                      </div>

                      <a href="#callback" class="button-primary btn-medium fancybox">
                        <span class="icon-question-r"></span>
                        Задать свой вопрос
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            <? endif; ?>
            <? if (!empty($videos_title) || !empty($videos_tabs) || !empty($videos_tabs_content)) : ?>
              <div id="tab-4-group1" class="tab-item <? if (empty($service_info) && empty($prepare_session) && ((!empty($question_title) || !empty($questions)))): ?>active<? endif; ?>">
                <div class="tab-content">
                  <div class="tab-content-col">
                    <?
                    // Логика получения данных для видео (аналогично шорткоду)
                    $current_post_id = get_the_ID();
                    $fallback_id = 7;

                    // Для каждого поля: если есть на текущей странице - берём, если нет - с главной
                    $videos_title_display = get_field('videos_title', $current_post_id);
                    
                    if (empty($videos_title_display)) {
                      $videos_title_display = get_field('videos_title', $fallback_id);
                    }

                    $videos_tabs_display = get_field('videos_tabs', $current_post_id);
                    if (!$videos_tabs_display || empty($videos_tabs_display)) {
                      $videos_tabs_display = get_field('videos_tabs', $fallback_id);
                    }
                    
                    $videos_tabs_content_display = get_field('videos_tabs_content', $current_post_id);

                   $has_videos = false;
                    if ($videos_tabs_content_display && !empty($videos_tabs_content_display)) {
                      foreach ($videos_tabs_content_display as $item) {
                        if (!empty($item['frame_videos'])) {
                          foreach ($item['frame_videos'] as $video) {
                            if (!empty($video['frame_video']) && trim($video['frame_video']) !== '') {
                              $has_videos = true;
                              break 2; // Выходим из обоих циклов
                            }
                          }
                        }
                      }
                    }
                    
                    // Если нет видео, берем с fallback
                    if (!$has_videos) {
                      $videos_tabs_content_display = get_field('videos_tabs_content', $fallback_id);
                    }

                    
                    $videos_links_title_display = get_field('videos_links_title', $current_post_id);
                    if (empty($videos_links_title_display)) {
                      $videos_links_title_display = get_field('videos_links_title', $fallback_id);
                    }

                    $videos_links_display = get_field('videos_links', $current_post_id);
                    if (!$videos_links_display || empty($videos_links_display)) {
                      $videos_links_display = get_field('videos_links', $fallback_id);
                    }
                    ?>

                    <? if ($videos_title_display): ?>
                      <div class="howtovideos__title"><?= $videos_title_display ?></div>
                    <? endif; ?>

                    <? if ($videos_tabs_display && !empty($videos_tabs_display)): ?>
                      <div class="tabs" data-group="videos">
                        <ul class="tabs-nav">
                          <? foreach ($videos_tabs_display as $key => $item) : ?>
                            <li data-tab="tab-<?= $key + 1 ?>-groupvideos" class="<?= $key === 0 ? 'active' : '' ?>"><?= $item['name'] ?></li>
                          <? endforeach ?>
                        </ul>

                        <div class="tabs-content">
                          <? foreach ($videos_tabs_content_display as $key => $item) : ?>
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
                    <? endif; ?>

                    <? if ($videos_links_title_display || $videos_links_display): ?>
                      <div class="howtovideos__info">
                        <? if ($videos_links_title_display): ?>
                          <div class="howtovideos__info-title"><?= $videos_links_title_display ?></div>
                        <? endif; ?>
                        <? if ($videos_links_display): ?>
                          <div class="howtovideos__info-text">
                            <? foreach ($videos_links_display as $item): ?>
                              <a href="<?= $item['link'] ?>" class="howtovideos__info-link"><?= $item['name'] ?>
                                <u><?= $item['link'] ?></u></a>
                            <? endforeach; ?>
                          </div>
                        <? endif; ?>
                      </div>
                    <? endif; ?>
                  </div>
                </div>
              </div>
            <? endif; ?>
            <? if (!empty($reviews_title) || !empty($reviews_images)) : ?>
              <div id="tab-5-group1" class="tab-item">
                <div class="tab-content">
                  <div class="tab-content-col">
                    <?
                    // Логика получения данных для отзывов (аналогично видео)
                    $current_post_id = get_the_ID();
                    $fallback_id = 7;

                    // Для каждого поля: если есть на текущей странице - берём, если нет - с главной
                    $reviews_title_display = get_field('reviews_title', $current_post_id);
                    if (empty($reviews_title_display)) {
                      $reviews_title_display = get_field('reviews_title', $fallback_id);
                    }

                    $reviews_desc_display = get_field('reviews_desc', $current_post_id);
                    if (empty($reviews_desc_display)) {
                      $reviews_desc_display = get_field('reviews_desc', $fallback_id);
                    }

                    $reviews_images_display = get_field('reviews_images', $current_post_id);
                    if (!$reviews_images_display || empty($reviews_images_display)) {
                      $reviews_images_display = get_field('reviews_images', $fallback_id);
                    }
                    ?>

                    <div class="reviews__heading">
                      <? if ($reviews_title_display): ?>
                        <div class="reviews__title"><?= $reviews_title_display ?></div>
                      <? endif; ?>
                      <? if ($reviews_desc_display): ?>
                        <p><?= $reviews_desc_display ?></p>
                      <? endif; ?>
                    </div>

                    <? if ($reviews_images_display && !empty($reviews_images_display)): ?>
                      <div class="reviews__list">
                        <div class="swiper reviews-slider">
                          <div class="swiper-wrapper">
                            <? foreach ($reviews_images_display as $item): ?>
                              <div class="swiper-slide reviews-item">
                                <a href="<?= wp_get_attachment_image_url($item, 'full'); ?>" class="reviews-item__img" data-fancybox="reviews">
                                  <img src="<?= kama_thumb_src('w=255&h=327', $item); ?>" alt="review-image" width="255" height="327">
                                </a>
                              </div>
                            <? endforeach; ?>
                          </div>
                          <div class="swiper-scrollbar"></div>
                          <div class="swiper-pagination"></div>
                          <div class="slider-navigation">
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>
                          </div>
                        </div>
                      </div>
                    <? endif; ?>
                  </div>
                </div>
              </div>
            <? endif; ?>
          </div>
        </div>
      </div>
    </section>
  <? endif; ?>

  <!-- videos  -->
  <!--<?= do_shortcode('[videos_section]'); ?>-->

  <!-- myservices -->
  <?= do_shortcode('[myservices_section]'); ?>

  <!-- reviews -->
  <!--<?= do_shortcode('[reviews_section]'); ?>-->

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
