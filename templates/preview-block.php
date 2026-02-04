<?php
// Получаем данные демо-карточки
// Они могут быть установлены из шорткода (для индексированных вызовов)
// или прямые из Carbon Fields (для обратной совместимости)

$demo_data = isset($GLOBALS['gp_demo_card_data']) ? $GLOBALS['gp_demo_card_data'] : null;
$unique_id = isset($GLOBALS['gp_shortcode_unique_id']) ? $GLOBALS['gp_shortcode_unique_id'] : 'gp-preview-default';

if ($demo_data !== null) {
    // Используем данные из шорткода (new complex или legacy)
    $blur_img        = $demo_data['blur_img'] ?? '';
    $btn_to_go       = $demo_data['btn_to_go'] ?? '';
    $btn_iframe      = $demo_data['btn_iframe'] ?? '';
    $btn_back_to     = $demo_data['btn_back_to'] ?? '';
    $btn_to_go_link  = $demo_data['btn_to_go_link'] ?? '';
    $btn_iframe_link = $demo_data['btn_iframe_link'] ?? '';
    $height_for      = $demo_data['height_for'] ?? '';
    $btn_color_1     = $demo_data['btn_color_1'] ?? '';
    $btn_color_2     = $demo_data['btn_color_2'] ?? '';
    $btn_color_3     = $demo_data['btn_color_3'] ?? '';
    $btn_color_4     = $demo_data['btn_color_4'] ?? '';
    $color_font_1    = $demo_data['color_font_1'] ?? '';
    $color_font_2    = $demo_data['color_font_2'] ?? '';
} else {
    // ОБРАТНАЯ СОВМЕСТИМОСТЬ: используем старые поля напрямую
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
}
?>


<div class="saintsmedia-wrapper" style="height:<?php echo $height_for; ?>px;">

    <!-- превью -->
    <main id="<?php echo esc_attr($unique_id . '-preview'); ?>" <?php if (!empty($blur_img)) { echo saintsmedia_responsive_bg($blur_img, 'saintsmedia-preview'); } else { echo 'class="saintsmedia-preview"'; } ?> style="height:100%;">
        <div class="saintsmedia-buttons">
            <a id="<?php echo esc_attr($unique_id . '-btn-play'); ?>" class="saintsmedia-btn saintsmedia-play"
                style="background:linear-gradient(135deg, <?php echo $btn_color_1; ?> 0%, <?php echo $btn_color_2; ?> 100%); color:<?php echo $color_font_1; ?>;"
                href="<?php echo $btn_to_go_link; ?>" rel="nofollow noopener noreferrer" target="_blank">
                <?php echo $btn_to_go ?: 'JUGAR EN AL CASINO'; ?>
            </a>

            <button id="<?php echo esc_attr($unique_id . '-btn-demo'); ?>" class="saintsmedia-btn saintsmedia-demo"
                style="background:linear-gradient(135deg, <?php echo $btn_color_3; ?> 0%, <?php echo $btn_color_4; ?> 100%); color:<?php echo $color_font_2; ?>;"
                type="button">
                <?php echo $btn_iframe ?: 'DEMO'; ?>
            </button>
        </div>
    </main>

    <!-- демо -->
    <div id="<?php echo esc_attr($unique_id . '-demo-container'); ?>" class="saintsmedia-demo-container saintsmedia-hidden" style="height:100%;">
        <button id="<?php echo esc_attr($unique_id . '-btn-back'); ?>" class="saintsmedia-btn-back" type="button">
            <?php echo $btn_back_to ?: '← Volver'; ?>
        </button>
        <iframe style="height:100%;width:100%;background:#000;border:0;" id="<?php echo esc_attr($unique_id . '-iframe'); ?>" class="saintsmedia-iframe"
            src="<?php echo esc_url($btn_iframe_link); ?>" allowfullscreen loading="lazy"></iframe>
    </div>

</div>

<script>
    (() => {
        const uniqueId = '<?php echo esc_js($unique_id); ?>';
        const preview = document.getElementById(uniqueId + '-preview');
        const demoContainer = document.getElementById(uniqueId + '-demo-container');
        const btnDemo = document.getElementById(uniqueId + '-btn-demo');
        const btnBack = document.getElementById(uniqueId + '-btn-back');

        if (preview && demoContainer && btnDemo && btnBack) {
            btnDemo.addEventListener('click', () => {
                preview.classList.add('saintsmedia-hidden');
                demoContainer.classList.remove('saintsmedia-hidden');
                // demoContainer.style.boxShadow = '0 0.2rem 0.5rem rgb(0 0 0 / 50%)';
            });

            btnBack.addEventListener('click', () => {
                demoContainer.classList.add('saintsmedia-hidden');
                preview.classList.remove('saintsmedia-hidden');
            });
        }
    })();
</script>
