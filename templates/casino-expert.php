<?php
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

?>


<div class="saintsmedia-wrapper">
    <section itemscope itemprop="author" itemtype="https://schema.org/Person" class="saintsmedia-author-block"
        style="background-color:<?php echo esc_attr($spec_exp_bg); ?>;">
        <meta itemprop="name" content="<?php echo esc_attr($spec_exp_author_name); ?>">
        <meta itemprop="follows" content="<?php echo esc_html($spec_exp_author_info); ?>">
        <div class="saintsmedia-author-header">
            <!-- photo as adaptive background -->
            <div <?php echo $photo_attr; ?>></div>

            <div>
                <div class="saintsmedia-proven-specialist">
                    <i class="fa-solid fa-circle-check" style="color:<?php echo esc_attr($spec_exp_bg_circle); ?>;"></i>
                    <a href="#" class="saintsmedia-author-name">
                        <h2>
                            <?php echo esc_html($spec_exp_h2_title); ?>
                        </h2>
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
                <?php if ($spec_exp_author_twitter) : ?>
                    <a target="_blank" href="<?php echo esc_url($spec_exp_author_twitter); ?>">
                        <img src="<?php echo esc_url(plugin_dir_url(__DIR__) . 'fontawesome/6/svgs/all-svg/x-twitter.svg'); ?>" alt="x-twitter">
                    </a>
                <?php endif; ?>

                <?php if ($spec_exp_author_linkedin) : ?>
                    <a target="_blank" href="<?php echo esc_url($spec_exp_author_linkedin); ?>">
                        <img src="<?php echo esc_url(plugin_dir_url(__DIR__) . 'fontawesome/6/svgs/all-svg/linkedin.svg'); ?>" alt="linkedin">
                    </a>
                <?php endif; ?>

                <?php if ($spec_exp_author_facebook) : ?>
                    <a target="_blank" href="<?php echo esc_url($spec_exp_author_facebook); ?>">
                        <img src="<?php echo esc_url(plugin_dir_url(__DIR__) . 'fontawesome/6/svgs/all-svg/facebook.svg'); ?>" alt="facebook">
                    </a>
                <?php endif; ?>

                <?php if ($spec_exp_author_instagram) : ?>
                    <a target="_blank" href="<?php echo esc_url($spec_exp_author_instagram); ?>">
                        <img src="<?php echo esc_url(plugin_dir_url(__DIR__) . 'fontawesome/6/svgs/all-svg/instagram.svg'); ?>" alt="instagram">
                    </a>
                <?php endif; ?>

                <?php if ($spec_exp_author_youtube) : ?>
                    <a target="_blank" href="<?php echo esc_url($spec_exp_author_youtube); ?>">
                        <img src="<?php echo esc_url(plugin_dir_url(__DIR__) . 'fontawesome/6/svgs/all-svg/youtube.svg'); ?>" alt="youtube">
                    </a>
                <?php endif; ?>

                <?php if ($spec_exp_author_telegram) : ?>
                    <a target="_blank" href="<?php echo esc_url($spec_exp_author_telegram); ?>">
                        <img src="<?php echo esc_url(plugin_dir_url(__DIR__) . 'fontawesome/6/svgs/all-svg/telegram.svg'); ?>" alt="telegram">
                    </a>
                <?php endif; ?>


            </div>
        </div>
    </section>
</div>
