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

// --------------------------------------------------
//  Подготовка фото автора через saintsmedia_responsive_bg()
//  Максимум medium (300 px), базовый класс saintsmedia-author-photo
// --------------------------------------------------
$photo_attr = saintsmedia_responsive_bg($spec_exp_author_photo, 'saintsmedia-author-photo', 'medium');
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
            <!-- <div class="saintsmedia-author-contact">
                <a href="mailto:hannah@example.com" aria-label="Email Hannah"><i class="fa-solid fa-envelope"></i></a>
            </div> -->
        </div>
    </section>
</div>