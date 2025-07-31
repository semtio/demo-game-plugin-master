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
            Field::make('separator', 'crb_separator1', __('CSS стили карточек')),
            // CSS стили карточек
            Field::make('color', 'table_bkg_color', __('Фон карточек (table_bkg_color)'))
                ->set_width(30)
                ->set_default_value('#ffffff')
                ->set_palette(array('#ffffff')),

            Field::make('color', 'table_text_color', __('Цвет текста карточек(table_text_color)'))
                ->set_width(30)
                ->set_default_value('#333333')
                ->set_palette(array('#333333')),

            Field::make('color', 'table_bonus_bg_color', __('Welcome Bonus BG(table_bonus_bg_color)'))
                ->set_width(30)
                ->set_default_value('#FF7037')
                ->set_palette(array('#FF7037')),

            Field::make('color', 'table_bonus_text_color', __('Цвет текста кнопок(table_bonus_text_color)'))
                ->set_width(30)
                ->set_default_value('#ffffff')
                ->set_palette(array('#ffffff')),

            Field::make('color', 'table_btn_gradient_1', __('Градиент кнопки 1(table_btn_gradient_1)'))
                ->set_width(30)
                ->set_default_value('#2c5aa0')
                ->set_palette(array('#2c5aa0')),

            Field::make('color', 'table_btn_gradient_2', __('Градиент кнопки 2(table_btn_gradient_2)'))
                ->set_width(30)
                ->set_default_value('#1e3a5f')
                ->set_palette(array('#1e3a5f')),

            Field::make('separator', 'crb_separator2', __('Таблица казино')),
            // Цикл 
            Field::make('complex', 'complex_table', __('table'))
                ->add_fields([
                    // Логотип
                    Field::make('image', 'logo_table', __('Логотип (logo_table)'))
                        ->set_value_type('url'),

                    // Инфо заголовок
                    Field::make('text', 'text_title', __('Заголовок (text_title)'))
                        ->set_default_value('Casino name'),

                    // Инфо список
                    Field::make('text', 'info_1', __('Инфо 1 (info_1)'))
                        ->set_default_value('Licensed and regulated gaming')
                        // ->help_text('Licensed and regulated gaming')
                        ->set_width(33),
                    Field::make('text', 'info_2', __('Инфо 2 (info_2)'))
                        ->set_default_value('24/7 customer support available')
                        // ->help_text('24/7 customer support available')
                        ->set_width(33),
                    Field::make('text', 'info_3', __('Инфо 3 (info_3)'))
                        ->set_default_value('Fast and secure payment processing')
                        // ->help_text('Fast and secure payment processing')
                        ->set_width(33),

                    // Кнопки бонус и перейти
                    Field::make('text', 'bonus_1', __('Бонус $ (bonus_1)'))
                        ->set_default_value('$500')
                        ->set_width(50),
                    Field::make('text', 'bonus_2', __('Welcome Бонус(bonus_2)'))
                        ->set_default_value('Welcome Bonus + 100 Free Spins')
                        // ->help_text('Welcome Bonus + 100 Free Spins')
                        ->set_width(50),

                    Field::make('text', 'go_to_btn', __('Имя кнопки перейти (go_to_btn)'))
                        ->set_default_value('Play Now')
                        ->set_width(50),
                    Field::make('text', 'go_to_btn_link', __('Бонус (go_to_btn_link)'))
                        ->set_default_value('https://example.com/')
                        // ->help_text('https://example.com/')
                        ->set_width(50)
                ])->set_collapsed(true), // true для развёрнуто всегда
        ]);
}

add_action('after_setup_theme', function () {
    \Carbon_Fields\Carbon_Fields::boot();
});
