class MobileMenu {
    constructor(options = {}) {
        this.settings = Object.assign({
            navSelector: 'nav#mobile-navigation',
            toggleSelector: '.menu-toggle',
            itemSelector: '.menu-item',
            hasChildrenClass: 'menu-item-has-children',
            backSelector: '.mobile-navigation__back',
            closeSelector: '.mobile-navigation__close',
            controlsSelector: '.mobile-navigation__controls',
            subMenuSelector: '.sub-menu',
            openedClass: 'opened',
            fixedClass: 'fixed'
        }, options);

        this.$nav = jQuery(this.settings.navSelector);
        this.levelsMenu = new Set();
        this.levelsMenuArr = [];

        this.init();
    }

    init() {
        const $ = jQuery;

        // Открыть меню
        $(this.settings.toggleSelector).on('click', (e) => {
            e.stopPropagation();


            this.$nav.addClass(this.settings.openedClass);
            $('html').addClass(this.settings.fixedClass);

            $(this.settings.toggleSelector).toggleClass(this.settings.openedClass);


            $(`.${this.settings.openedClass}`).not(this.$nav).removeClass(this.settings.openedClass);

            // сброс подменю
            this.$nav.find(this.settings.subMenuSelector).removeClass(this.settings.openedClass);
        });

        // Клик по пункту меню
        $(this.settings.itemSelector).on('click', (e) => {
            e.stopPropagation();
            let $target = $(e.currentTarget);

            if ($target.hasClass(this.settings.hasChildrenClass)) {
                $target.children(this.settings.subMenuSelector).addClass(this.settings.openedClass);

                let title = $target.find('> a').text();
                this.levelsMenu.add(title);
                this.levelsMenuArr = Array.from(this.levelsMenu);

                $(this.settings.controlsSelector).css('display', 'block');
                $(this.settings.backSelector).text(title);
            }
        });

        // Кнопка назад
        $(this.settings.backSelector).on('click', () => {
            let $opened = this.$nav.find(`${this.settings.subMenuSelector}.${this.settings.openedClass}:last`);

            if ($opened.length) {
                $opened.removeClass(this.settings.openedClass);

                this.levelsMenu.delete(this.levelsMenuArr[this.levelsMenuArr.length - 1]);
                this.levelsMenuArr.pop();

                $(this.settings.backSelector).text(this.levelsMenuArr[this.levelsMenuArr.length - 1] || '');
                $(this.settings.controlsSelector).css('display', this.levelsMenuArr.length ? 'block' : 'none');
            } else {
                $(this.settings.controlsSelector).css('display', 'none');
                this.$nav.removeClass(this.settings.openedClass);

                this.levelsMenu.clear();
                this.levelsMenuArr = [];
            }
        });

        // Кнопка закрытия
        $(this.settings.closeSelector).on('click', () => {
            if (this.$nav.hasClass(this.settings.openedClass)) {
                $('html').removeClass(this.settings.fixedClass);
                this.$nav.removeClass(this.settings.openedClass);

                this.levelsMenu.clear();
                this.levelsMenuArr = [];

                $(this.settings.backSelector).text('');
                $(this.settings.controlsSelector).css('display', 'none');
                this.$nav.find(this.settings.subMenuSelector).removeClass(this.settings.openedClass);
            }
        });
    }
}