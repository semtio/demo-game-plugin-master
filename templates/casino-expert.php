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
$spec_exp_author_linkedin   = carbon_get_theme_option('spec_exp_author_linkedin');
$spec_exp_author_facebook   = carbon_get_theme_option('spec_exp_author_facebook');
$spec_exp_author_instagram   = carbon_get_theme_option('spec_exp_author_instagram');
$spec_exp_author_youtube   = carbon_get_theme_option('spec_exp_author_youtube');
$spec_exp_author_telegram   = carbon_get_theme_option('spec_exp_author_telegram');

// --------------------------------------------------
//  Подготовка фото автора через saintsmedia_responsive_bg()
//  Максимум medium (300 px), базовый класс saintsmedia-author-photo
// --------------------------------------------------
$photo_attr = saintsmedia_responsive_bg($spec_exp_author_photo, 'saintsmedia-author-photo', 'medium');

// --------------------------------------------------
//  Данные для Schema.org
// --------------------------------------------------
$page_url       = function_exists('get_permalink') ? get_permalink() : home_url('/');
$site_name      = get_bloginfo('name');
// Логотип сайта (publisher.logo): custom_logo -> site icon -> пусто
$logo_url = '';
if (function_exists('get_theme_mod')) {
    $custom_logo_id = get_theme_mod('custom_logo');
    if ($custom_logo_id) {
        $logo_data = wp_get_attachment_image_src($custom_logo_id, 'full');
        if (!empty($logo_data[0])) {
            $logo_url = $logo_data[0];
        }
    }
}
if (!$logo_url && function_exists('get_site_icon_url')) {
    $icon = get_site_icon_url(512);
    if ($icon) {
        $logo_url = $icon;
    }
}

$date_published = function_exists('get_post_time') ? get_post_time('c', true) : '';
$date_modified  = function_exists('get_the_modified_time') ? get_the_modified_time('c', true) : '';

// Социальные ссылки автора для sameAs
$author_same_as = array_filter([
    $spec_exp_author_twitter,
    $spec_exp_author_linkedin,
    $spec_exp_author_facebook,
    $spec_exp_author_instagram,
    $spec_exp_author_youtube,
    $spec_exp_author_telegram,
], function ($v) { return !empty($v); });
?>

