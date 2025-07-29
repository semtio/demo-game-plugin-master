<?php
/*
Plugin Name: Game-Game-Game
Plugin URI: https://yourwebsite.com/
Description: 3 in 1 (Beta)
Version: 1.0
Author: 7on
*/

add_action('after_setup_theme', function () {
    \Carbon_Fields\Carbon_Fields::boot();
});
require_once plugin_dir_path(__FILE__) . 'carbon/main.php';

add_action('wp_enqueue_scripts', 'gp_enqueue_assets');
function gp_enqueue_assets()
{
    if (!is_singular()) return;

    wp_enqueue_style(
        'gp-style',
        plugins_url('/assets/style.css', __FILE__),
        [],
        filemtime(plugin_dir_path(__FILE__) . 'assets/style.css')
    );

    wp_enqueue_style(
        'gp-table-block',
        plugins_url('/assets/table-block.css', __FILE__),
        [],
        // filemtime(plugin_dir_path(__FILE__) . 'assets/table-block.css')
    );

    wp_enqueue_script(
        'gp-script',
        plugins_url('/assets/app.js', __FILE__),
        [],
        filemtime(plugin_dir_path(__FILE__) . 'assets/app.js'),
        true
    );
}

add_shortcode('game_preview', 'gp_render_shortcode');
function gp_render_shortcode()
{
    ob_start();
    include plugin_dir_path(__FILE__) . 'templates/preview-block.php';
    return ob_get_clean();
}

add_shortcode('table_block', 'table_block__short');
function table_block__short()
{
    ob_start();
    include plugin_dir_path(__FILE__) . 'templates/table-block.php';
    return ob_get_clean();
}
