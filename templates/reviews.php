<?php
/**
 * Шаблон для вывода отзывов
 *
 * Получает данные из глобальных переменных:
 * - $GLOBALS['reviews_data'] — данные списка отзывов
 * - $GLOBALS['reviews_instance_id'] — уникальный ID для этого экземпляра
 */

// Получаем данные
$reviews_data = isset($GLOBALS['reviews_data']) ? $GLOBALS['reviews_data'] : null;
$instance_id = isset($GLOBALS['reviews_instance_id']) ? $GLOBALS['reviews_instance_id'] : 'sm-reviews-default';

if (!$reviews_data) {
    return;
}

// Извлекаем настройки стилей и кнопок
$border_color = $reviews_data['review_border_color'] ?? '#333';
$bg_color = $reviews_data['review_bg_color'] ?? '#110732';
$text_color = $reviews_data['review_text_color'] ?? '#d0d0d0';
$btn_show = $reviews_data['review_btn_show'] ?? 'Show more';
$btn_hide = $reviews_data['review_btn_hide'] ?? 'Hide';

// Извлекаем массив отзывов
$reviews_items = $reviews_data['reviews_items'] ?? [];

if (empty($reviews_items) || !is_array($reviews_items)) {
    return;
}
?>

<style>
    /* Контейнер отзывов */
    #<?php echo esc_attr($instance_id); ?> {
        margin: 0 auto;
        font-family: Arial, sans-serif;
    }

    /* Карточка отзыва */
    #<?php echo esc_attr($instance_id); ?> .sm-review {
        background: <?php echo esc_attr($bg_color); ?>;
        padding: 25px;
        margin-bottom: 25px;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        display: flex;
        gap: 20px;
        border: 1px solid <?php echo esc_attr($border_color); ?>;
    }

    /* Avatar */
    #<?php echo esc_attr($instance_id); ?> .sm-review-avatar {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background-size: cover;
        background-position: center;
        flex-shrink: 0;
    }

    /* Content */
    #<?php echo esc_attr($instance_id); ?> .sm-review-content {
        flex: 1;
    }

    #<?php echo esc_attr($instance_id); ?> .sm-review-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 5px;
    }

    #<?php echo esc_attr($instance_id); ?> .sm-review-name {
        color: #ffffff;
        font-size: 18px;
        font-weight: bold;
    }

    #<?php echo esc_attr($instance_id); ?> .sm-review-date {
        font-size: 13px;
        color: #a0a0a0;
    }

    /* Stars */
    #<?php echo esc_attr($instance_id); ?> .sm-review-stars svg {
        width: 18px;
        height: 18px;
        margin-left: 2px;
    }

    #<?php echo esc_attr($instance_id); ?> .sm-star-full {
        fill: #ffd700;
    }

    #<?php echo esc_attr($instance_id); ?> .sm-star-empty {
        fill: #444;
    }

    /* Text */
    #<?php echo esc_attr($instance_id); ?> .sm-review-text {
        margin-top: 10px;
        font-size: 15px;
        line-height: 1.5;
        color: <?php echo esc_attr($text_color); ?>;
        max-height: 70px;
        overflow: hidden;
        position: relative;
        transition: 0.3s;
    }

    #<?php echo esc_attr($instance_id); ?> .sm-review-text.sm-expanded {
        max-height: none;
    }

    /* Button */
    #<?php echo esc_attr($instance_id); ?> .sm-read-more {
        margin-top: 8px;
        background: none;
        border: none;
        color: #5dade2;
        cursor: pointer;
        font-size: 14px;
        padding: 0;
    }

    #<?php echo esc_attr($instance_id); ?> .sm-read-more:hover {
        text-decoration: underline;
        color: #85c1e2;
    }
</style>