<div class="saintsmedia-wrapper">
    <section class="saintsmedia-author-block" style="background-color:<?php echo esc_attr($spec_exp_bg); ?>;" itemscope itemtype="https://schema.org/Article">
        <!-- Microdata meta for Article -->
        <?php if (!empty($spec_exp_author_photo)) : ?>
            <meta itemprop="image" content="<?php echo esc_url($spec_exp_author_photo); ?>" />
        <?php endif; ?>
        <?php if (!empty($date_published)) : ?>
            <meta itemprop="datePublished" content="<?php echo esc_attr($date_published); ?>" />
        <?php endif; ?>
        <?php if (!empty($date_modified)) : ?>
            <meta itemprop="dateModified" content="<?php echo esc_attr($date_modified); ?>" />
        <?php endif; ?>
        <div class="saintsmedia-author-header">
            <!-- photo as adaptive background -->
            <div <?php echo $photo_attr; ?> aria-label="Author photo"></div>

            <div>
                <div class="saintsmedia-proven-specialist">
                    <i class="fa-solid fa-circle-check" style="color:<?php echo esc_attr($spec_exp_bg_circle); ?>;"></i>
                    <a href="#" class="saintsmedia-author-name" aria-label="<?php echo esc_attr($spec_exp_author_name . ' profile'); ?>">
                        <h2 itemprop="headline"><?php echo esc_html($spec_exp_h2_title); ?></h2>
                    </a>
                </div>
                <div class="saintsmedia-author-role" style="color:<?php echo esc_attr($spec_exp_color_name); ?>;">
                    <span><?php echo esc_html($spec_exp_author_name); ?></span>
                </div>
            </div>
        </div>

        <div class="saintsmedia-author-info">
            <p class="saintsmedia-author-description" style="color:<?php echo esc_attr($spec_exp_main_color_text); ?>;" itemprop="description">
                <?php echo esc_html($spec_exp_author_info); ?>
            </p>
            <div class="saintsmedia-author-contact">
                <?php echo $spec_exp_author_twitter ? '<a href="' . esc_url($spec_exp_author_twitter) . '"><i class="fa-brands fa-x-twitter"></i></a>' : ''; ?>
                <?php echo $spec_exp_author_linkedin ? '<a href="' . esc_url($spec_exp_author_linkedin) . '"><i class="fa-brands fa-linkedin-in"></i></a>' : ''; ?>
                <?php echo !empty($spec_exp_author_facebook) ? '<a href="' . esc_url($spec_exp_author_facebook) . '"><i class="fa-brands fa-facebook-f"></i></a>' : ''; ?>
                <?php echo !empty($spec_exp_author_instagram) ? '<a href="' . esc_url($spec_exp_author_instagram) . '"><i class="fa-brands fa-instagram"></i></a>' : ''; ?>
                <?php echo !empty($spec_exp_author_youtube) ? '<a href="' . esc_url($spec_exp_author_youtube) . '"><i class="fa-brands fa-youtube"></i></a>' : ''; ?>
                <?php echo !empty($spec_exp_author_telegram) ? '<a href="' . esc_url($spec_exp_author_telegram) . '"><i class="fa-brands fa-telegram"></i></a>' : ''; ?>
            </div>
        </div>

        <!-- Hidden Person microdata (author) -->
        <div itemprop="author" itemscope itemtype="https://schema.org/Person">
            <?php if (!empty($spec_exp_author_name)) : ?>
                <meta itemprop="name" content="<?php echo esc_attr($spec_exp_author_name); ?>" />
            <?php endif; ?>
            <?php if (!empty($spec_exp_author_photo)) : ?>
                <meta itemprop="image" content="<?php echo esc_url($spec_exp_author_photo); ?>" />
            <?php endif; ?>
            <?php foreach ($author_same_as as $same_url) : ?>
                <link itemprop="sameAs" href="<?php echo esc_url($same_url); ?>" />
            <?php endforeach; ?>
        </div>
    </section>

    <?php
    // ---------------- JSON-LD Article with Person ----------------
    $json_ld = [
        '@context' => 'https://schema.org',
        '@type'    => 'Article',
        'headline' => (string) $spec_exp_h2_title,
        'description' => (string) $spec_exp_author_info,
        'mainEntityOfPage' => [
            '@type' => 'WebPage',
            '@id'   => esc_url($page_url),
        ],
        'image' => !empty($spec_exp_author_photo) ? [esc_url($spec_exp_author_photo)] : [],
        'author' => [
            '@type' => 'Person',
            'name'  => (string) $spec_exp_author_name,
            'image' => !empty($spec_exp_author_photo) ? esc_url($spec_exp_author_photo) : null,
            'sameAs'=> array_values(array_map('esc_url', $author_same_as)),
        ],
        'publisher' => [
            '@type' => 'Organization',
            'name'  => (string) $site_name,
            'logo'  => [
                '@type' => 'ImageObject',
                'url'   => (string) $logo_url,
            ],
        ],
    ];
    if (!empty($date_published)) { $json_ld['datePublished'] = $date_published; }
    if (!empty($date_modified))  { $json_ld['dateModified']  = $date_modified; }

    // Очистка пустых полей
    $json_ld['author'] = array_filter($json_ld['author']);
    if (empty($json_ld['image'])) { unset($json_ld['image']); }
    if (empty($logo_url)) { unset($json_ld['publisher']['logo']); }
    ?>
    <script type="application/ld+json">
        <?php echo wp_json_encode($json_ld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT); ?>
    </script>
</div>
