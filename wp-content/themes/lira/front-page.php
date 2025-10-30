<?
get_header();
?>
<main>
  <!-- hero -->
  <?
  $hero_img = get_field('hero_img');
  $hero_img_mobile = get_field('hero_img_mobile');
  $hero_title = get_field('hero_title');
  $hero_desc = get_field('hero_desc');
  $hero_benefits = get_field('hero_benefits');
  ?>
  <section id="hero" class="hero">
    <div class="hero__inner">
      <div class="hero__img">
        <picture>
          <source media="(min-width: 1024px)" srcset="<?= $hero_img  ?>">
          <img src="<?= $hero_img_mobile ?>" alt="lira">
        </picture>
      </div>
      <div class="hero__text">
        <h1 class="site-title"><?= $hero_title ?></h1>
        <p class="site-desc"><?= $hero_desc ?></p>

        <div class="hero__benefits">
          <? foreach ($hero_benefits as $item): ?>
            <div class="hero__benefit">
              <div class="hero__benefit__icon">
                <img src="<?= $item['icon']['url'] ?>" alt="<?= $item['icon']['alt'] != '' ? $item['icon']['alt'] : 'benefit' ?>" width="100%" height="100%">
              </div>
              <div class="hero__benefit__text"><?= $item['text'] ?></div>
            </div>
          <? endforeach; ?>
        </div>

        <a href="#modal-call" class="button-outline fancybox">Подробнее обо мне</a>
      </div>
    </div>
  </section>

  <!-- problems -->
  <?
  $problems_title = get_field('problems_title');
  $problems_items = get_field('problems_items');
  ?>
  <section id="problems" class="problems">
    <div class="problems__container">
      <h2><?= $problems_title ?></h2>
      <ul class="list">
        <? foreach ($problems_items as $item): ?>
          <li><?= $item['text'] ?></li>
        <? endforeach; ?>
      </ul>
    </div>
  </section>

  <!-- how work -->
  <?
  $howwork_title = get_field('howwork_title');
  $howwork_desc = get_field('howwork_desc');
  $howwork_steps = get_field('howwork_steps');
  ?>
  <section id="howwork" class="howwork">
    <div class="howwork__container">
      <h2><?= $howwork_title ?></h2>
      <p><?= $howwork_desc ?></p>

      <div class="steps-list">
        <? foreach ($howwork_steps as $item) : ?>
          <div class="steps-list__item">
            <div class="steps-list__item-icon">
              <img src="<?= $item['icon']['url'] ?>" alt="<?= $item['icon']['alt'] != '' ? $item['icon']['alt'] : 'step' ?>">
            </div>
            <div class="steps-list__item-title"><?= $item['title'] ?></div>
            <div class="steps-list__item-text">
              <?= $item['desc'] ?>
            </div>
          </div>
        <? endforeach; ?>
      </div>

      <a href="#callback" class="button-primary btn-large fancybox">
        <span class="icon-linkarrow"></span>
        Записаться на прием
      </a>
    </div>
  </section>

  <!-- services -->
  <section id="sliders" class="slider-section">
    <div class="slider-section__container-w">

      <?
      // Get all service categories
      $service_categories = get_terms([
        'taxonomy' => 'service_category',
        'hide_empty' => true,
        'orderby' => 'date',
        'order' => 'DESC'
      ]);

      // Loop through each category and create a slider
      if ($service_categories && !is_wp_error($service_categories)):
        foreach ($service_categories as $category):
          // Get field name based on category slug (e.g., 'services_courses' for 'courses' category)
          $field_name = 'services_' . $category->slug;

          // Check if specific services are selected for this category on the page
          $selected_services = get_field($field_name);

          // Build query arguments
          $query_args = [
            'post_type' => 'service',
            'posts_per_page' => -1,
          ];

          // If specific services are selected, use them; otherwise get all from category
          if ($selected_services && !empty($selected_services)) {
            // ACF Relationship field returns array of post objects, extract IDs
            $post_ids = [];
            if (is_array($selected_services)) {
              foreach ($selected_services as $post) {
                $post_ids[] = is_object($post) ? $post->ID : $post;
              }
            } else {
              // Handle case where single ID is returned
              $post_ids = [is_object($selected_services) ? $selected_services->ID : $selected_services];
            }

            $query_args['post__in'] = $post_ids;
            $query_args['orderby'] = 'post__in'; // Preserve the selected order
          } else {
            // Get all services from this category
            $query_args['tax_query'] = [
              [
                'taxonomy' => 'service_category',
                'field' => 'term_id',
                'terms' => $category->term_id,
              ]
            ];
          }

          $services_query = new WP_Query($query_args);

          if ($services_query->have_posts()):
      ?>
            <div class="slider-box">
              <div class="slider-heading">
                <h3><?= esc_html($category->name) ?></h3>
                <div class="slider-navigation">
                  <div class="swiper-button-prev"></div>
                  <div class="swiper-button-next"></div>
                </div>
              </div>

              <div class="services-slider-base">
                <div class="swiper services-slider">
                  <div class="swiper-wrapper">
                    <? while ($services_query->have_posts()): $services_query->the_post();
                      $price = get_field('price'); // Цена со скидкой (текущая)
                      $price_old = get_field('price_old'); // Цена без скидки (старая)

                      // Если основная цена пустая, но есть старая цена - используем её как основную
                      if (empty($price) && !empty($price_old)) {
                        $price = $price_old;
                        $price_old = '';
                      }

                      $thumbnail_id = get_post_thumbnail_id(get_the_ID());
                      $item_categories = get_the_terms(get_the_ID(), 'service_category');
                      $badges = get_the_terms(get_the_ID(), 'service_badge');

                      // Проверяем наличие скидки
                      $has_discount = !empty($price_old) && !empty($price) && $price_old > $price;
                      // Автоматически вычисляем процент скидки
                      $discount_percent = $has_discount ? round((($price_old - $price) / $price_old) * 100) : 0;
                    ?>
                      <div class="swiper-slide">
                        <a href="<?= get_permalink() ?>" class="slide-image">
                          <? if ($thumbnail_id): ?>
                            <img src="<?= kama_thumb_src('w=392&h=230', $thumbnail_id); ?>"
                              srcset="<?= kama_thumb_src('w=270&h=190', $thumbnail_id); ?> 270w,
                                      <?= kama_thumb_src('w=392&h=230', $thumbnail_id); ?> 392w"
                              sizes="(max-width: 1239px) 270px, 392px"
                              alt="<?= esc_attr(get_the_title()) ?>">
                          <? else: ?>
                            <img src="<?= get_template_directory_uri() ?>/img/article-thumb-1.webp" alt="<?= esc_attr(get_the_title()) ?>">
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
                            <a href="<?= get_permalink() ?>" class="slide-title"><?= get_the_title() ?></a>
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
                              <span class="views-count"><?= lira_display_post_views(get_the_ID()); ?></span>
                            </div>
                          </div>
                        </div>
                      </div>
                    <? endwhile;
                    wp_reset_postdata(); ?>
                  </div>
                  <div class="swiper-pagination"></div>
                </div>
              </div>

            </div>
      <?
          endif; // end if have_posts
        endforeach; // end foreach category
      endif; // end if categories exist
      ?>

    </div>
  </section>

  <!-- videos  -->
  <?= do_shortcode('[videos_section]'); ?>

  <!-- faq -->
  <?= do_shortcode('[faq_section]'); ?>

  <!-- myservices -->
  <?= do_shortcode('[myservices_section]'); ?>

  <!-- reviews -->
  <?= do_shortcode('[reviews_section]'); ?>

  <!-- contactform7 -->
  <?= do_shortcode('[getconsult_section]'); ?>

  <!-- blog -->
  <?= do_shortcode('[blog_section]'); ?>
</main>
<?
get_footer();
?>