<div class="sm-reviews" id="<?php echo esc_attr($instance_id); ?>">
    <?php foreach ($reviews_items as $index => $review) : ?>
        <?php
        // Извлекаем данные отзыва
        $name = $review['review_name'] ?? '';
        $date = $review['review_date'] ?? '';
        $rating = max(1, min(5, (int) ($review['review_rating'] ?? 5)));
        $avatar = $review['review_avatar'] ?? '';
        $text = $review['review_text'] ?? '';
        ?>

        <div class="sm-review">

            <?php if (!empty($avatar)) : ?>
                <div class="sm-review-avatar" style="background-image:url('<?php echo esc_url($avatar); ?>')"></div>
            <?php else : ?>
                <div class="sm-review-avatar" style="background-color: #333;"></div>
            <?php endif; ?>

            <div class="sm-review-content">
                <div class="sm-review-top">
                    <div>
                        <?php if (!empty($name)) : ?>
                            <div class="sm-review-name"><?php echo esc_html($name); ?></div>
                        <?php endif; ?>
                        <?php if (!empty($date)) : ?>
                            <div class="sm-review-date"><?php echo esc_html($date); ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="sm-review-stars" data-rating="<?php echo esc_attr($rating); ?>" data-index="<?php echo esc_attr($index); ?>"></div>
                </div>

                <?php if (!empty($text)) : ?>
                    <div class="sm-review-text" id="<?php echo esc_attr($instance_id . '-text-' . $index); ?>">
                        <?php echo esc_html($text); ?>
                    </div>
                    <button class="sm-read-more" id="<?php echo esc_attr($instance_id . '-btn-' . $index); ?>" style="display: none;" data-index="<?php echo esc_attr($index); ?>">
                        <?php echo esc_html($btn_show); ?>
                    </button>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<script>
    (() => {
        const instanceId = '<?php echo esc_js($instance_id); ?>';
        const container = document.getElementById(instanceId);

        if (!container) return;

        /* ======================
           SVG ЗВЕЗДА
        ====================== */
        function createStar(filled = true) {
            return `
                <svg viewBox="0 0 576 512">
                    <path class="${filled ? 'sm-star-full' : 'sm-star-empty'}"
                    d="M381.2 150.3L524.9 171.5C569.3 178.1 586.7 231.1 554.7 262.8L449.8 366.3L475.2 509.5C482.9 553.8 436.5 587.5 397.8 566.6L288 510.8L178.2 566.6C139.5 587.5 93.1 553.8 100.8 509.5L126.2 366.3L21.3 262.8C-10.7 231.1 6.7 178.1 51.1 171.5L194.8 150.3L259.9 17.8C279.4 -22.6 336.6 -22.6 356.1 17.8L381.2 150.3Z"/>
                </svg>`;
        }

        /* ======================
           ГЕНЕРАЦИЯ ЗВЕЗД
        ====================== */
        function renderStars(rating) {
            let stars = '';
            for (let i = 1; i <= 5; i++) {
                stars += createStar(i <= rating);
            }
            return stars;
        }

        /* ======================
           РЕНДЕР ЗВЁЗД ДЛЯ ВСЕХ ОТЗЫВОВ
        ====================== */
        const starsContainers = container.querySelectorAll('.sm-review-stars');
        starsContainers.forEach((starsContainer) => {
            const rating = parseInt(starsContainer.getAttribute('data-rating'), 10) || 5;
            starsContainer.innerHTML = renderStars(rating);
        });

        /* ======================
           КНОПКИ "ПОКАЗАТЬ/СКРЫТЬ" ДЛЯ ВСЕХ ОТЗЫВОВ
        ====================== */
        const buttons = container.querySelectorAll('.sm-read-more');
        buttons.forEach((btnEl) => {
            const index = btnEl.getAttribute('data-index');
            const textEl = document.getElementById(instanceId + '-text-' + index);

            if (textEl && btnEl) {
                // Проверяем — обрезан ли текст
                if (textEl.scrollHeight > 70) {
                    btnEl.style.display = 'block';

                    btnEl.addEventListener('click', () => {
                        textEl.classList.toggle('sm-expanded');
                        btnEl.textContent = textEl.classList.contains('sm-expanded')
                            ? '<?php echo esc_js($btn_hide); ?>'
                            : '<?php echo esc_js($btn_show); ?>';
                    });
                }
            }
        });
    })();
</script>
