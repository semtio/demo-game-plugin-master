<?php
// --------------------------------------------------
//  Настройки блока «Специалист проверен»
// --------------------------------------------------
$spec_exp_bg               = carbon_get_theme_option('spec_exp_bg');
$spec_exp_main_color_text  = carbon_get_theme_option('spec_exp_main_color_text');
$spec_exp_color_name       = carbon_get_theme_option('spec_exp_color_name');
$spec_exp_bg_circle        = carbon_get_theme_option('spec_exp_bg_circle');
$spec_exp_author_photo     = carbon_get_theme_option('spec_exp_author_photo'); // URL или ID
$spec_exp_h2_title         = carbon_get_theme_option('spec_exp_h2_title');
$spec_exp_author_name      = carbon_get_theme_option('spec_exp_author_name');
$spec_exp_author_info      = carbon_get_theme_option('spec_exp_author_info');
$spec_exp_author_twitter   = carbon_get_theme_option('spec_exp_author_twitter');
$spec_exp_author_linkedin  = carbon_get_theme_option('spec_exp_author_linkedin');
$spec_exp_author_facebook  = carbon_get_theme_option('spec_exp_author_facebook');
$spec_exp_author_instagram = carbon_get_theme_option('spec_exp_author_instagram');
$spec_exp_author_youtube   = carbon_get_theme_option('spec_exp_author_youtube');
$spec_exp_author_telegram  = carbon_get_theme_option('spec_exp_author_telegram');

// --------------------------------------------------
//  Подготовка фото автора через saintsmedia_responsive_bg()
//  Максимум medium (300 px), базовый класс saintsmedia-author-photo
// --------------------------------------------------
$photo_attr = saintsmedia_responsive_bg($spec_exp_author_photo, 'saintsmedia-author-photo', 'medium');

// --------------------------------------------------
//  Готовим JSON-LD со связкой author(Person)
// --------------------------------------------------
// Получаем URL изображения (если передан ID вложения)
$author_image_url = '';
if (!empty($spec_exp_author_photo)) {
    if (is_numeric($spec_exp_author_photo)) {
        $img = wp_get_attachment_image_url((int) $spec_exp_author_photo, 'medium');
        if ($img) { $author_image_url = $img; }
    } else {
        $author_image_url = esc_url_raw($spec_exp_author_photo);
    }
}

// Собираем массив ссылок sameAs, фильтруем пустые
$same_as_candidates = [
    $spec_exp_author_twitter,
    $spec_exp_author_linkedin,
    $spec_exp_author_facebook,
    $spec_exp_author_instagram,
    $spec_exp_author_youtube,
    $spec_exp_author_telegram,
];
$same_as = array_values(array_filter(array_map('esc_url_raw', array_filter($same_as_candidates))));

// Автор как Person
$author_person = [
    '@type' => 'Person',
];
if (!empty($spec_exp_author_name)) { $author_person['name'] = wp_strip_all_tags($spec_exp_author_name); }
if (!empty($spec_exp_author_info)) { $author_person['description'] = wp_strip_all_tags($spec_exp_author_info); }
if (!empty($author_image_url))     { $author_person['image'] = $author_image_url; }
if (!empty($same_as))              { $author_person['sameAs'] = $same_as; }

// Страница как WebPage с автором Person
$schema = [
    '@context' => 'https://schema.org',
    '@type'    => 'WebPage',
    'author'   => $author_person,
];

// По возможности добавим идентификатор страницы и заголовок блока
if (function_exists('get_permalink')) {
    $schema['@id'] = esc_url_raw(get_permalink());
}
if (!empty($spec_exp_h2_title)) {
    $schema['headline'] = wp_strip_all_tags($spec_exp_h2_title);
}
?>

<div class="saintsmedia-wrapper">
    <section class="saintsmedia-author-block" style="background-color:<?php echo esc_attr($spec_exp_bg); ?>;">
        <div class="saintsmedia-author-header">
            <!-- photo as adaptive background -->
            <div <?php echo $photo_attr; ?> aria-label="Author photo"></div>

            <div>
                <div class="saintsmedia-proven-specialist">
                    <i class="fa-solid fa-circle-check" style="color:<?php echo esc_attr($spec_exp_bg_circle); ?>;"></i>
                    <a href="#" class="saintsmedia-author-name" aria-label="<?php echo esc_attr($spec_exp_author_name . ' profile'); ?>">
                        <h2><?php echo esc_html($spec_exp_h2_title); ?></h2>
                    </a>
                </div>
                <div class="saintsmedia-author-role" style="color:<?php echo esc_attr($spec_exp_color_name); ?>;">
                    <?php echo esc_html($spec_exp_author_name); ?>
                </div>
            </div>
        </div>

        <div class="saintsmedia-author-info">
            <p class="saintsmedia-author-description" style="color:<?php echo esc_attr($spec_exp_main_color_text); ?>;">
                <?php echo esc_html($spec_exp_author_info); ?>
            </p>
            <div class="saintsmedia-author-contact">
                <?php echo $spec_exp_author_twitter   ? '<a href="' . esc_url($spec_exp_author_twitter)   . '"><i class="fa-brands fa-x-twitter"></i></a>' : ''; ?>
                <?php echo $spec_exp_author_linkedin  ? '<a href="' . esc_url($spec_exp_author_linkedin)  . '"><i class="fa-brands fa-linkedin-in"></i></a>' : ''; ?>
                <?php echo !empty($spec_exp_author_facebook)  ? '<a href="' . esc_url($spec_exp_author_facebook)  . '"><i class="fa-brands fa-facebook-f"></i></a>' : ''; ?>
                <?php echo !empty($spec_exp_author_instagram) ? '<a href="' . esc_url($spec_exp_author_instagram) . '"><i class="fa-brands fa-instagram"></i></a>' : ''; ?>
                <?php echo !empty($spec_exp_author_youtube)   ? '<a href="' . esc_url($spec_exp_author_youtube)   . '"><i class="fa-brands fa-youtube"></i></a>' : ''; ?>
                <?php echo !empty($spec_exp_author_telegram)  ? '<a href="' . esc_url($spec_exp_author_telegram)  . '"><i class="fa-brands fa-telegram"></i></a>' : ''; ?>
            </div>
        </div>

        <?php // Выводим JSON-LD только если есть минимальные данные об авторе ?>
        <?php if (!empty($author_person['name'])): ?>
            <script type="application/ld+json">
                <?php echo wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>
            </script>
        <?php endif; ?>
    </section>
</div>
