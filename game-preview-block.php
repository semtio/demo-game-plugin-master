<?php
/*
Plugin Name: Game-Game-Game
Plugin URI: https://yourwebsite.com/
Description: 3in1
Version: 1.2
Author: 7on
*/


// 1) подключаем helper СРАЗУ
require_once plugin_dir_path(__FILE__) . 'responsive-bg-helper.php';


// Инициализация Carbon Fields
add_action('after_setup_theme', function () {
    \Carbon_Fields\Carbon_Fields::boot();
});
require_once plugin_dir_path(__FILE__) . 'carbon/main.php';

// Подключение стилей и скриптов
add_action('wp_enqueue_scripts', 'gp_enqueue_assets');
function gp_enqueue_assets()
{
    // Подключаем только на одиночных страницах (например, пост или страница)
    if (!is_singular()) return;

    // Font Awesome
    wp_enqueue_style(
        'my-local-font-awesome',
        plugins_url('/fontawesome/6/css/all.min.css', __FILE__),
        [],
        filemtime(plugin_dir_path(__FILE__) . 'fontawesome/6/css/all.min.css')
    );

    // Основной стиль плагина
    wp_enqueue_style(
        'gp-style',
        plugins_url('/assets/style.css', __FILE__),
        [],
        filemtime(plugin_dir_path(__FILE__) . 'assets/style.css')
    );

    // Стили таблицы
    wp_enqueue_style(
        'gp-table-block',
        plugins_url('/assets/table-block.css', __FILE__),
        [],
        null // Можно раскомментировать filemtime, если нужно автоматическое обновление версий
    );

    // Стили блока "эксперт"
    wp_enqueue_style(
        'gp-casino-expert',
        plugins_url('/assets/casino-expert.css', __FILE__),
        [],
        null // Можно раскомментировать filemtime
    );

    // reset css
    wp_enqueue_style(
        'gp-my-reset-css',
        plugins_url('/assets/reset.css', __FILE__),
        [],
        null // Можно раскомментировать filemtime
    );

    // accordion.css
    wp_enqueue_style(
        'gp-my-accordion-css',
        plugins_url('/assets/accordion.css', __FILE__),
        [],
        null // Можно раскомментировать filemtime
    );

    // slots-showcase.css
    wp_enqueue_style(
        'gp-slots-showcase-css',
        plugins_url('/assets/slots-showcase.css', __FILE__),
        [],
        null // Можно раскомментировать filemtime
    );

    // Скрипт приложения
    wp_enqueue_script(
        'gp-script',
        plugins_url('/assets/app.js', __FILE__),
        [],
        filemtime(plugin_dir_path(__FILE__) . 'assets/app.js'),
        true
    );
}

// ================= ВСПОМОГАТЕЛЬНЫЕ ФУНКЦИИ ДЛЯ ДЕМО =================

/**
 * Получить демо-карточку по индексу (0-based)
 * С поддержкой обратной совместимости
 *
 * @param int $index индекс карточки (0, 1, 2, ...)
 * @return array|null данные карточки или null если не найдена
 */
function gp_get_demo_card($index = 0) {
    // Получаем complex field с новыми демо-карточками
    $demo_cards = carbon_get_theme_option('demo_cards');

    // Если complex не пуст — используем его
    if (!empty($demo_cards) && is_array($demo_cards)) {
        $items = array_values($demo_cards);
        if (isset($items[$index])) {
            return $items[$index];
        }
        // Если запрошенный индекс не существует — возвращаем null
        return null;
    }

    // ОБРАТНАЯ СОВМЕСТИМОСТЬ: если complex пуст и запрашиваем первую карточку
    // — возвращаем старые одиночные поля
    if ($index === 0) {
        return [
            'btn_color_1'       => carbon_get_theme_option('btn_color_1'),
            'btn_color_2'       => carbon_get_theme_option('btn_color_2'),
            'color_font_1'      => carbon_get_theme_option('color_font_1'),
            'btn_color_3'       => carbon_get_theme_option('btn_color_3'),
            'btn_color_4'       => carbon_get_theme_option('btn_color_4'),
            'color_font_2'      => carbon_get_theme_option('color_font_2'),
            'blur_img'          => carbon_get_theme_option('blur_img'),
            'height_for'        => carbon_get_theme_option('height_for'),
            'btn_to_go'         => carbon_get_theme_option('btn_to_go'),
            'btn_to_go_link'    => carbon_get_theme_option('btn_to_go_link'),
            'btn_iframe'        => carbon_get_theme_option('btn_iframe'),
            'btn_iframe_link'   => carbon_get_theme_option('btn_iframe_link'),
            'btn_back_to'       => carbon_get_theme_option('btn_back_to'),
        ];
    }

    // Если complex пуст и запрашиваем индекс > 0 — возвращаем null
    return null;
}

