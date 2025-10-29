<?= get_header(); ?>

<main>

  <? lira_breadcrumbs(); ?>

  <?
  // Get current term
  $current_term = get_queried_object();
  ?>

  <section class="blog-content">
    <div class="blog-content__container">
      <h1><?= esc_html($current_term->name) ?></h1>

      <div class="articles-list">
        <? if (have_posts()) :
          while (have_posts()) : the_post();
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

      <!-- <? if (function_exists('the_posts_pagination')) : ?>
        <nav class="navigation pagination" aria-label="Posts pagination">
          <h2 class="screen-reader-text">Posts pagination</h2>
          <?
              the_posts_pagination(array(
                'mid_size' => 2,
                'prev_text' => 'Prev',
                'next_text' => 'Next',
                'screen_reader_text' => __('Posts navigation'),
              ));
          ?>
        </nav>
      <? endif; ?> -->

      <nav class="navigation pagination" aria-label="Posts pagination">
        <h2 class="screen-reader-text">Страницы</h2>
        <div class="nav-links">
          <a class="prev page-numbers disabled" href="#">Вперед</a>
          <span aria-current="page" class="page-numbers current">1</span>
          <a class="page-numbers" href="#">2</a>
          <a class="page-numbers" href="#">3</a>
          <a class="page-numbers" href="#">4</a>
          <a class="page-numbers" href="#">5</a>
          <a class="next page-numbers" href="#">Назад</a>
        </div>
      </nav>
    </div>
  </section>


</main>


<? get_footer(); ?>
