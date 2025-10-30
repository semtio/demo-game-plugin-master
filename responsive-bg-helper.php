<?php

/**
 * SaintsMedia Responsive Background Helper  ·  v1.2
 * -------------------------------------------
 * Озвученные доработки:
 * • CSS никогда не выводится прямо в атрибуте (исключена «рвущаяся» разметка).
 * • Если <head> уже прошёл, хелпер складирует стили и печатает их через wp_footer.
 */

if (! function_exists('saintsmedia_responsive_bg')) {
    /**
     * @param string|int $img       URL изображения или attachment ID
     * @param string     $extra_cls Доп. классы
     * @return string HTML‑атрибут class="sm-bg‑xxxx extra"
     */
    function saintsmedia_responsive_bg($img, $extra_cls = '')
    {
        if (empty($img)) {
            return '';
        }

        /** @var array<string,string> $styles Собираем CSS по классам */
        static $styles = [];
        /** @var bool $hooked Глобальные хуки подключены? */
        static $hooked = false;

        // 1. Attachment ID
        $img_id = is_numeric($img) ? (int) $img : attachment_url_to_postid($img);

        // 2. Размеры
        if ($img_id) {
            $img_small  = wp_get_attachment_image_url($img_id, 'thumbnail') ?: '';
            $img_medium = wp_get_attachment_image_url($img_id, 'medium') ?: $img_small;
            $img_large  = wp_get_attachment_image_url($img_id, 'medium_large') ?: $img_medium;
            $img_full   = wp_get_attachment_image_url($img_id, 'full') ?: $img_large;
        } else {
            $img_small = $img_medium = $img_large = $img_full = esc_url($img);
        }

        if (! $img_full) {
            return '';
        }

        // 3. Класс‑хэш
        $class = 'sm-bg-' . substr(md5($img_full), 0, 8);

        // 4. Формируем CSS только раз на класс
        if (! isset($styles[$class])) {
            $css  = ".{$class}{background-image:url('{$img_full}');background-size:cover;background-position:center;background-repeat:no-repeat;}";
            $css .= "@media(max-width:1200px){.{$class}{background-image:url('{$img_large}');}}";
            $css .= "@media(max-width:768px){.{$class}{background-image:url('{$img_medium}');}}";
            $css .= "@media(max-width:300px){.{$class}{background-image:url('{$img_small}');}}";
            $styles[$class] = $css;
        }

        // 5. Подключаем хуки для вывода CSS (один раз)
        if (! $hooked && ! is_admin() && ! wp_doing_ajax()) {
            // Если wp_head ещё не отработал → печатаем в <head>
            if (! did_action('wp_head')) {
                add_action('wp_head', function () use (&$styles) {
                    if ($styles) {
                        echo "\n<style id=\"saintsmedia-responsive-bg\">\n" . implode("\n", $styles) . "\n</style>\n";
                    }
                }, 100);
            } else { // иначе печатаем в футере
                add_action('wp_footer', function () use (&$styles) {
                    if ($styles) {
                        echo "\n<style id=\"saintsmedia-responsive-bg\">\n" . implode("\n", $styles) . "\n</style>\n";
                    }
                }, 5);
            }
            $hooked = true;
        }

        // 6. HTML‑атрибут
        $extra_cls = trim($extra_cls);
        $all_cls   = $class . ($extra_cls ? ' ' . $extra_cls : '');

        return 'class="' . esc_attr($all_cls) . '"';
    }
}
