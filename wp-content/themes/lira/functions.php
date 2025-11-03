<?
require_once(get_template_directory() . '/inc/enqueue.php');
require_once(get_template_directory() . '/inc/custom-post-types.php');
require_once(get_template_directory() . '/inc/shortcodes/init.php');
require_once(get_template_directory() . '/inc/components/breadcrumbs.php');
require_once(get_template_directory() . '/inc/post-views.php');

function lira_add_custom_body_classes($classes)
{
  // Проверяем, является ли текущая страница одиночной записью типа 'service'
  if (is_singular('service')) {
    $classes[] = 'wp-singular';
    $classes[] = 'serives-template-default';
    $classes[] = 'single';
    $classes[] = 'single-serives';
    $classes[] = 'topbaractive';
    error_log('TOPBARACTIVE ADDED - is_singular(service) = true');
  }
  if (is_singular('blog')) {
    $classes[] = 'single';
    $classes[] = 'single-post';
  }
  if (is_post_type_archive('blog') || is_tax()) {
    $classes[] = 'blog';
  }

  if (is_404()) {
    $classes[] = 'error404';
  }
  // Проверяем, является ли это страница поиска
  if (is_search()) {
    $classes[] = 'search';
    $classes[] = 'search-results';
  }

  // Отладка: логируем, чтобы проверить, вызывается ли фильтр
  error_log('Current URL: ' . $_SERVER['REQUEST_URI']);
  error_log('is_singular(service): ' . (is_singular('service') ? 'YES' : 'NO'));
  error_log('is_front_page: ' . (is_front_page() ? 'YES' : 'NO'));
  error_log('Body classes: ' . print_r($classes, true));
  return $classes;
}
add_filter('body_class', 'lira_add_custom_body_classes', 20);

// Enable support for Post Thumbnails
add_theme_support('post-thumbnails');

/**
 * Extend search to include custom post types
 */
function lira_extend_search($query)
{
  if ($query->is_search && !is_admin()) {
    $query->set('post_type', array('blog', 'service'));
  }
  return $query;
}
add_filter('pre_get_posts', 'lira_extend_search');

add_filter('wpcf7_form_elements', function ($content) {
  return str_replace('<p>', '', str_replace('</p>', '', $content));
});

function hide_default_posts_menu()
{
  remove_menu_page('edit.php');
}
add_action('admin_menu', 'hide_default_posts_menu');

add_action('wpcf7_before_send_mail', 'cf7_generate_contact_links', 10, 1);
function cf7_generate_contact_links($contact_form)
{
  $submission = WPCF7_Submission::get_instance();

  if ($submission) {
    $posted_data = $submission->get_posted_data();

    $phone = isset($posted_data['phone']) ? $posted_data['phone'] : '';
    $channel = isset($posted_data['channel']) ? $posted_data['channel'] : '';

    // Если channel массив, берём первый элемент
    if (is_array($channel)) {
      $channel = reset($channel);
    }

    // Очищаем телефон от всех символов кроме цифр
    $clean_phone = preg_replace('/[^0-9]/', '', $phone);

    $links = '';

    if (!empty($clean_phone) && !empty($channel)) {
      // Формируем ссылку в зависимости от выбранного канала
      if (stripos($channel, 'Whatsapp') !== false || stripos($channel, 'WhatsApp') !== false) {
        // WhatsApp всегда без плюса
        $whatsapp = 'https://wa.me/' . $clean_phone;
        $links = '<a href="' . $whatsapp . '">Написать в WhatsApp</a>';
      } elseif (stripos($channel, 'Telegram') !== false) {
        // Telegram всегда с плюсом
        $telegram = 'https://t.me/+' . $clean_phone;
        $links = '<a href="' . $telegram . '">Написать в Telegram</a>';
      } elseif (stripos($channel, 'Телефон') !== false || stripos($channel, 'Telefon') !== false) {
        $links = '<a href="tel:+' . $clean_phone . '">Позвонить: ' . $phone . '</a>';
      }
    }

    // Получаем настройки почты
    $mail = $contact_form->prop('mail');

    // Заменяем [contact-links] на готовые ссылки
    if (isset($mail['body'])) {
      $mail['body'] = str_replace('[contact-links]', $links, $mail['body']);
      $contact_form->set_properties(array('mail' => $mail));
    }

    // Также для mail_2 если используется
    $mail_2 = $contact_form->prop('mail_2');
    if ($mail_2['active'] && isset($mail_2['body'])) {
      $mail_2['body'] = str_replace('[contact-links]', $links, $mail_2['body']);
      $contact_form->set_properties(array('mail_2' => $mail_2));
    }
  }
}

register_nav_menus(
  array(
    'menu-1' => esc_html__('Primary', 'lira'),
    'footer-menu-base' => esc_html__('Footer Main', 'lira'),
    'footer-menu-advanced' => esc_html__('Footer Advanced', 'lira'),
    'footer-menu-bottom' => esc_html__('Footer Bottom', 'lira'),
    'advanced-menu' => esc_html__('Advanced Menu', 'lira'),
    'social-menu' => esc_html__('Social Menu', 'lira'),
  )
);
