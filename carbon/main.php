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
            <style>
                 .saintsmedia-dedicated{
                    color: #fff;
                    background: #727272ff;
                    padding: 0.25rem 0.5rem ;
                 }
            </style>
            <h3>Шорткоды на плагин DTE:</h3> 
            <h3>Demo: <b class="saintsmedia-dedicated">[game_preview]</b></h3>
            <h3>Таблица: <b class="saintsmedia-dedicated">[table_block]</b></h3>
            <h3>Експерт: <b class="saintsmedia-dedicated">[expert_author]</b></h3>

            <br>
            <hr>
            <h3>Установка:</h3> 
            <h3>Плагин DTE: <b class="saintsmedia-dedicated">semtio/demo-game-plugin-master</b></h3> 
            <h3>Тема: <b class="saintsmedia-dedicated">semtio/saintsmedia-theme</b></h3> 

        ')]);

    // ----------------------------------------------
    // --------------------- 1 ----------------------
    // ----------------------------------------------

    // СТРАНИЦА 1 — Demo
    Container::make('theme_options', 'Demo')
        ->set_page_parent('crb_demo_game')
        ->add_fields([
            // Кнопка ЦВЕТ #1
            Field::make('color', 'btn_color_1', __('Кнопка перехода на сайт ЦВЕТ_ФОН_1 (btn_color_1)'))
                ->set_width(33)
                ->set_palette(array('#FF7A00'))
                ->set_default_value('#FF7A00'),
            Field::make('color', 'btn_color_2', __('Кнопка перехода на сайт ЦВЕТ_ФОН_2 (btn_color_2)'))
                ->set_width(33)
                ->set_palette(array('#FF002B'))
                ->set_default_value('#FF002B'),
            Field::make('color', 'color_font_1', __('Кнопка перехода на сайт ЦВЕТ ТЕКСТ (color_font_1)'))
                ->set_width(33)
                ->set_palette(array('#ffffff'))
                ->set_default_value('#ffffff'),

            // Кнопка ЦВЕТ #2
            // Field::make('separator', 'sep2', 'Кнопки 2'),
            Field::make('color', 'btn_color_3', __('Кнопка ДЕМО ЦВЕТ_ФОН_1 (btn_color_3)'))
                ->set_width(33)
                ->set_palette(array('#ffd700'))
                ->set_default_value('#ffd700'),
            Field::make('color', 'btn_color_4', __('Кнопка ДЕМО ЦВЕТ_ФОН_2 (btn_color_4)'))
                ->set_width(33)
                ->set_palette(array('#ffd700'))
                ->set_default_value('#ffd700'),
            Field::make('color', 'color_font_2', __('Кнопка ДЕМО ЦВЕТ_ТЕКСТ (color_font_2)'))
                ->set_width(33)
                ->set_palette(array('#484848'))
                ->set_default_value('#484848'),

            // Фон картинка
            Field::make('image', 'blur_img', __('Картинка-Фон (blur_img)'))
                ->set_value_type('url')
                ->set_width(50),
            // Высота
            Field::make('text', 'height_for', __('Высота окна (height_for)'))
                ->set_width(50),

            // Кнопка 1
            Field::make('text', 'btn_to_go', __('Кнопка перехода (btn_to_go)'))
                ->set_width(50),
            Field::make('text', 'btn_to_go_link', __('Ссылка перехода (btn_to_go_link)'))
                ->set_width(50),

            // Кнопка 2
            Field::make('text', 'btn_iframe', __('Кнопка Iframe (btn_iframe)'))
                ->set_width(50),
            Field::make('text', 'btn_iframe_link', __('Ссылка Iframe (btn_iframe_link)'))
                ->set_width(50),



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

            Field::make('color', 'casino_table_outline', __('Обводка + Нумерация (casino_table_outline)'))
                ->set_width(10)
                ->set_default_value('#A340FB')
                ->set_palette(array('#A340FB')),

            Field::make('color', 'casino_table_text_color', __('Цвет номера (casino_table_text_color)'))
                ->set_width(10)
                ->set_default_value('#ffffffff')
                ->set_palette(array('#ffffffff')),


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
                    Field::make('text', 'table_rating_casino', __('Рейтинг казино указывается дробно 5.0 (table_rating_casino)'))
                        ->set_width(25)
                        ->set_attribute('type', 'number')
                        ->set_attribute('step', '0.1')
                        ->set_attribute('min', '1')
                        ->set_attribute('max', '5')

                ])->set_collapsed(true), // true для развёрнуто всегда
        ]);

    // ----------------------------------------------
    // --------------------- 3 ----------------------
    // ----------------------------------------------

    // СТРАНИЦА 3 — Автор
    Container::make('theme_options', 'Автор')
        ->set_page_parent('crb_demo_game')
        ->add_fields([
            Field::make('separator', 'spec_exp_css_author', __('Стили')),
            // CSS стили карточек
            Field::make('color', 'spec_exp_bg', __('Фон карточки автора (spec_exp_bg)'))
                ->set_width(10)
                ->set_default_value('#F4F7FF')
                ->set_palette(array('#F4F7FF')),
            Field::make('color', 'spec_exp_main_color_text', __('Основной цвет текста (spec_exp_main_color_text)'))
                ->set_width(10)
                ->set_default_value('#333333')
                ->set_palette(array('#333333')),
            Field::make('color', 'spec_exp_color_name', __('Цвет имени автора (spec_exp_color_name)'))
                ->set_width(10)
                ->set_default_value('#444444')
                ->set_palette(array('#444444')),
            Field::make('color', 'spec_exp_bg_circle', __('Цвет кружочка (spec_exp_bg_circle)'))
                ->set_width(10)
                ->set_default_value('#13E338')
                ->set_palette(array('#13E338')),

            Field::make('image', 'spec_exp_author_photo', __('Фото автора (spec_exp_author_photo)'))
                ->set_value_type('url'),
            Field::make('text', 'spec_exp_h2_title', __('H2 Заголовок (spec_exp_h2_title)'))
                ->set_width(25),
            Field::make('text', 'spec_exp_author_name', __('Имя автора (spec_exp_author_name)'))
                ->set_width(25),
            Field::make('text', 'spec_exp_author_info', __('Инфо автора (spec_exp_author_info)'))
                ->set_width(25),


            Field::make('text', 'spec_exp_author_twitter', __('Twitter (spec_exp_author_twitter)'))
                ->set_width(50),
            Field::make('text', 'spec_exp_author_linkedin', __('Linkedin (spec_exp_author_linkedin)'))
                ->set_width(50),
            Field::make('text', 'spec_exp_author_facebook', __('Facebook (spec_exp_author_facebook)'))
                ->set_width(50),
            Field::make('text', 'spec_exp_author_instagram', __('Instagram (spec_exp_author_instagram)'))
                ->set_width(50),
            Field::make('text', 'spec_exp_author_youtube', __('Youtube (spec_exp_author_youtube)'))
                ->set_width(50),
            Field::make('text', 'spec_exp_author_telegram', __('Telegram (spec_exp_author_telegram)'))
                ->set_width(50),
        ]);
}

add_action('after_setup_theme', function () {
    \Carbon_Fields\Carbon_Fields::boot();
});
