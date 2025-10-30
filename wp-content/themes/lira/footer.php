<?
$logo_id = get_field('logo', 'option');
$logo_mobile_id = get_field('logo_mobile', 'option');

$logo_full = wp_get_attachment_image_url($logo_id, 'full');
$logo_mobile = $logo_mobile_id ? wp_get_attachment_image_url($logo_mobile_id, 'full') : $logo_full;

$logo_text_footer = get_field('logo_text_footer', 'option');

$phone = get_field('phone', 'option');
$time_work = get_field('time_work', 'option');

$times = explode(' - ', $time_work);
$start_time = trim($times[0]);
$end_time = trim($times[1]);
?>
<footer id="colophon" class="site-footer">
  <div class="site-footer__container">
    <div class="site-footer__top">
      <div class="site-footer__top-left">
        <div class="site-footer__info">
          <a href="#" class="site-footer__logo">
            <img src="<?= $logo_full ?>"
              srcset="<?= $logo_mobile ?> 160w, <?= $logo_full ?> 320w"
              sizes="(max-width: 1024px) 160px, 320px"
              alt="Lira"
              width="320"
              height="auto">
          </a>
          <p class="site-footer__desc"><?= $logo_text_footer ?></p>
          <a href="tel:<?= $phone ?>" class="f-tel"><?= $phone ?></a>
          <span class="site-footer__schedule">
            <time datetime="<?= $start_time ?>"><?= $start_time ?></time>–<time datetime="<?= $end_time ?>"><?= $end_time ?></time>
          </span>
          <?php
          wp_nav_menu([
            'theme_location' => 'social-menu',
            'container' => false,
            'items_wrap' => '<ul id="menu-scl-menu" class="site-footer__menu-social">%3$s</ul>',
            'fallback_cb' => false
          ]);
          ?>

          <a href="#callback" class="button-primary btn-small fancybox">
            <span class="icon-linkarrow"></span>
            Онлайн-помощь
          </a>
        </div>
        <?php
        wp_nav_menu([
          'theme_location' => 'footer-menu-base',
          'container' => false,
          'items_wrap' => '<ul id="menu-footer-main" class="site-footer__menu">%3$s</ul>',
          'fallback_cb' => false
        ]);
        ?>
      </div>

      <?php
      wp_nav_menu([
        'theme_location' => 'footer-menu-advanced',
        'container' => false,
        'items_wrap' => '<ul id="menu-footer-advanced" class="site-footer__menu-advanced">%3$s</ul>',
        'fallback_cb' => false
      ]);
      ?>
    </div>

    <div class="site-footer__bottom">
      <div class="site-footer__bottom-left">
        <a href="www.lira777.com" class="site-footer__url">www.lira777.com</a>
        <span class="site-footer__copyright">© 2020—2025 Все права защищены</span>
      </div>

      <div class="site-footer__bottom-middle">
        <ul id="menu-footer-bottom" class="site-footer__menu-bottom">
          <li class="menu-item menu-item-type-custom menu-item-object-custom">
            <a href="/policy">Политика конфиденциальности</a>
          </li>
          <li class="menu-item menu-item-type-custom menu-item-object-custom">
            <a href="#">Правила оказания услуг</a>
          </li>
        </ul>

        <div class="site-footer__info">
          <a href="www.lira777.com" class="site-footer__url">www.lira777.com</a>
          <span class="site-footer__copyright">© 2020—2025 Все права защищены</span>
        </div>

        <div class="pay-methods">
          <img src="<?= get_template_directory_uri() ?>/img/yoomoney.webp" alt="yoomoney" width="auto" height="auto">
          <img src="<?= get_template_directory_uri() ?>/img/mir.webp" alt="mir" width="auto" height="auto">
          <img src="<?= get_template_directory_uri() ?>/img/visa.webp" alt="visa" width="auto" height="auto">
          <img src="<?= get_template_directory_uri() ?>/img/mastercard.webp" alt="mastercard" width="auto" height="auto">
          <img src="<?= get_template_directory_uri() ?>/img/paypal.webp" alt="paypal" width="auto" height="auto">
        </div>
      </div>

      <div class="site-footer__bottom-right">
        <a href="#" target="_blank" class="created-by-link">Сделано в <u>Moytop</u></a>
      </div>
    </div>
  </div>
</footer>

<div class="hidden">
  <div class="modal" id="callback">
    <div class="modal-inner">
      <?= do_shortcode('[contact-form-7 id="f7880aa" title="Заявка на консультацию модалка"]') ?>
    </div>
  </div>
</div>
<?php wp_footer(); ?>
<script>
  document.addEventListener('wpcf7mailsent', function(event) {
    location = 'https://lira.asmart-test-dev.ru/sucess/'; // URL страницы благодарности
  }, false);
  document.querySelectorAll('.slider-box').forEach(function(sliderBox) {
    let swiperEl = sliderBox.querySelector('.swiper');

    new Swiper(swiperEl, {
      slidesPerView: 'auto',
      spaceBetween: 12,
      loop: false,
      pagination: {
        el: sliderBox.querySelector('.swiper-pagination'),
        clickable: true,
      },
      navigation: {
        nextEl: sliderBox.querySelector('.swiper-button-next'),
        prevEl: sliderBox.querySelector('.swiper-button-prev'),
      },
    });
  });

  // MYSERVICES SLIDER
  new Swiper('.myservices-slider', {
    slidesPerView: 'auto',
    spaceBetween: 10,
    loop: false,
    pagination: {
      el: '.myservices-slider .swiper-pagination',
      clickable: false,
    },
    breakpoints: {
      1240: {
        enabled: false,
      }
    }
  });

  // REVIEWS SLIDER
  new Swiper('.reviews-slider', {
    slidesPerView: 'auto',
    spaceBetween: 32,
    loop: false,
    breakpoints: {
      1240: {
        scrollbar: false,
      }
    },
    pagination: {
      el: '.reviews-slider .swiper-pagination',
      clickable: false,
    },
    navigation: {
      nextEl: '.reviews-slider .slider-navigation .swiper-button-next',
      prevEl: '.reviews-slider .slider-navigation .swiper-button-prev',
    },
    scrollbar: {
      el: '.reviews-slider .swiper-scrollbar',
      draggable: true,
    },

  });
</script>

</body>

</html>
