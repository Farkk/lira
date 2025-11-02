<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= the_title() ?></title>
  <? wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <?
  $logo_id = get_field('logo', 'option');
  $logo_mobile_id = get_field('logo_mobile', 'option');

  $logo_full = wp_get_attachment_image_url($logo_id, 'full');
  $logo_mobile = $logo_mobile_id ? wp_get_attachment_image_url($logo_mobile_id, 'full') : $logo_full;

  $logo_text = get_field('logo_text', 'option');
  $phone = get_field('phone', 'option');
  $wa = get_field('link_wa', 'option');
  $tg = get_field('link_tg', 'option');
  $mobile_text = get_field('mobile_text', 'option');
  $time_work = get_field('time_work', 'option');

  $times = explode(' - ', $time_work);
  $start_time = trim($times[0]);
  $end_time = trim($times[1]);

  $banner_text = get_field('banner_text', 'option');
  $banner_link = get_field('banner_link', 'option');

  $show_topbanner = true;
  if (!empty($_COOKIE['topbannerClosed']) && $_COOKIE['topbannerClosed'] === 'true') {
    $show_topbanner = false;
  }
  ?>
  <header id="masthead" class="site-header">
    <? if ($show_topbanner): ?>
      <div class="topbanner">
        <div class="topbanner-wrapper">
          <p>
            <?= $banner_text ?>
          </p>
          <a href="<?= $banner_link ?>" class="button-white">Подробнее</a>
          <button type="button" class="topbanner-close">
            <span class="icon-close-2"></span>
          </button>
        </div>
      </div>
    <? endif; ?>

    <div class="site-header__top">
      <div class="site-header__top-left">
        <div class="site-branding">
          <a href="/" class="custom-logo-link" rel="home" aria-current="page">
            <img src="<?= $logo_full ?>"
              srcset="<?= $logo_mobile ?> 160w, <?= $logo_full ?> 320w"
              sizes="(max-width: 1024px) 160px, 320px"
              class="custom-logo"
              alt="Lira"
              decoding="async"
              fetchpriority="high"
              width="320"
              height="auto">
          </a>
        </div>
        <div class="site-description">
          <p><?= $logo_text ?></p>
        </div>

        <div class="site-contact">
          <a href="tel:<?= $phone ?>" class="numberphone-link"><?= $phone ?></a>
          <span class="working-hours">
            <time datetime="<?= $start_time ?>"><?= $start_time ?></time>–<time datetime="<?= $end_time ?>"><?= $end_time ?></time>
          </span>
        </div>
      </div>

      <div class="site-header__top-right">
        <?php
        wp_nav_menu([
          'theme_location' => 'advanced-menu',
          'container' => 'nav',
          'container_class' => 'advanced-menu',
          'items_wrap' => '<ul>%3$s</ul>',
          'fallback_cb' => false
        ]);
        ?>

        <nav class="scl-menu">
          <ul>
            <li><a href="<?= $wa ?>" target="_blank">What's App <span class="icon-whatsapp"></span></a></li>
            <li><a href="<?= $tg ?>" target="_blank">Telegram <span class="icon-telegram"></span></a></li>
          </ul>
        </nav>
      </div>

    </div>
    <div class="site-header__bottom">
      <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
        <svg width="21" height="16" viewBox="0 0 21 16" fill="none">
          <path fill="#9e759b"
            d="M 20.254,15.1472 H 0.745985 C 0.33386,15.1472 0,14.8134 0,14.4012 0,13.9891 0.33386,13.6552 0.745985,13.6552 H 20.254 c 0.4121,0 0.746,0.3339 0.746,0.746 0,0.4122 -0.3341,0.746 -0.746,0.746 z m 0,-6.99146 H 0.745985 C 0.33386,8.15574 0,7.82188 0,7.40976 0,6.99763 0.33386,6.66377 0.745985,6.66377 H 20.254 c 0.4121,0 0.746,0.33386 0.746,0.74599 0,0.41212 -0.3341,0.74598 -0.746,0.74598 z m 0,-6.66377 H 0.745985 C 0.33386,1.49197 0,1.15811 0,0.745985 0,0.33386 0.33386,0 0.745985,0 H 20.254 C 20.6661,0 21,0.33386 21,0.745985 21,1.15811 20.6659,1.49197 20.254,1.49197 Z" />
        </svg>
      </button>

      <div class="site-branding">
        <a href="/" class="custom-logo-link" rel="home" aria-current="page">
          <picture>
            <source media="(max-width: 768px)" srcset="<?= $logo_mobile ?>">
            <img src="<?= $logo_full ?>"
              class="custom-logo"
              alt="Lira"
              decoding="async"
              fetchpriority="high">
          </picture>
        </a>
      </div>

      <nav id="menu-navigation" class="menu-navigation">
        <div class="menu-navigation__controls">
          <div class="menu-navigation__controls-wrap">
            <button type="button" class="menu-navigation__back">Назад</button>
          </div>
        </div>
        <?php
        wp_nav_menu([
          'theme_location' => 'menu-1',
          'container' => false,
          'menu_id' => 'primary-menu',
          'menu_class' => 'menu nav-menu',
          'fallback_cb' => false,
          'link_before' => '<span class="menu-text">',
          'link_after' => '</span>'
        ]);
        ?>
        <div class="menu-navigation__foot">
          <a href="#callback" class="button-primary btn-small fancybox">
            <span class="icon-linkarrow"></span>
            Онлайн-помощь
          </a>

          <form role="search" method="get" class="search-form" action="<?= esc_url(home_url('/')); ?>">
            <label>
              <span class="screen-reader-text">Поиск по сайту</span>
              <input type="search" class="search-field" placeholder="Поиск по сайту" value="" name="s" />
            </label>
            <button type="submit" class="search-submit">Поиск по сайту</button>
          </form>
        </div>
      </nav>

      <button type="button" class="mobile-contact">
        <span class="icon icon-phone"></span>
      </button>
    </div>
  </header>

  <!-- баннер -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const body = document.body;
      const topbanner = document.querySelector('.topbanner');
      const closeBtn = document.querySelector('.topbanner-close');

      if (!topbanner) return;

      function getCookie(name) {
        const value = "; " + document.cookie;
        const parts = value.split("; " + name + "=");
        if (parts.length === 2) return parts.pop().split(";").shift();
      }

      if (getCookie('topbannerClosed') === 'true') {
        topbanner.style.setProperty('display', 'none', 'important');
        body.classList.remove('topbaractive');
        return;
      }

      body.classList.add('topbaractive');
      topbanner.style.setProperty('display', 'block', 'important');

      if (closeBtn) {
        closeBtn.addEventListener('click', function(e) {
          e.preventDefault();
          topbanner.style.setProperty('display', 'none', 'important');
          body.classList.remove('topbaractive');

          const expires = new Date();
          expires.setFullYear(expires.getFullYear() + 1);
          document.cookie = "topbannerClosed=true; path=/; expires=" + expires.toUTCString();
        });
      }
    });
  </script>

  <!-- mobile contact menu -->
  <div class="contact-mobilemenu">
    <div class="contact-mobilemenu__inner">
      <div class="site-desc"><?= $logo_text ?></div>

      <a href="tel:<?= $phone ?>" class="numberphone-link"><?= $phone ?></a>
      <span class="working-hours">
        <time datetime="<?= $start_time ?>"><?= $start_time ?></time>–<time datetime="<?= $end_time ?>"><?= $end_time ?></time>
      </span>

      <div class="contact-mobilemenu__links">
        <a href="<?= $wa ?>" class="social-btn social-wpp" target="_blank">
          <span class="icon-whatsapp"></span>
          Ватсап
        </a>
        <a href="<?= $tg ?>" class="social-btn social-tg" target="_blank">
          <span class="icon-telegram"></span>
          Телеграм
        </a>
      </div>

      <p class="contact-mobilemenu__information"><?= $mobile_text ?></p>
    </div>
  </div>
