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

    // Скрипт приложения
    wp_enqueue_script(
        'gp-script',
        plugins_url('/assets/app.js', __FILE__),
        [],
        filemtime(plugin_dir_path(__FILE__) . 'assets/app.js'),
        true
    );
}

// Шорткод для блока превью
add_shortcode('game_preview', 'gp_render_shortcode');
function gp_render_shortcode()
{
    ob_start();
    include plugin_dir_path(__FILE__) . 'templates/preview-block.php';
    return ob_get_clean();
}

// Шорткод для таблицы
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
