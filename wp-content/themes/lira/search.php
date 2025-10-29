<?= get_header(); ?>

<main>

    <section class="search-list">
        <div class="search-list__container">
            <?
            $search_query = get_search_query();
            $total_results = $GLOBALS['wp_query']->found_posts;
            ?>

            <? if ($search_query): ?>
                <h1 class="page-title">Результаты поиска по запросу: "<?= esc_html($search_query); ?>"</h1>
            <? else: ?>
                <h1 class="page-title">Результаты поиска</h1>
            <? endif; ?>

            <? if (have_posts()): ?>
                <div class="articles-list">
                    <? while (have_posts()): the_post();
                        $post_type = get_post_type();
                        $thumbnail_id = get_post_thumbnail_id(get_the_ID());

                        // Get categories based on post type
                        if ($post_type === 'blog') {
                            $categories = get_the_terms(get_the_ID(), 'blog_category');
                        } elseif ($post_type === 'service') {
                            $categories = get_the_terms(get_the_ID(), 'service_category');
                        } else {
                            $categories = get_the_category();
                        }
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
                                    <span class="cat-links">
                                        <a href="<?= get_term_link($categories[0]); ?>" rel="category tag"><?= $categories[0]->name; ?></a>
                                    </span>
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
                </div>

                <? if (function_exists('the_posts_pagination')) : ?>
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
                <? endif; ?>

            <? else: ?>
                <div class="articles-list">
                    <p>По вашему запросу ничего не найдено. Попробуйте изменить поисковый запрос.</p>
                </div>
            <? endif; ?>

            <div class="search-options">
                <h2>Искать ещё</h2>

                <form role="search" method="get" class="search-form" action="<?= esc_url(home_url('/')); ?>">
                    <label>
                        <span class="screen-reader-text">Поиск по сайту</span>
                        <input type="search" class="search-field" placeholder="Поиск по сайту" value="" name="s">
                    </label>
                    <button type="submit" class="search-submit">Поиск</button>
                </form>

            </div>
        </div>
    </section>

</main>

<? get_footer(); ?>
