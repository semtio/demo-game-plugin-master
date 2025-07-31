<?php
$casino_table_bg_col = carbon_get_theme_option('casino_table_bg_col');
$casino_table_outline = carbon_get_theme_option('casino_table_outline');
?>

<?php
$complex_table = carbon_get_theme_option('complex_table');
foreach ($complex_table as $i) {
?>

    <div class="saintsmedia-casino-table">
        <!-- card -->
        <div style="background-color:<?php echo $casino_table_bg_col; ?>;"
            class="saintsmedia-casino-card saintsmedia-casino-card--primary">

            <!-- logo -->
            <a href="<?php echo $i['table_link_to_casino']; ?>" target=" _blank" rel="nofollow noopener noreferrer">
                <div class=" saintsmedia-logo" style="background-image: url('<?php echo $i['casino_table_logo']; ?>');"
                    aria-label="Vicibet logo">
                    <div style="background-color:<?php echo $casino_table_outline; ?>;" class="saintsmedia-order-number"></div>
                </div>
            </a>

            <!-- casino name -->
            <div class="saintsmedia-casino-name">
                <?php echo $i['casino_name']; ?>
            </div>

            <!-- info -->
            <div class="saintsmedia-info">
                <div class="saintsmedia-info-tag">
                    <?php echo $i['table_info_tag']; ?>
                </div>
                <div class="saintsmedia-info-descr">
                    <?php echo $i['table_info_descr']; ?>
                </div>
            </div>

            <!-- rating -->
            <div class="saintsmedia-rating" aria-label="Rating 5 out of 5">
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <span>5.0</span>
            </div>

            <!-- CTA -->
            <div class="saintsmedia-cta">
                <a href="<?php echo $i['table_link_to_casino']; ?>" target="_blank" rel="nofollow noopener noreferrer">
                    <?php echo $i['table_cta_btn']; ?> <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

<?php } ?>


<script>
    // нумерация карточек
    let orderNumbers = document.querySelectorAll('.saintsmedia-order-number');
    for (let i = 0; i < orderNumbers.length; i++) {
        orderNumbers[i].innerHTML = i + 1;
    }
    // конец - нумерация карточек

    // --------------------------
    let totalTables = document.querySelectorAll('.saintsmedia-casino-card--primary');
    totalTables[0].style.outline = '3.8px solid <?php echo $casino_table_outline; ?>';
</script>