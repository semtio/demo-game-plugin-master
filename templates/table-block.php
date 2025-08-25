<?php
// --------------------------------------------------
//  Глобальные цвета из настроек темы
// --------------------------------------------------
$casino_table_text_1 = carbon_get_theme_option('casino_table_text_1');
$casino_table_col_btn_1 = carbon_get_theme_option('casino_table_col_btn_1');
$casino_table_col_btn_2 = carbon_get_theme_option('casino_table_col_btn_2');

$casino_table_bg_col     = carbon_get_theme_option('casino_table_bg_col');
$casino_table_outline    = carbon_get_theme_option('casino_table_outline');
$casino_table_text_color = carbon_get_theme_option('casino_table_text_color');
// --------------------------------------------------
//  Комплексное поле с карточками казино
// --------------------------------------------------
$complex_table = carbon_get_theme_option('complex_table');

if (! empty($complex_table)) :
    foreach ($complex_table as $i) :
        //--------------------------------------------------------------------
        // 1. Готовим логотип через saintsmedia_responsive_bg()
        //    В $i['casino_table_logo'] сейчас может быть URL или ID.
        //--------------------------------------------------------------------
        $logo_attr = saintsmedia_responsive_bg($i['casino_table_logo'], 'saintsmedia-logo', 'medium_large');
?>
        <div class="saintsmedia-wrapper">
            <div class="saintsmedia-casino-table">

                <!-- card -->
                <div class="saintsmedia-casino-card saintsmedia-casino-card--primary"
                    style="background-color:<?php echo esc_attr($casino_table_bg_col); ?>; color:<?php echo $casino_table_text_1; ?>;">

                    <!-- logo -->
                    <a href="<?php echo esc_url($i['table_link_to_casino']); ?>" target="_blank" rel="nofollow noopener noreferrer">
                        <div <?php echo $logo_attr; ?> >
                            <div class="saintsmedia-order-number"
                                style="background-color:<?php echo esc_attr($casino_table_outline); ?>; color:<?php echo esc_attr($casino_table_text_color); ?>;"></div>
                        </div>
                    </a>

                    <!-- casino name -->
                    <div class="saintsmedia-casino-name">
                        <?php echo esc_html($i['casino_name']); ?>
                    </div>

                    <!-- info -->
                    <div class="saintsmedia-info">
                        <div class="saintsmedia-info-tag">
                            <?php echo esc_html($i['table_info_tag']); ?>
                        </div>
                        <div class="saintsmedia-info-descr">
                            <?php echo esc_html($i['table_info_descr']); ?>
                        </div>
                    </div>

                    <!-- rating -->
                    <div class="saintsmedia-rating">
                        <span class="what-is-rating"><?php echo esc_html($i['table_rating_casino']); ?></span>
                    </div>

                    <!-- CTA -->
                    <div class="saintsmedia-cta">
                        <a style="background: linear-gradient(90deg, <?php echo $casino_table_col_btn_1; ?> 0%, <?php echo $casino_table_col_btn_2; ?> 100%);" href="<?php echo esc_url($i['table_link_to_casino']); ?>" target="_blank" rel="nofollow noopener noreferrer">
                            <?php echo esc_html($i['table_cta_btn']); ?> <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div><!-- /.saintsmedia-casino-card -->
            </div><!-- /.saintsmedia-casino-table -->
        </div><!-- /.saintsmedia-wrapper -->

<?php
    endforeach;
endif;
?>

<script>
    // == Нумерация карточек ==
    const orderNumbers = document.querySelectorAll('.saintsmedia-order-number');
    orderNumbers.forEach((el, idx) => el.textContent = idx + 1);

    // == Обводка первой карточки ==
    const firstCard = document.querySelector('.saintsmedia-casino-card--primary');
    if (firstCard) {
        firstCard.style.outline = '3.8px solid <?php echo esc_js($casino_table_outline); ?>';
    }

    // == Рейтинг и звёзды ==
    const ratings = document.querySelectorAll('.what-is-rating');
    ratings.forEach((node) => {
        const value = parseFloat(node.textContent);
        const full = Math.floor(value);
        const half = value % 1 >= 0.5;
        const wrap = node.parentElement;
        node.remove();
        for (let i = 0; i < 5; i++) {
            const star = document.createElement('i');
            if (i < full) star.className = 'fa-solid fa-star';
            else if (i === full && half) star.className = 'fa-solid fa-star-half-stroke';
            else star.className = 'fa-regular fa-star';
            wrap.appendChild(star);
        }
        const span = document.createElement('span');
        span.textContent = value.toFixed(1);
        span.style.marginLeft = '6px';
        wrap.appendChild(span);
    });
</script>
