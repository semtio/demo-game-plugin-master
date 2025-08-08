<?php
$blur_img        = carbon_get_theme_option('blur_img');
$btn_to_go       = carbon_get_theme_option('btn_to_go');
$btn_iframe      = carbon_get_theme_option('btn_iframe');
$btn_back_to     = carbon_get_theme_option('btn_back_to');
$btn_to_go_link  = carbon_get_theme_option('btn_to_go_link');
$btn_iframe_link = carbon_get_theme_option('btn_iframe_link');
$height_for      = carbon_get_theme_option('height_for');
$btn_color_1     = carbon_get_theme_option('btn_color_1');
$btn_color_2     = carbon_get_theme_option('btn_color_2');
$btn_color_3     = carbon_get_theme_option('btn_color_3');
$btn_color_4     = carbon_get_theme_option('btn_color_4');
$color_font_1    = carbon_get_theme_option('color_font_1');
$color_font_2    = carbon_get_theme_option('color_font_2');
?>


<div class="saintsmedia-wrapper" style="height:<?php echo $height_for; ?>px;">

    <!-- превью -->
    <main id="saintsmedia-preview" <?php echo saintsmedia_responsive_bg($blur_img); ?> style="height:100%;">
        <div class="saintsmedia-buttons">
            <a id="saintsmedia-btn-play" class="saintsmedia-btn saintsmedia-play"
                style="background:linear-gradient(135deg, <?php echo $btn_color_1; ?> 0%, <?php echo $btn_color_2; ?> 100%); color:<?php echo $color_font_1; ?>;"
                href="<?php echo $btn_to_go_link; ?>" rel="nofollow noopener noreferrer" target="_blank">
                <?php echo $btn_to_go ?: 'JUGAR EN AL CASINO'; ?>
            </a>

            <button id="saintsmedia-btn-demo" class="saintsmedia-btn saintsmedia-demo"
                style="background:linear-gradient(135deg, <?php echo $btn_color_3; ?> 0%, <?php echo $btn_color_4; ?> 100%); color:<?php echo $color_font_2; ?>;"
                type="button">
                <?php echo $btn_iframe ?: 'DEMO'; ?>
            </button>
        </div>
    </main>

    <!-- демо -->
    <div id="saintsmedia-demo-container" class="saintsmedia-hidden" style="height:100%;">
        <button id="saintsmedia-btn-back" type="button">
            <?php echo $btn_back_to ?: '← Volver'; ?>
        </button>
        <iframe style="height:100%;width:100%;background:#000;border:0;" id="saintsmedia-iframe"
            src="<?php echo esc_url($btn_iframe_link); ?>" allowfullscreen loading="lazy"></iframe>
    </div>

</div>

<script>
    (() => {
        const preview = document.getElementById('saintsmedia-preview');
        const demoContainer = document.getElementById('saintsmedia-demo-container');
        const btnDemo = document.getElementById('saintsmedia-btn-demo');
        const btnBack = document.getElementById('saintsmedia-btn-back');

        btnDemo.addEventListener('click', () => {
            preview.classList.add('saintsmedia-hidden');
            demoContainer.classList.remove('saintsmedia-hidden');
            // demoContainer.style.boxShadow = '0 0.2rem 0.5rem rgb(0 0 0 / 50%)';
        });

        btnBack.addEventListener('click', () => {
            demoContainer.classList.add('saintsmedia-hidden');
            preview.classList.remove('saintsmedia-hidden');
        });
    })();
</script>