/**
 * Получить все демо-карточки с поддержкой обратной совместимости
 *
 * @return array массив всех демо-карточек
 */
function gp_get_all_demo_cards() {
    $demo_cards = carbon_get_theme_option('demo_cards');

    // Если complex не пуст — используем его
    if (!empty($demo_cards) && is_array($demo_cards)) {
        return array_values($demo_cards);
    }

    // ОБРАТНАЯ СОВМЕСТИМОСТЬ: если complex пуст
    // — возвращаем первую карточку из старых полей
    $legacy_card = gp_get_demo_card(0);
    if ($legacy_card) {
        return [$legacy_card];
    }

    return [];
}

// ================= ШОРТКОДЫ ДЕМО =================

/**
 * Основной шорткод [game_preview]
 * Выводит первую демо-карточку (индекс 0)
 */
add_shortcode('game_preview', 'gp_render_shortcode');
function gp_render_shortcode()
{
    return gp_render_shortcode_by_index(0);
}

/**
 * Универсальная функция для вывода демо-карточки по индексу
 *
 * @param int $index индекс карточки (0-based)
 * @return string HTML шорткода или пустая строка если карточка не найдена
 */
function gp_render_shortcode_by_index($index = 0) {
    // Получаем данные демо-карточки
    $demo_card = gp_get_demo_card($index);

    // Если карточка не найдена — возвращаем пустую строку (без ошибок)
    if (!$demo_card) {
        return '';
    }

    // Сохраняем карточку в переменную для использования в шаблоне
    $GLOBALS['gp_demo_card_data'] = $demo_card;

    ob_start();
    include plugin_dir_path(__FILE__) . 'templates/preview-block.php';
    $html = ob_get_clean();

    // Очищаем глобальную переменную
    unset($GLOBALS['gp_demo_card_data']);

    return $html;
}

// Регистрируем дополнительные шорткоды [game_preview-1], [game_preview-2], и т.д.
// [game_preview-1] = индекс 0 (первая карточка)
// [game_preview-2] = индекс 1 (вторая карточка)
// и т.д.
for ($i = 1; $i <= 20; $i++) {
    add_shortcode('game_preview-' . $i, function() use ($i) {
        return gp_render_shortcode_by_index($i - 1);
    });
}


add_shortcode('table_block', 'table_block__short');
function table_block__short()
{
    ob_start();
    include plugin_dir_path(__FILE__) . 'templates/table-block.php';
    return ob_get_clean();
}

// Шорткод для блока эксперта
add_shortcode('expert_author', 'casino_expert__short');
function casino_expert__short()
{
    ob_start();
    // Передаём контекст рендера, чтобы шаблон знал, что он вызван как шорткод
    $render_context = 'shortcode';
    include plugin_dir_path(__FILE__) . 'templates/casino-expert.php';
    return ob_get_clean();
}

// Шорткод для accordion
add_shortcode('saintsmedia_accordion', 'saintsmedia_accordion');
function saintsmedia_accordion()
{
    ob_start();
    include plugin_dir_path(__FILE__) . 'templates/accordion.php';
    return ob_get_clean();
}

// Шорткод для витрины слотов
add_shortcode('slots_showcase', 'slots_showcase__short');
function slots_showcase__short()
{
    ob_start();
    include plugin_dir_path(__FILE__) . 'templates/slots-showcase.php';
    return ob_get_clean();
}

// ================= Schema JSON-LD queue/print =================
// Хранилище для JSON-LD схем плагина (во избежание дублей)
if (!function_exists('gp_set_expert_schema')) {
    function gp_set_expert_schema(array $json_ld)
    {
        global $gp_schema_store;
        if (!is_array($gp_schema_store)) {
            $gp_schema_store = [
                'expert' => null, // хранит первую валидную схему
            ];
        }
        // Сохраняем только первую валидную схему за запрос
        if (empty($gp_schema_store['expert'])) {
            $gp_schema_store['expert'] = $json_ld;
        }
    }
}

if (!function_exists('gp_print_schema_in_head')) {
    function gp_print_schema_in_head()
    {
        global $gp_schema_store;
        if (empty($gp_schema_store['expert'])) {
            return;
        }
        echo "\n<script type=\"application/ld+json\">";
        // Используем wp_json_encode, если доступен
        if (function_exists('wp_json_encode')) {
            echo wp_json_encode($gp_schema_store['expert'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        } else {
            echo json_encode($gp_schema_store['expert']);
        }
        echo "</script>\n";
        // Выводим только один раз
        $gp_schema_store['expert'] = null;
    }
    add_action('wp_head', 'gp_print_schema_in_head', 99);
}
