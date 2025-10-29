jQuery(document).ready(function ($) {

    // Кнопка открытия моб. меню
    $('.menu-toggle').on('click', function (e) {
        e.stopPropagation();

        let $navMobile = $('nav#menu-navigation');

        if ($navMobile.hasClass('opened')) {
            // Закрываем меню
            $navMobile.removeClass('opened');
            $('html').removeClass('fixed');
            $navMobile.find('.sub-menu').removeClass('opened');
        } else {
            // Открываем меню
            $navMobile.addClass('opened');
            $('html').addClass('fixed');

            $('.opened').not($navMobile).removeClass('opened');
            $navMobile.find('.sub-menu').removeClass('opened');
        }
    });


    // Закрытие всех меню при клике вне
    $(document).on('click', function (e) {
        let $target = $(e.target);
        if ($target.closest('.opened').length) {
            return;
        }
        $('html').removeClass('fixed');
        $('.opened').removeClass('opened');
    });


    // 
    let levelsMenu = new Set();
    let levelsMenuArr = [];
    let isActive = false;

    function initMenu() {
        if (isActive) return;

        // Пункты меню
        $(document).on('click.mobileMenu', '.menu-item', function (e) {
            e.stopPropagation();
            let $target = $(e.currentTarget);

            if ($target.hasClass('menu-item-has-children')) {
                $target.children('.sub-menu').addClass('opened');

                let title = $target.find('> a').text();
                levelsMenu.add(title);
                levelsMenuArr = Array.from(levelsMenu);

                $('.menu-navigation__controls').css('display', 'block');
                $('.menu-navigation__back').text(title);
            }
        });

        // Кнопка "назад"
        $(document).on('click.mobileMenu', '.menu-navigation__back', function () {
            let $menu = $('nav#menu-navigation');
            let $opened = $menu.find('.sub-menu.opened:last');

            if ($opened.length) {
                $opened.removeClass('opened');

                levelsMenu.delete(levelsMenuArr[levelsMenuArr.length - 1]);
                levelsMenuArr.pop();

                $('.menu-navigation__back').text(levelsMenuArr[levelsMenuArr.length - 1] || '');
                $('.menu-navigation__controls').css('display', levelsMenuArr.length ? 'block' : 'none');

            } else {
                $('.menu-navigation__controls').css('display', 'none');
                $menu.removeClass('opened');
                levelsMenu.clear();
                levelsMenuArr = [];
            }
        });

        // Кнопка закрытия
        // $(document).on('click.mobileMenu', '.menu-navigation__close', function () {
        //     let $navMobile = $('nav#menu-navigation');

        //     if ($navMobile.hasClass('opened')) {
        //         $('html').removeClass('fixed');
        //         $navMobile.removeClass('opened');

        //         levelsMenu.clear();
        //         levelsMenuArr = [];

        //         $('.menu-navigation__back').text('');
        //         $('.menu-navigation__controls').css('display', 'none');
        //         $navMobile.find('.sub-menu').removeClass('opened');
        //     }
        // });

        // Открыть моб. контакты
        $(document).on('click.mobileMenu', 'button.mobile-contact', function (e) {
            e.preventDefault();
            e.stopPropagation();

            $('html').removeClass('fixed');
            $('.opened').removeClass('opened');

            $('.contact-mobilemenu').addClass('opened');
            $('html').addClass('fixed');
        });

        // Закрыть моб. контакты
        // $(document).on('click.mobileMenu', '.contact-mobilemenu__close', function () {
        //     if ($('.contact-mobilemenu').hasClass('opened')) {
        //         $('.contact-mobilemenu').removeClass('opened');
        //         $('html').removeClass('fixed');
        //     }
        // });

        isActive = true;
    }

    // Отключение и выгрузка мобильного меню на десктопах или при переходе на десктоп
    function destroyMenu() {
        if (!isActive) return;
        $(document).off('.mobileMenu');
        $('html').removeClass('fixed');
        $('.opened').removeClass('opened');
        $('.menu-navigation__controls').css('display', 'none');
        $('.menu-navigation__back').text('');

        levelsMenu.clear();
        levelsMenuArr = [];

        isActive = false;
    }

    function checkWidth() {
        if ($(window).width() < 1240) {
            initMenu();
        } else {
            destroyMenu();
        }
    }
    checkWidth();
    $(window).on('resize', function () {
        checkWidth();
    });


    // Табы
    jQuery(document).ready(function () {
        jQuery(".tabs").each(function () {
            let $tabs = jQuery(this);

            $tabs.find(".tabs-nav li").click(function () {
                let tabId = jQuery(this).attr("data-tab");

                $tabs.find(".tabs-nav li").removeClass("active");
                $tabs.find(".tab-item").removeClass("active");

                jQuery(this).addClass("active");
                $tabs.find("#" + tabId).addClass("active");
            });
        });
    });


    // FANCYBOX 
    Fancybox.bind('.fancybox', {
        // type: "inline",
        dragToClose: false,
        closeButton: 'inside',
    });
    Fancybox.bind('[data-fancybox]', {
        type: "image",
    });



    // Спойлеры в футере в мобильном меню
    $('footer.site-footer li.menu-item-has-children').each(function () {
        let $spoiler = $(this);
        let $spoilerA = $spoiler.find('a').first();

        $spoilerA.on('click', function (e) {
            e.preventDefault();

            if ($spoiler.hasClass('active')) {
                $spoiler.removeClass('active sub-opened');
                $spoiler.find('ul.sub-menu').first().slideUp(300);
            } else {
                $('footer.site-footer li.menu-item-has-children.active').each(function () {
                    $(this).removeClass('active sub-opened')
                        .find('ul.sub-menu').first().slideUp(300);
                });

                $spoiler.addClass('active sub-opened');
                $spoiler.find('ul.sub-menu').first().slideDown(300);
            }
        });
    });

    // Для текстов "Развернуть полностью" / "Свернуть"
    $('.collapsible').each(function () {
        let $content = $(this);
        let $contentHide = $(this).find('.collapsible-hide');
        let $btn = $('<button class="collapse-toggle">Развернуть полностью</button>');
        let $imgs = $content.find('img');

        function initCollapse() {
            if ($(window).width() >= 1240) {
                $contentHide.show();
                $imgs.show();
                $btn.remove();
            } else {
                if (!$btn.parent().length) {
                    $contentHide.hide();
                    $contentHide.after($btn);
                    $imgs.hide();
                }
            }
        }

        initCollapse();

        $btn.on('click', function () {
            $contentHide.slideToggle(300);
            $content.toggleClass('expanded');
            $imgs.toggle();
            $(this).text(
                $(this).text() === 'Развернуть полностью' ?
                'Свернуть' :
                'Развернуть полностью'
            );
        });

        $(window).on('resize', initCollapse);
    });


    // подкскзки (?)
    let $tooltip;

    function showTooltip($el) {
        const text = $el.data('text');

        if (!$tooltip) {
            $tooltip = $('<div class="tooltip-box"><div class="tooltip-box__inner"></div></div>');
            $('body').append($tooltip);
        }

        $tooltip.find('.tooltip-box__inner').text(text);
        $tooltip.show().css({
            top: 0,
            left: 0,
            visibility: 'hidden'
        });

        requestAnimationFrame(() => {
            const rect = $el[0].getBoundingClientRect();
            const tooltipRect = $tooltip[0].getBoundingClientRect();
            const headerHeight = $('header.site-header').outerHeight() || 0;

            let top = rect.top - tooltipRect.height - 8 - headerHeight; // сначала сверху
            let left = $el.offset().left;

            // Проверка верхней границы
            if (top < 8) {
                top = rect.bottom + 8 - headerHeight; // показываем снизу
            }

            // Проверка нижней границы
            if (top + tooltipRect.height > window.innerHeight - 8) {
                top = rect.top - tooltipRect.height - 8 - headerHeight; // обратно сверху
            }

            // Проверка левой границы
            if (left < 8) left = 8;

            // Проверка правой границы
            if (left + tooltipRect.width > window.innerWidth - 8) {
                left = window.innerWidth - tooltipRect.width - 8;
            }

            $tooltip.css({
                top: top + window.scrollY,
                left: left + window.scrollX,
                visibility: 'visible'
            });
        });
    }

    function hideTooltip() {
        if ($tooltip) {
            $tooltip.fadeOut(150, function () {
                $(this).remove();
            });
            $tooltip = null;
        }
    }


    function bindEvents() {
        const winWidth = $(window).width();

        $('.help-link').off('.tooltipNS');

        if (winWidth < 1240) {
            $('.help-link').on('click.tooltipNS', function (e) {
                e.preventDefault();
                const text = $(this).data('text');
                Fancybox.show([{
                    html: "<div class='tooltip-modal'><div class='tooltip-modal__inner'>" + text + "</div></div>",
                    id: 'tooltip-modal',
                }, ]);
            });
        } else {
            // Десктопный сценарий
            $('.help-link')
                .on('mouseenter.tooltipNS', function () {
                    showTooltip($(this));
                })
                .on('mouseleave.tooltipNS', function () {
                    hideTooltip();
                });
        }
    }

    bindEvents();
    $(window).on('resize', function () {
        bindEvents();
    });


    // Аккордионы
    $('.accordions').each(function () {
        const $accordionBox = $(this);
        const $accordions = $accordionBox.find('.accordion');

        $accordions.each(function () {
            const $accordion = $(this);
            const $title = $accordion.find('.accordion-title');
            const $content = $accordion.find('.accordion-content');

            if (!$accordion.hasClass('active')) {
                $content.hide();
            }

            $title.on('click', function (e) {
                e.preventDefault();

                if ($accordion.hasClass('active')) {
                    $accordion.removeClass('active');
                    $content.slideUp(300);
                } else {
                    $accordionBox.find('.accordion.active').removeClass('active')
                        .find('.accordion-content').slideUp(300);

                    $accordion.addClass('active');
                    $content.slideDown(300);
                }
            });
        });
    });






});