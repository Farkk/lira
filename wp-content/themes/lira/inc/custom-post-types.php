<?php

/**
 * Register Custom Post Types
 */

function lira_register_custom_post_types()
{
  // Register Custom Post Type
  $labels = array(
    'name'                  => _x('Услуги', 'Post Type General Name', 'lira'),
    'singular_name'         => _x('Услуга', 'Post Type Singular Name', 'lira'),
    'menu_name'             => __('Услуги', 'lira'),
    'name_admin_bar'        => __('Услуга', 'lira'),
    'archives'              => __('Архив услуг', 'lira'),
    'attributes'            => __('Атрибуты услуги', 'lira'),
    'parent_item_colon'     => __('Родительская услуга:', 'lira'),
    'all_items'             => __('Все услуги', 'lira'),
    'add_new_item'          => __('Добавить новую услугу', 'lira'),
    'add_new'               => __('Добавить новую', 'lira'),
    'new_item'              => __('Новая услуга', 'lira'),
    'edit_item'             => __('Редактировать услугу', 'lira'),
    'update_item'           => __('Обновить услугу', 'lira'),
    'view_item'             => __('Просмотр услуги', 'lira'),
    'view_items'            => __('Просмотр услуг', 'lira'),
    'search_items'          => __('Поиск услуги', 'lira'),
    'not_found'             => __('Не найдено', 'lira'),
    'not_found_in_trash'    => __('Не найдено в корзине', 'lira'),
    'featured_image'        => __('Изображение услуги', 'lira'),
    'set_featured_image'    => __('Установить изображение', 'lira'),
    'remove_featured_image' => __('Удалить изображение', 'lira'),
    'use_featured_image'    => __('Использовать как изображение', 'lira'),
    'insert_into_item'      => __('Вставить в услугу', 'lira'),
    'uploaded_to_this_item' => __('Загружено к этой услуге', 'lira'),
    'items_list'            => __('Список услуг', 'lira'),
    'items_list_navigation' => __('Навигация по списку услуг', 'lira'),
    'filter_items_list'     => __('Фильтр списка услуг', 'lira'),
  );

  $args = array(
    'label'                 => __('Услуга', 'lira'),
    'description'           => __('Услуги компании', 'lira'),
    'labels'                => $labels,
    'supports'              => array('title', 'editor', 'thumbnail', 'custom-fields'),
    'taxonomies'            => array('service_category'),
    'hierarchical'          => false,
    'public'                => true,
    'show_ui'               => true,
    'show_in_menu'          => true,
    'menu_position'         => 5,
    'menu_icon'             => 'dashicons-admin-tools',
    'show_in_admin_bar'     => true,
    'show_in_nav_menus'     => true,
    'can_export'            => true,
    'has_archive'           => true,
    'exclude_from_search'   => false,
    'publicly_queryable'    => true,
    'capability_type'       => 'post',
    'show_in_rest'          => false, // Enable Gutenberg editor
  );

  register_post_type('service', $args);

  // Register Custom Taxonomy
  $taxonomy_labels = array(
    'name'                       => _x('Категории услуг', 'Taxonomy General Name', 'lira'),
    'singular_name'              => _x('Категория услуг', 'Taxonomy Singular Name', 'lira'),
    'menu_name'                  => __('Категории', 'lira'),
    'all_items'                  => __('Все категории', 'lira'),
    'parent_item'                => __('Родительская категория', 'lira'),
    'parent_item_colon'          => __('Родительская категория:', 'lira'),
    'new_item_name'              => __('Название новой категории', 'lira'),
    'add_new_item'               => __('Добавить новую категорию', 'lira'),
    'edit_item'                  => __('Редактировать категорию', 'lira'),
    'update_item'                => __('Обновить категорию', 'lira'),
    'view_item'                  => __('Просмотр категории', 'lira'),
    'separate_items_with_commas' => __('Разделяйте категории запятыми', 'lira'),
    'add_or_remove_items'        => __('Добавить или удалить категории', 'lira'),
    'choose_from_most_used'      => __('Выбрать из наиболее используемых', 'lira'),
    'popular_items'              => __('Популярные категории', 'lira'),
    'search_items'               => __('Поиск категорий', 'lira'),
    'not_found'                  => __('Не найдено', 'lira'),
    'no_terms'                   => __('Нет категорий', 'lira'),
    'items_list'                 => __('Список категорий', 'lira'),
    'items_list_navigation'      => __('Навигация по списку категорий', 'lira'),
  );

  $taxonomy_args = array(
    'labels'                     => $taxonomy_labels,
    'hierarchical'               => true, // Like categories (false = like tags)
    'public'                     => true,
    'show_ui'                    => true,
    'show_admin_column'          => true,
    'show_in_nav_menus'          => true,
    'show_tagcloud'              => true,
    'show_in_rest'               => true, // Enable Gutenberg support
  );

  register_taxonomy('service_category', array('service'), $taxonomy_args);

  // Register Badges Taxonomy
  $badge_labels = array(
    'name'                       => _x('Бейджи', 'Taxonomy General Name', 'lira'),
    'singular_name'              => _x('Бейдж', 'Taxonomy Singular Name', 'lira'),
    'menu_name'                  => __('Бейджи', 'lira'),
    'all_items'                  => __('Все бейджи', 'lira'),
    'parent_item'                => null,
    'parent_item_colon'          => null,
    'new_item_name'              => __('Название нового бейджа', 'lira'),
    'add_new_item'               => __('Добавить новый бейдж', 'lira'),
    'edit_item'                  => __('Редактировать бейдж', 'lira'),
    'update_item'                => __('Обновить бейдж', 'lira'),
    'view_item'                  => __('Просмотр бейджа', 'lira'),
    'separate_items_with_commas' => __('Разделяйте бейджи запятыми', 'lira'),
    'add_or_remove_items'        => __('Добавить или удалить бейджи', 'lira'),
    'choose_from_most_used'      => __('Выбрать из наиболее используемых', 'lira'),
    'popular_items'              => __('Популярные бейджи', 'lira'),
    'search_items'               => __('Поиск бейджей', 'lira'),
    'not_found'                  => __('Не найдено', 'lira'),
    'no_terms'                   => __('Нет бейджей', 'lira'),
    'items_list'                 => __('Список бейджей', 'lira'),
    'items_list_navigation'      => __('Навигация по списку бейджей', 'lira'),
  );

  $badge_args = array(
    'labels'                     => $badge_labels,
    'hierarchical'               => false, // Like tags
    'public'                     => true,
    'show_ui'                    => true,
    'show_admin_column'          => true,
    'show_in_nav_menus'          => true,
    'show_tagcloud'              => true,
    'show_in_rest'               => true, // Enable Gutenberg support
    'meta_box_cb'                => 'post_tags_meta_box', // Use tags-style metabox
  );

  register_taxonomy('service_badge', array('service'), $badge_args);


  // Register Blog Post Type
  $blog_labels = array(
    'name'                  => _x('Блог', 'Post Type General Name', 'lira'),
    'singular_name'         => _x('Запись блога', 'Post Type Singular Name', 'lira'),
    'menu_name'             => __('Блог', 'lira'),
    'name_admin_bar'        => __('Запись блога', 'lira'),
    'archives'              => __('Архив блога', 'lira'),
    'attributes'            => __('Атрибуты записи', 'lira'),
    'parent_item_colon'     => __('Родительская запись:', 'lira'),
    'all_items'             => __('Все записи', 'lira'),
    'add_new_item'          => __('Добавить новую запись', 'lira'),
    'add_new'               => __('Добавить новую', 'lira'),
    'new_item'              => __('Новая запись', 'lira'),
    'edit_item'             => __('Редактировать запись', 'lira'),
    'update_item'           => __('Обновить запись', 'lira'),
    'view_item'             => __('Просмотр записи', 'lira'),
    'view_items'            => __('Просмотр записей', 'lira'),
    'search_items'          => __('Поиск записи', 'lira'),
    'not_found'             => __('Не найдено', 'lira'),
    'not_found_in_trash'    => __('Не найдено в корзине', 'lira'),
    'featured_image'        => __('Изображение записи', 'lira'),
    'set_featured_image'    => __('Установить изображение', 'lira'),
    'remove_featured_image' => __('Удалить изображение', 'lira'),
    'use_featured_image'    => __('Использовать как изображение', 'lira'),
    'insert_into_item'      => __('Вставить в запись', 'lira'),
    'uploaded_to_this_item' => __('Загружено к этой записи', 'lira'),
    'items_list'            => __('Список записей', 'lira'),
    'items_list_navigation' => __('Навигация по списку записей', 'lira'),
    'filter_items_list'     => __('Фильтр списка записей', 'lira'),
  );

  $blog_args = array(
    'label'                 => __('Запись блога', 'lira'),
    'description'           => __('Записи блога', 'lira'),
    'labels'                => $blog_labels,
    'supports'              => array('title', 'editor', 'thumbnail', 'author', 'comments', 'custom-fields'),
    'taxonomies'            => array('blog_category'),
    'hierarchical'          => false,
    'public'                => true,
    'show_ui'               => true,
    'show_in_menu'          => true,
    'menu_position'         => 7,
    'menu_icon'             => 'dashicons-admin-post',
    'show_in_admin_bar'     => true,
    'show_in_nav_menus'     => true,
    'can_export'            => true,
    'has_archive'           => true,
    'exclude_from_search'   => false,
    'publicly_queryable'    => true,
    'capability_type'       => 'post',
    'show_in_rest'          => false, // Enable Gutenberg editor
  );

  register_post_type('blog', $blog_args);

  // Register Blog Categories Taxonomy
  $blog_category_labels = array(
    'name'                       => _x('Рубрики', 'Taxonomy General Name', 'lira'),
    'singular_name'              => _x('Рубрика', 'Taxonomy Singular Name', 'lira'),
    'menu_name'                  => __('Рубрики', 'lira'),
    'all_items'                  => __('Все рубрики', 'lira'),
    'parent_item'                => __('Родительская рубрика', 'lira'),
    'parent_item_colon'          => __('Родительская рубрика:', 'lira'),
    'new_item_name'              => __('Название новой рубрики', 'lira'),
    'add_new_item'               => __('Добавить новую рубрику', 'lira'),
    'edit_item'                  => __('Редактировать рубрику', 'lira'),
    'update_item'                => __('Обновить рубрику', 'lira'),
    'view_item'                  => __('Просмотр рубрики', 'lira'),
    'separate_items_with_commas' => __('Разделяйте рубрики запятыми', 'lira'),
    'add_or_remove_items'        => __('Добавить или удалить рубрики', 'lira'),
    'choose_from_most_used'      => __('Выбрать из наиболее используемых', 'lira'),
    'popular_items'              => __('Популярные рубрики', 'lira'),
    'search_items'               => __('Поиск рубрик', 'lira'),
    'not_found'                  => __('Не найдено', 'lira'),
    'no_terms'                   => __('Нет рубрик', 'lira'),
    'items_list'                 => __('Список рубрик', 'lira'),
    'items_list_navigation'      => __('Навигация по списку рубрик', 'lira'),
  );

  $blog_category_args = array(
    'labels'                     => $blog_category_labels,
    'hierarchical'               => true,
    'public'                     => true,
    'show_ui'                    => true,
    'show_admin_column'          => true,
    'show_in_nav_menus'          => true,
    'show_tagcloud'              => true,
    'show_in_rest'               => true, // Enable Gutenberg support
  );

  register_taxonomy('blog_category', array('blog'), $blog_category_args);
}

add_action('init', 'lira_register_custom_post_types', 0);
