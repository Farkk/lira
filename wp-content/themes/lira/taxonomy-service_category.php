<?= get_header(); ?>

<main>

  <? lira_breadcrumbs(); ?>

  <?
  // Get current term
  $current_term = get_queried_object();
  ?>

  <?
  // Setup pagination
  $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
  $args = array(
    'post_type' => 'service',
    'posts_per_page' => 12,
    'paged' => $paged,
    'tax_query' => array(
      array(
        'taxonomy' => 'service_category',
        'field' => 'term_id',
        'terms' => $current_term->term_id,
      ),
    ),
  );
  $service_query = new WP_Query($args);
  $has_pagination = $service_query->max_num_pages > 1;
  ?>

  <section class="blog-content"<? if (!$has_pagination): ?> style="margin-bottom: 50px;"<? endif; ?>>
    <div class="blog-content__container">
      <h1><?= esc_html($current_term->name) ?></h1>

      <div class="articles-list">
        <? if ($service_query->have_posts()) :
          while ($service_query->have_posts()) : $service_query->the_post();
            $thumbnail_id = get_post_thumbnail_id(get_the_ID());
            $categories = get_the_terms(get_the_ID(), 'service_category');
        ?>
            <article id="post-<?= get_the_ID(); ?>" class="post type-post">
              <a class="post-thumbnail" href="<?= get_permalink(); ?>">
                <? if ($thumbnail_id): ?>
                  <img src="<?= kama_thumb_src('w=392&h=230', $thumbnail_id); ?>"
                    srcset="<?= kama_thumb_src('w=270&h=190', $thumbnail_id); ?> 270w,
                            <?= kama_thumb_src('w=392&h=230', $thumbnail_id); ?> 392w"
                    sizes="(max-width: 1239px) 270px, 392px"
                    class="attachment-post-thumbnail"
                    alt="<?= esc_attr(get_the_title()); ?>">
                <? else: ?>
                  <img src="<?= get_template_directory_uri() ?>/img/blog-thumb-1.webp" class="attachment-post-thumbnail" alt="<?= esc_attr(get_the_title()); ?>">
                <? endif; ?>
              </a>

              <header class="article-header">
                <? if ($categories && !is_wp_error($categories)): ?>
                  <span class="cat-links"><a href="<?= get_term_link($categories[0]); ?>" rel="category tag"><?= $categories[0]->name; ?></a></span>
                <? endif; ?>
                <h2 class="article-title">
                  <a href="<?= get_permalink(); ?>" rel="bookmark"><?= get_the_title(); ?></a>
                </h2>
              </header>

              <footer class="article-footer">
                <a href="<?= get_permalink(); ?>" class="post-link">Прочитать</a>
                <div class="post-views">
                  <span class="icon-views" aria-hidden="true"></span>
                  <span class="views-count"><?= lira_display_post_views(get_the_ID()); ?></span>
                </div>
              </footer>
            </article>
          <? endwhile; ?>
        <? else: ?>
          <p>Услуг в этой категории пока нет</p>
        <? endif; ?>
      </div>

      <? if ($service_query->max_num_pages > 1): ?>
        <nav class="navigation pagination" aria-label="Posts pagination">
          <h2 class="screen-reader-text">Страницы</h2>
          <div class="nav-links">
            <?
            $pagination = paginate_links(array(
              'total' => $service_query->max_num_pages,
              'current' => $paged,
              'prev_text' => 'Вперед',
              'next_text' => 'Назад',
              'type' => 'array',
              'end_size' => 1,
              'mid_size' => 2,
            ));

            if ($pagination) {
              foreach ($pagination as $link) {
                echo $link;
              }
            }
            ?>
          </div>
        </nav>
      <? endif; ?>

      <? wp_reset_postdata(); ?>
    </div>
  </section>


</main>


<? get_footer(); ?>
