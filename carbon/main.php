<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action('carbon_fields_register_fields', 'crb_attach_plugin_options');
function crb_attach_plugin_options()
{

    // ----------------------------------------------
    // --------------------- 0 ----------------------
    // ----------------------------------------------

    // РОДИТЕЛЬСКОЕ МЕНЮ
    Container::make('theme_options', 'Шорткоды для всавки')
        ->set_page_menu_title('Шорткоды')
        ->set_page_file('crb_demo_game')
        ->add_fields([Field::make('html', 'demo_info_block')->set_html('
            <h3>Demo: [game_preview]</h3>
            <h3>Таблица: [casino_table]</h3>
        ')]);

    // ----------------------------------------------
    // --------------------- 1 ----------------------
    // ----------------------------------------------

    // СТРАНИЦА 1 — Demo
    Container::make('theme_options', 'Demo')
        ->set_page_parent('crb_demo_game')
        ->add_fields([
            // Фон картинка
            Field::make('image', 'blur_img', __('Блюр-Фон (blur_img)'))
                ->set_value_type('url')
                ->set_width(33),
            // Высота
            Field::make('text', 'height_for', __('Высота окна (height_for)'))
                ->set_width(33),

            // Кнопка 1
            Field::make('text', 'btn_to_go', __('Кнопка перехода (btn_to_go)'))
                ->set_width(50),
            Field::make('text', 'btn_to_go_link', __('Ссылка перехода (btn_to_go_link)'))
                ->set_width(50),

            // Кнопка ЦВЕТ #1
            Field::make('color', 'btn_color_1', __('Кнопка #1 (btn_color_1)'))
                ->set_width(33)
                ->set_default_value('#FF7A00'),
            Field::make('color', 'btn_color_2', __('Кнопка #1 (btn_color_2)'))
                ->set_width(33)
                ->set_default_value('#FF002B'),
            Field::make('color', 'color_font_1', __('Цвет шрифта #1 (color_font_1)'))
                ->set_width(33)
                ->set_default_value('#ffffff'),

            // Кнопка 2
            Field::make('text', 'btn_iframe', __('Кнопка Iframe (btn_iframe)'))
                ->set_width(50),
            Field::make('text', 'btn_iframe_link', __('Ссылка Iframe (btn_iframe_link)'))
                ->set_width(50),

            // Кнопка ЦВЕТ #2
            // Field::make('separator', 'sep2', 'Кнопки 2'),
            Field::make('color', 'btn_color_3', __('Кнопка #2 (btn_color_3)'))
                ->set_width(33)
                ->set_default_value('#ffd700'),
            Field::make('color', 'btn_color_4', __('Кнопка #2 (btn_color_4)'))
                ->set_width(33)
                ->set_default_value('#ffd700'),
            Field::make('color', 'color_font_2', __('Цвет шрифта #2 (color_font_2)'))
                ->set_width(33)
                ->set_default_value('#484848'),

            // Кнопка назад
            Field::make('text', 'btn_back_to', __('Кнопка назад (btn_back_to)'))
        ]);


    // ----------------------------------------------
    // --------------------- 2 ----------------------
    // ----------------------------------------------


    // СТРАНИЦА 2 — Таблица казино
    Container::make('theme_options', 'Таблица')
        ->set_page_parent('crb_demo_game')
        ->add_fields([
            Field::make('separator', 'css_1', __('Стили')),
            // CSS стили карточек
            Field::make('color', 'casino_table_text_1', __('Цвет текста (casino_table_text_1)'))
                ->set_width(10)
                ->set_default_value('#ffffff')
                ->set_palette(array('#ffffff')),

            Field::make('color', 'casino_table_col_btn_1', __('1ый Градиент кнопки (casino_table_col_btn_1)'))
                ->set_width(10)
                ->set_default_value('#40e06f')
                ->set_palette(array('#40e06f')),

            Field::make('color', 'casino_table_col_btn_2', __('2ой Градиент кнопки(casino_table_col_btn_2)'))
                ->set_width(10)
                ->set_default_value('#5df88f')
                ->set_palette(array('#5df88f')),

            Field::make('color', 'casino_table_bg_col', __('Фон карточек списка (casino_table_bg_col)'))
                ->set_width(10)
                ->set_default_value('#1B2C5F')
                ->set_palette(array('#1B2C5F')),

            Field::make('color', 'casino_table_outline', __('Обводка / Нумерация (casino_table_outline)'))
                ->set_width(10)
                ->set_default_value('#A340FB')
                ->set_palette(array('#A340FB')),


            Field::make('separator', 'crb_separator2', __('Таблица казино')),
            // Цикл 
            Field::make('complex', 'complex_table', __('table'))
                ->add_fields([
                    // Логотип
                    Field::make('image', 'casino_table_logo', __('Логотип (casino_table_logo)'))
                        ->set_value_type('url'),
                    Field::make('text', 'casino_name', __('Имя казино (casino_name)'))
                        ->set_width(25),
                    Field::make('text', 'table_info_tag', __('Инфо заг. (table_info_tag)'))
                        ->set_width(25),
                    Field::make('text', 'table_info_descr', __('Инфо описание (table_info_descr)'))
                        ->set_width(25),
                    Field::make('text', 'table_cta_btn', __('Кнопка (table_cta_btn)'))
                        ->set_width(25),
                    Field::make('text', 'table_link_to_casino', __('Ссылка на казино (table_link_to_casino)'))
                        ->set_width(25),

                ])->set_collapsed(true), // true для развёрнуто всегда
        ]);
}

add_action('after_setup_theme', function () {
    \Carbon_Fields\Carbon_Fields::boot();
});
