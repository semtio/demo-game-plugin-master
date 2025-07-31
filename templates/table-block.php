<?php
$table_bkg_color = carbon_get_theme_option('table_bkg_color');
$table_text_color = carbon_get_theme_option('table_text_color');
$table_btn_color = carbon_get_theme_option('table_btn_color');
$table_bonus_bg_color = carbon_get_theme_option('table_bonus_bg_color');
$table_btn_gradient_1 = carbon_get_theme_option('table_btn_gradient_1');
$table_btn_gradient_2 = carbon_get_theme_option('table_btn_gradient_2');
?>

<?php
$complex_table = carbon_get_theme_option('complex_table');
foreach ($complex_table as $i) { ?>

    <div class="casino-container">
        <div style="background-color:<?php echo $table_bkg_color; ?>;" class="casino-card">
            <div class="counter-rating-casino">5</div>
            <!-- Casino Card 1 -->
            <div style="background-image: url('<?php echo $i['logo_table']; ?>');" class="affiliate-casino-logo"></div>
            <div style="color: <?php echo $table_text_color; ?>;" class="casino-info">
                <h2><?php echo $i['text_title']; ?></h2>
                <div style="width: 50%; display: flex; justify-content: space-between;" class="casino-rating">
                    <div>
                        <span style="font-size: 2.5rem;" class="star">★</span>
                        <span style="font-size: 2.5rem;" class="star">★</span>
                        <span style="font-size: 2.5rem;" class="star">★</span>
                        <span style="font-size: 2.5rem;" class="star">★</span>
                        <span style="font-size: 2.5rem;" class="star">★</span>
                        <!-- <span style="font-size: 2.5rem;" class="star">☆</span> -->
                    </div>

                    <span>3.6</span>

                </div>
                <ul class="casino-notes">
                    <li><?php echo $i['info_1']; ?></li>
                    <li><?php echo $i['info_2']; ?></li>
                    <li><?php echo $i['info_3']; ?></li>
                </ul>
            </div>

            <div class="casino-side">
                <div style="background-color:<?php echo $table_bonus_bg_color; ?>;" class="bonus">
                    <span class="bonus-amount"><?php echo $i['bonus_1']; ?></span>
                    <?php echo $i['bonus_2']; ?>
                </div>
                <a href="<?php echo $i['go_to_btn_link']; ?>"> <button style="background: linear-gradient(135deg,<?php echo $table_btn_gradient_1; ?>,<?php echo $table_btn_gradient_2; ?>);" class="play-btn" type="button"><?php echo $i['go_to_btn']; ?> </button>
                </a>
            </div>
        </div>
    </div>

<?php } ?>