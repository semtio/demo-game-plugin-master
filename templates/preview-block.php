<?php
// preview-block.php
$blur_img = carbon_get_theme_option('blur_img');
$btn_to_go = carbon_get_theme_option('btn_to_go');
$btn_iframe = carbon_get_theme_option('btn_iframe');
$btn_back_to = carbon_get_theme_option('btn_back_to');
$btn_to_go_link = carbon_get_theme_option('btn_to_go_link');
$btn_iframe_link = carbon_get_theme_option('btn_iframe_link');
$height_for = carbon_get_theme_option('height_for');

// Цвета кнопок
$btn_color_1 = carbon_get_theme_option('btn_color_1');
$btn_color_2 = carbon_get_theme_option('btn_color_2');
$btn_color_3 = carbon_get_theme_option('btn_color_3');
$btn_color_4 = carbon_get_theme_option('btn_color_4');

// Цвета шрифта кнопок
$color_font_1 = carbon_get_theme_option('color_font_1');
$color_font_2 = carbon_get_theme_option('color_font_2');
?>

<main id="preview" style="height:<?php echo $height_for; ?>px; background-image: url('<?php echo $blur_img; ?>')">
    <div class="buttons">
        <a id="btn-play" class="btn play" style="background: linear-gradient(135deg, <?php echo $btn_color_1; ?> 0%, <?php echo $btn_color_2; ?> 100%); color:<?php echo $color_font_1 ?>;" href="<?php echo $btn_to_go_link ?>" rel="nofollow noopener noreferrer"
            target="_blank">
            <?php echo $btn_to_go ? $btn_to_go : 'JUGAR EN AL CASINO'; ?>
        </a>
        <button id="btn-demo" style="background: linear-gradient(135deg, <?php echo $btn_color_3; ?> 0%, <?php echo $btn_color_4; ?> 100%); color:<?php echo $color_font_2 ?>;" class="btn demo" type="button">
            <?php echo $btn_iframe ? $btn_iframe : 'DEMO'; ?>
        </button>
    </div>
</main>

<div id="demo-container" style="<?php echo $height_for; ?>px" hidden>
    <button id="btn-back" type="button">
        <?php echo $btn_back_to ? $btn_back_to : '← Volver'; ?>
    </button>
</div>

<script>
    (() => {
        'use strict';
        const DEMO_URL = "<?php echo $btn_iframe_link ?>";
        // const DEMO_URL = "<?php echo esc_url($btn_iframe_link); ?>";


        const preview = document.getElementById('preview');
        const demoContainer = document.getElementById('demo-container');
        const btnDemo = document.getElementById('btn-demo');
        const btnBack = document.getElementById('btn-back');

        let iframe = null; // iframe instance

        /** Открывает демо‑режим */
        function openDemo() {
            if (!iframe) {
                iframe = document.createElement('iframe');
                iframe.src = DEMO_URL;
                iframe.style.height = '<?php echo $height_for; ?>px';
                iframe.style.background = "#000000";
                iframe.allowFullscreen = true;
                iframe.loading = 'lazy';
                demoContainer.appendChild(iframe);
            }
            preview.setAttribute('hidden', ''); // прячем первое окно
            demoContainer.removeAttribute('hidden'); // показываем демо‑контейнер
        }

        /** Возвращает превью и выгружает iframe */
        function showPreview() {
            if (iframe) {
                iframe.remove(); // полностью убираем из DOM → прекращается загрузка/исполнение
                iframe = null;
            }
            demoContainer.setAttribute('hidden', '');
            preview.removeAttribute('hidden');
        }

        /* === EVENTS === */
        btnDemo.addEventListener('click', openDemo);
        btnBack.addEventListener('click', showPreview);
    })();
</script>