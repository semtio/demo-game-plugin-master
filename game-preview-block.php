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
 * Получить СТАРУЮ legacy демо-карточку
 * Всегда возвращает данные из старых одиночных полей
 *
 * @return array данные legacy карточки
 */
function gp_get_legacy_demo_card() {
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

/**
 * Получить НОВУЮ демо-карточку из complex по индексу (0-based)
 *
 * @param int $index индекс карточки в complex (0, 1, 2, ...)
 * @return array|null данные карточки или null если не найдена
 */
function gp_get_demo_card($index = 0) {
    // Получаем complex field с новыми демо-карточками
    $demo_cards = carbon_get_theme_option('demo_cards');

    // Если complex пуст — возвращаем null
    if (empty($demo_cards) || !is_array($demo_cards)) {
        return null;
    }

    // Перебираем complex элементы
    $items = array_values($demo_cards);
    if (isset($items[$index])) {
        return $items[$index];
    }

    // Если запрошенный индекс не существует — возвращаем null
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

// Глобальный счётчик для генерации уникальных ID
if (!isset($GLOBALS['gp_shortcode_counter'])) {
    $GLOBALS['gp_shortcode_counter'] = 0;
}

/**
 * Основной шорткод [game_preview]
 * БЕЗ параметров → выводит СТАРУЮ legacy-карточку
 * С параметром index → выводит НОВУЮ карточку из complex
 *
 * Примеры:
 * [game_preview] → legacy (старая карточка)
 * [game_preview index="1"] → первая новая карточка из complex
 * [game_preview index="2"] → вторая новая карточка из complex
 */
add_shortcode('game_preview', 'gp_render_shortcode');
function gp_render_shortcode($atts = [])
{
    $atts = shortcode_atts([
        'index' => null,
    ], $atts, 'game_preview');

    // Если НЕ указан index → всегда выводим legacy
    if ($atts['index'] === null) {
        $demo_card = gp_get_legacy_demo_card();
    } else {
        // Если указан index → берём из complex
        $index = max(1, (int) $atts['index']);
        $demo_card = gp_get_demo_card($index - 1);

        // Если карточка не найдена — возвращаем пустоту
        if (!$demo_card) {
            return '';
        }
    }

    // Генерируем уникальный ID для этого шорткода
    $GLOBALS['gp_shortcode_counter']++;
    $unique_id = 'gp-preview-' . $GLOBALS['gp_shortcode_counter'];

    // Сохраняем карточку и уникальный ID в переменные для использования в шаблоне
    $GLOBALS['gp_demo_card_data'] = $demo_card;
    $GLOBALS['gp_shortcode_unique_id'] = $unique_id;

    ob_start();
    include plugin_dir_path(__FILE__) . 'templates/preview-block.php';
    $html = ob_get_clean();

    // Очищаем глобальные переменные
    unset($GLOBALS['gp_demo_card_data']);
    unset($GLOBALS['gp_shortcode_unique_id']);

    return $html;
}

// Поддержка шорткодов с дефисом: [game_preview-1], [game_preview-2], ...
// Преобразуем их в [game_preview index="N"].
add_filter('the_content', 'gp_expand_demo_shortcodes', 9);
function gp_expand_demo_shortcodes($content)
{
    return preg_replace_callback('/\[game_preview-(\d+)([^\]]*)\]/', function ($matches) {
        $index = (int) $matches[1];
        $tail = trim($matches[2] ?? '');

        if ($index < 1) {
            $index = 1;
        }

        return '[game_preview index="' . $index . '"' . ($tail ? ' ' . $tail : '') . ']';
    }, $content);
}


// ================= ВСПОМОГАТЕЛЬНЫЕ ФУНКЦИИ ДЛЯ ТАБЛИЦ КАЗИНО =================

/**
 * Получить все таблицы казино (новые), либо fallback на legacy
 *
 * @return array Массив таблиц
 */
function gp_get_all_casino_tables()
{
    $tables = carbon_get_theme_option('casino_tables');

    if (!empty($tables) && is_array($tables)) {
        $tables = array_values($tables);

        // Оставляем только таблицы, где есть строки
        $filtered = [];
        foreach ($tables as $table) {
            $rows = $table['table_rows'] ?? ($table['complex_table'] ?? []);
            if (!empty($rows) && is_array($rows)) {
                // Нормализуем структуру для шаблона
                $table['complex_table'] = $rows;
                $filtered[] = $table;
            }
        }

        return $filtered;
    }

    return [];
}

/**
 * Есть ли новые таблицы с данными
 *
 * @return bool
 */
function gp_has_new_casino_tables()
{
    $tables = gp_get_all_casino_tables();
    return !empty($tables);
}

/**
 * Получить таблицу по индексу (0-based)
 *
 * @param int $index
 * @return array|null
 */
function gp_get_casino_table_by_index($index = 0)
{
    $tables = gp_get_all_casino_tables();
    return isset($tables[$index]) ? $tables[$index] : null;
}

/**
 * Обратная совместимость: получить старую таблицу из legacy полей
 *
 * @return array|null
 */
function gp_get_legacy_casino_table()
{
    $complex_table = carbon_get_theme_option('complex_table');

    if (empty($complex_table) || !is_array($complex_table)) {
        return null;
    }

    return [
        'casino_table_text_1'   => carbon_get_theme_option('casino_table_text_1'),
        'casino_table_col_btn_1' => carbon_get_theme_option('casino_table_col_btn_1'),
        'casino_table_col_btn_2' => carbon_get_theme_option('casino_table_col_btn_2'),
        'casino_table_bg_col'   => carbon_get_theme_option('casino_table_bg_col'),
        'casino_table_outline'  => carbon_get_theme_option('casino_table_outline'),
        'casino_table_text_color' => carbon_get_theme_option('casino_table_text_color'),
        'complex_table'         => $complex_table,
    ];
}

// ================= ШОРТКОДЫ ТАБЛИЦА КАЗИНО =================

// Глобальный счётчик для генерации уникальных instance ID (для каждого вызова)
if (!isset($GLOBALS['casino_table_instance_counter'])) {
    $GLOBALS['casino_table_instance_counter'] = 0;
}

/**
 * Шорткод [table_block]
 *
 * Примеры:
 * [table_block] — первая таблица
 * [table_block index="2"] — вторая таблица
 * [table_block-3] — третья таблица
 */
add_shortcode('table_block', 'table_block__short');
function table_block__short($atts = [])
{
    $atts = shortcode_atts([
        'index' => null,
    ], $atts, 'table_block');

    $has_new = gp_has_new_casino_tables();
    $legacy = gp_get_legacy_casino_table();

    if ($atts['index'] === null) {
        // [table_block] — всегда legacy, если есть. Если legacy нет, берём первую новую.
        if ($legacy) {
            $table_data = $legacy;
        } elseif ($has_new) {
            $table_data = gp_get_casino_table_by_index(0);
        } else {
            return '';
        }
    } else {
        // [table_block index="N"] — только для новых таблиц
        if (!$has_new) {
            return '';
        }
        $index = max(1, (int) $atts['index']);
        $table_data = gp_get_casino_table_by_index($index - 1);
    }

    if (!$table_data) {
        return '';
    }

    // Генерируем уникальный instance ID (для этого вызова шорткода)
    $GLOBALS['casino_table_instance_counter']++;
    $instance_id = 'casino-table-instance-' . $GLOBALS['casino_table_instance_counter'];

    // Передаём данные в шаблон
    $GLOBALS['casino_table_data'] = $table_data;
    $GLOBALS['casino_table_instance_id'] = $instance_id;

    ob_start();
    include plugin_dir_path(__FILE__) . 'templates/table-block.php';
    $html = ob_get_clean();

    // Очищаем глобальные переменные
    unset($GLOBALS['casino_table_data']);
    unset($GLOBALS['casino_table_instance_id']);

    return $html;
}

// Поддержка шорткодов с дефисом: [table_block-1], [table_block-2], ...
// Преобразуем их в [table_block index="N"].
add_filter('the_content', 'gp_expand_table_shortcodes', 9);
function gp_expand_table_shortcodes($content)
{
    return preg_replace_callback('/\[table_block-(\d+)([^\]]*)\]/', function ($matches) {
        $index = (int) $matches[1];
        $tail = trim($matches[2] ?? '');

        if ($index < 1) {
            $index = 1;
        }

        return '[table_block index="' . $index . '"' . ($tail ? ' ' . $tail : '') . ']';
    }, $content);
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
