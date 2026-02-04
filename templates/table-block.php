<?php
/**
 * Шаблон для вывода таблицы казино
 *
 * Получает данные из глобальных переменных:
 * - $GLOBALS['casino_table_data'] — данные таблицы
 * - $GLOBALS['casino_table_instance_id'] — уникальный ID для этого экземпляра
 */

// Получаем данные таблицы и instance ID
$table_data = isset($GLOBALS['casino_table_data']) ? $GLOBALS['casino_table_data'] : null;
$instance_id = isset($GLOBALS['casino_table_instance_id']) ? $GLOBALS['casino_table_instance_id'] : 'casino-table-default';

if (!$table_data || (!isset($table_data['table_rows']) && !isset($table_data['complex_table']))) {
    return;
}

// Извлекаем данные таблицы
$table_items = $table_data['table_rows'] ?? ($table_data['complex_table'] ?? []);
$text_color = $table_data['casino_table_text_1'] ?? '#ffffff';
$btn_color_1 = $table_data['casino_table_col_btn_1'] ?? '#40e06f';
$btn_color_2 = $table_data['casino_table_col_btn_2'] ?? '#5df88f';
$bg_color = $table_data['casino_table_bg_col'] ?? '#1B2C5F';
$outline_color = $table_data['casino_table_outline'] ?? '#A340FB';
$number_color = $table_data['casino_table_text_color'] ?? '#ffffff';

if (empty($table_items)) {
    return;
}
?>

<div class="saintsmedia-wrapper" data-instance-id="<?php echo esc_attr($instance_id); ?>">
    <div class="saintsmedia-casino-table" id="<?php echo esc_attr($instance_id . '-container'); ?>">

        <?php foreach ($table_items as $index => $item) : ?>

            <?php
            // Подготавливаем логотип
            $logo_attr = saintsmedia_responsive_bg($item['casino_table_logo'] ?? '', 'saintsmedia-logo', 'medium_large');
            ?>

            <style>
                #<?php echo esc_attr($instance_id . '-cta-' . $index); ?> a {
                    animation: pulse-<?php echo esc_attr($instance_id); ?> 3s infinite;
                }

                @keyframes pulse-<?php echo esc_attr($instance_id); ?> {
                    0% {
                        box-shadow: 0 0 0 0 <?php echo esc_attr($btn_color_1); ?>;
                    }
                    70% {
                        box-shadow: 0 0 0 10px rgba(93, 248, 143, 0);
                    }
                    100% {
                        box-shadow: 0 0 0 0 rgba(93, 248, 143, 0);
                    }
                }
            </style>

            <!-- Карточка казино -->
            <div class="saintsmedia-casino-card <?php echo $index === 0 ? 'saintsmedia-casino-card--primary' : ''; ?>"
                style="background-color:<?php echo esc_attr($bg_color); ?>; color:<?php echo esc_attr($text_color); ?>;<?php echo $index === 0 ? ' outline: 3.8px solid ' . esc_attr($outline_color) . ';' : ''; ?>">

                <!-- Логотип -->
                <a href="<?php echo esc_url(tfc_go_link($item['table_link_to_casino'] ?? '')); ?>" target="_blank"
                    rel="nofollow noopener noreferrer">
                    <div <?php echo $logo_attr; ?>>
                        <div class="saintsmedia-order-number" data-index="<?php echo esc_attr($index); ?>"
                            style="background-color:<?php echo esc_attr($outline_color); ?>; color:<?php echo esc_attr($number_color); ?>;">
                        </div>
                    </div>
                </a>

                <!-- Название казино -->
                <div class="saintsmedia-casino-name">
                    <?php echo esc_html($item['casino_name'] ?? ''); ?>
                </div>

                <!-- Информация -->
                <div class="saintsmedia-info">
                    <div class="saintsmedia-info-tag">
                        <?php echo esc_html($item['table_info_tag'] ?? ''); ?>
                    </div>
                    <div style="text-align: center !important;" class="saintsmedia-info-descr">
                        <?php echo wp_kses_post(wpautop($item['table_info_descr'] ?? '')); ?>
                    </div>
                </div>

                <!-- Рейтинг -->
                <div class="saintsmedia-rating">
                    <span class="what-is-rating" data-value="<?php echo esc_attr($item['table_rating_casino'] ?? '0'); ?>">
                        <?php echo esc_html($item['table_rating_casino'] ?? '0'); ?>
                    </span>
                </div>

                <!-- Кнопка -->
                <div class="saintsmedia-cta" id="<?php echo esc_attr($instance_id . '-cta-' . $index); ?>">
                    <a style="background: linear-gradient(90deg, <?php echo esc_attr($btn_color_1); ?> 0%, <?php echo esc_attr($btn_color_2); ?> 100%);"
                        href="<?php echo esc_url(tfc_go_link($item['table_link_to_casino'] ?? '')); ?>" target="_blank"
                        rel="nofollow noopener noreferrer">
                        <?php echo esc_html($item['table_cta_btn'] ?? 'Play'); ?> <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </div><!-- /.saintsmedia-casino-card -->

        <?php endforeach; ?>

    </div><!-- /.saintsmedia-casino-table -->
</div><!-- /.saintsmedia-wrapper -->

<script>
    (() => {
        const instanceId = '<?php echo esc_js($instance_id); ?>';
        const container = document.getElementById(instanceId + '-container');

        if (!container) return;

        // == Нумерация карточек (только в этом контейнере) ==
        const orderNumbers = container.querySelectorAll('.saintsmedia-order-number');
        orderNumbers.forEach((el) => {
            const index = parseInt(el.getAttribute('data-index'), 10);
            el.textContent = index + 1;
        });

        // == Рейтинги и звёзды ==
        const ratings = container.querySelectorAll('.what-is-rating');
        ratings.forEach((node) => {
            const value = parseFloat(node.getAttribute('data-value') || node.textContent);
            const full = Math.floor(value);
            const half = (value % 1) >= 0.5;
            const wrap = node.parentElement;

            node.remove();

            for (let i = 0; i < 5; i++) {
                const star = document.createElement('i');
                if (i < full) {
                    star.className = 'fa-solid fa-star';
                } else if (i === full && half) {
                    star.className = 'fa-solid fa-star-half-stroke';
                } else {
                    star.className = 'fa-regular fa-star';
                }
                wrap.appendChild(star);
            }

            const span = document.createElement('span');
            span.textContent = value.toFixed(1);
            span.style.marginLeft = '6px';
            wrap.appendChild(span);
        });
    })();
</script>
