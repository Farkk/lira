<?php
function enqueue_theme_assets()
{
  $styles = [
    // Стили для <head>
    [
      'handle' => 'lira-style',
      'src' => '/style.css',
      'deps' => [],
      'priority' => 1,
      'media' => 'all',
      'in_footer' => false
    ],
    [
      'handle' => 'lira-style-font-SFPro',
      'src' => '/fonts/SFPro/stylesheet.css',
      'deps' => ['lira-style'],
      'priority' => 2,
      'media' => 'all',
      'in_footer' => false
    ],
    [
      'handle' => 'lira-style-main',
      'src' => '/css/main.css',
      'deps' => ['lira-style', 'lira-style-font-SFPro'],
      'priority' => 3,
      'media' => 'all',
      'in_footer' => false
    ],
    [
      'handle' => 'lira-style-header',
      'src' => '/css/header.css',
      'deps' => ['lira-style', 'lira-style-font-SFPro', 'lira-style-main'],
      'priority' => 4,
      'media' => 'all',
      'in_footer' => false
    ],
    [
      'handle' => 'lira-style-hero',
      'src' => '/css/hero.css',
      'deps' => ['lira-style', 'lira-style-font-SFPro', 'lira-style-main', 'lira-style-header'],
      'priority' => 5,
      'media' => 'all',
      'in_footer' => false
    ],
    [
      'handle' => 'lira-style-font-mobile',
      'src' => '/fonts/NunitoSans/stylesheet.css',
      'deps' => ['lira-style', 'lira-style-font-SFPro', 'lira-style-main', 'lira-style-header', 'lira-style-hero'],
      'priority' => 6,
      'media' => 'screen and (min-width: 1240px)',
      'in_footer' => false
    ],
    // Условные стили для is_singular('service')
    [
      'handle' => 'lira-style-breadcrumbs',
      'src' => '/css/breadcrumbs.css',
      'deps' => ['lira-style', 'lira-style-font-SFPro', 'lira-style-main', 'lira-style-header', 'lira-style-hero'],
      'priority' => 7,
      'media' => 'all',
      'in_footer' => false,
      'condition' => function () {
        return is_singular('service') || is_singular('blog') || is_post_type_archive('blog') || is_page() || is_tax();
      }
    ],
    [
      'handle' => 'lira-style-single-services',
      'src' => '/css/single-services.css',
      'deps' => ['lira-style', 'lira-style-font-SFPro', 'lira-style-main', 'lira-style-header', 'lira-style-hero', 'lira-style-breadcrumbs'],
      'priority' => 8,
      'media' => 'all',
      'in_footer' => false,
      'condition' => function () {
        return is_singular('service');
      }
    ],
    [
      'handle' => 'lira-style-sidebar',
      'src' => '/css/sidebar.css',
      'deps' => ['lira-style', 'lira-style-font-SFPro', 'lira-style-main', 'lira-style-header', 'lira-style-hero', 'lira-style-breadcrumbs'],
      'priority' => 9,
      'media' => 'all',
      'in_footer' => false,
      'condition' => function () {
        return is_singular('service') || is_singular('blog');
      }
    ],
    [
      'handle' => 'lira-style-single-post',
      'src' => '/css/single-post.css',
      'deps' => ['lira-style', 'lira-style-font-SFPro', 'lira-style-main', 'lira-style-header', 'lira-style-hero', 'lira-style-breadcrumbs'],
      'priority' => 10,
      'media' => 'all',
      'in_footer' => false,
      'condition' => function () {
        return is_singular('blog') || is_tax();
      }
    ],
    [
      'handle' => 'lira-style-blog-archive',
      'src' => '/css/blog.css',
      'deps' => ['lira-style', 'lira-style-font-SFPro', 'lira-style-main', 'lira-style-header', 'lira-style-hero'],
      'priority' => 10,
      'media' => 'all',
      'in_footer' => false,
      'condition' => function () {
        return is_post_type_archive('blog') || is_search() || is_tax();
      }
    ],
    [
      'handle' => 'lira-style-taxonomy-service',
      'src' => '/css/taxonomy-service.css',
      'deps' => ['lira-style', 'lira-style-font-SFPro', 'lira-style-main', 'lira-style-header', 'lira-style-hero', 'lira-style-breadcrumbs'],
      'priority' => 10,
      'media' => 'all',
      'in_footer' => false,
      'condition' => function () {
        return is_tax('service_category');
      }
    ],
    // Стили для футера
    [
      'handle' => 'lira-style-problems',
      'src' => '/css/problems.css',
      'deps' => ['lira-style', 'lira-style-font-SFPro', 'lira-style-main', 'lira-style-header', 'lira-style-hero'],
      'priority' => 11,
      'media' => 'all',
      'in_footer' => true
    ],
    [
      'handle' => 'lira-style-howwork',
      'src' => '/css/howwork.css',
      'deps' => ['lira-style', 'lira-style-font-SFPro', 'lira-style-main', 'lira-style-header', 'lira-style-hero', 'lira-style-problems'],
      'priority' => 12,
      'media' => 'all',
      'in_footer' => true
    ],
    [
      'handle' => 'lira-style-slider-section',
      'src' => '/css/slider-section.css',
      'deps' => ['lira-style', 'lira-style-font-SFPro', 'lira-style-main', 'lira-style-header', 'lira-style-hero', 'lira-style-problems', 'lira-style-howwork'],
      'priority' => 13,
      'media' => 'all',
      'in_footer' => true
    ],
    [
      'handle' => 'lira-style-videos',
      'src' => '/css/videos.css',
      'deps' => ['lira-style', 'lira-style-font-SFPro', 'lira-style-main', 'lira-style-header', 'lira-style-hero', 'lira-style-problems', 'lira-style-howwork', 'lira-style-slider-section'],
      'priority' => 14,
      'media' => 'all',
      'in_footer' => true
    ],
    [
      'handle' => 'lira-style-faq',
      'src' => '/css/faq.css',
      'deps' => ['lira-style', 'lira-style-font-SFPro', 'lira-style-main', 'lira-style-header', 'lira-style-hero', 'lira-style-problems', 'lira-style-howwork', 'lira-style-slider-section', 'lira-style-videos'],
      'priority' => 15,
      'media' => 'all',
      'in_footer' => true
    ],
    [
      'handle' => 'lira-style-myservices',
      'src' => '/css/myservices.css',
      'deps' => ['lira-style', 'lira-style-font-SFPro', 'lira-style-main', 'lira-style-header', 'lira-style-hero', 'lira-style-problems', 'lira-style-howwork', 'lira-style-slider-section', 'lira-style-videos', 'lira-style-faq'],
      'priority' => 16,
      'media' => 'all',
      'in_footer' => true
    ],
    [
      'handle' => 'lira-style-reviews',
      'src' => '/css/reviews.css',
      'deps' => ['lira-style', 'lira-style-font-SFPro', 'lira-style-main', 'lira-style-header', 'lira-style-hero', 'lira-style-problems', 'lira-style-howwork', 'lira-style-slider-section', 'lira-style-videos', 'lira-style-faq', 'lira-style-myservices'],
      'priority' => 17,
      'media' => 'all',
      'in_footer' => true
    ],
    [
      'handle' => 'lira-style-cf7',
      'src' => '/css/temp/cf7.css',
      'deps' => ['lira-style', 'lira-style-font-SFPro', 'lira-style-main', 'lira-style-header', 'lira-style-hero', 'lira-style-problems', 'lira-style-howwork', 'lira-style-slider-section', 'lira-style-videos', 'lira-style-faq', 'lira-style-myservices', 'lira-style-reviews'],
      'priority' => 18,
      'media' => 'all',
      'in_footer' => true
    ],
    [
      'handle' => 'lira-style-contactform',
      'src' => '/css/contactform.css',
      'deps' => ['lira-style', 'lira-style-font-SFPro', 'lira-style-main', 'lira-style-header', 'lira-style-hero', 'lira-style-problems', 'lira-style-howwork', 'lira-style-slider-section', 'lira-style-videos', 'lira-style-faq', 'lira-style-myservices', 'lira-style-reviews', 'lira-style-cf7'],
      'priority' => 19,
      'media' => 'all',
      'in_footer' => true
    ],
    [
      'handle' => 'lira-style-footer',
      'src' => '/css/footer.css',
      'deps' => ['lira-style', 'lira-style-font-SFPro', 'lira-style-main', 'lira-style-header', 'lira-style-hero', 'lira-style-problems', 'lira-style-howwork', 'lira-style-slider-section', 'lira-style-videos', 'lira-style-faq', 'lira-style-myservices', 'lira-style-reviews', 'lira-style-cf7', 'lira-style-contactform'],
      'priority' => 20,
      'media' => 'all',
      'in_footer' => true
    ],
    [
      'handle' => 'lira-swiper-css',
      'src' => '/js/lib/swiper/swiper-bundle.min.css',
      'deps' => [],
      'priority' => 20,
      'media' => 'all',
      'in_footer' => true
    ],
    [
      'handle' => 'lira-fancybox-css',
      'src' => '/js/lib/fancybox/fancybox.css',
      'deps' => [],
      'priority' => 21,
      'media' => 'all',
      'in_footer' => true
    ]
  ];

  $scripts = [
    [
      'handle' => 'lira-jquery',
      'src' => '/js/jquery.min.js',
      'deps' => [],
      'priority' => 10,
      'in_footer' => true
    ],
    [
      'handle' => 'lira-swiper-js',
      'src' => '/js/lib/swiper/swiper-bundle.min.js',
      'deps' => ['lira-jquery'],
      'priority' => 20,
      'in_footer' => true
    ],
    [
      'handle' => 'lira-fancybox-js',
      'src' => '/js/lib/fancybox/fancybox.umd.js',
      'deps' => ['lira-jquery', 'lira-swiper-js'],
      'priority' => 30,
      'in_footer' => true
    ],
    [
      'handle' => 'lira-script',
      'src' => '/js/script.js',
      'deps' => ['lira-jquery', 'lira-swiper-js', 'lira-fancybox-js'],
      'priority' => 40,
      'in_footer' => true
    ]
  ];

  // Подключение CSS файлов
  foreach ($styles as $style) {
    // Проверяем условие, если оно задано
    if (isset($style['condition']) && is_callable($style['condition']) && !$style['condition']()) {
      continue; // Пропускаем, если условие не выполнено
    }

    $file_path = get_template_directory() . $style['src'];
    if (file_exists($file_path)) {
      wp_enqueue_style(
        $style['handle'],
        get_template_directory_uri() . $style['src'],
        $style['deps'],
        filemtime($file_path),
        isset($style['media']) ? $style['media'] : 'all'
      );

      if (isset($style['in_footer']) && $style['in_footer']) {
        add_filter('style_loader_tag', function ($tag, $handle) use ($style) {
          if ($handle === $style['handle']) {
            add_action('wp_footer', function () use ($tag) {
              echo $tag;
            }, $style['priority']);
            return '';
          }
          return $tag;
        }, 10, 2);
      }
    }
  }

  // Подключение JS файлов
  foreach ($scripts as $script) {
    $file_path = get_template_directory() . $script['src'];
    if (file_exists($file_path)) {
      wp_enqueue_script(
        $script['handle'],
        get_template_directory_uri() . $script['src'],
        $script['deps'],
        filemtime($file_path),
        $script['in_footer']
      );
    }
  }
}
add_action('wp_enqueue_scripts', 'enqueue_theme_assets', 1);
