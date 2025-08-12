<?php
// Новая логика: берём один textarea (accordion_hesh_tags) и разбиваем по строкам.
$textarea_raw = carbon_get_theme_option('accordion_hesh_tags');
$items = [];
if (!empty($textarea_raw)) {
    // Разделяем по переводам строк (Windows/Unix) и чистим
    $lines = preg_split('/\r?\n/', $textarea_raw);
    if (is_array($lines)) {
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '') continue;
            $items[] = $line; // Сырые строки; ниже экранируем
        }
    }
}
?>

<?php if (!empty($items)) : ?>
    <div style="color: #000;" class="saintsmedia-accordion" id="saintsmedia-accordion">
        <button class="saintsmedia-accordion-toggle" type="button" aria-expanded="false" aria-controls="saintsmedia-accordion-panel">
            <span class="saintsmedia-accordion-toggle-left">
                <i class="fa-solid fa-layer-group" aria-hidden="true"></i>
            </span>
            <span class="saintsmedia-accordion-toggle-text">Content</span>
            <span class="saintsmedia-accordion-toggle-chevron" aria-hidden="true">
                <i class="fa-solid fa-chevron-down"></i>
            </span>
        </button>
        <div class="saintsmedia-accordion-panel" id="saintsmedia-accordion-panel" hidden>
            <div class="saintsmedia-accordion-items">
                <?php foreach ($items as $tag_line) : ?>
                    <h2 class="saintsmedia-accordion-item">
                        <i class="fa-solid fa-plus" aria-hidden="true"></i>
                        <span class="saintsmedia-accordion-item-text"><?php echo esc_html($tag_line); ?></span>
                    </h2>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>


<script>
    // saintsmedia accordion behavior
    document.addEventListener('DOMContentLoaded', function() {
        const acc = document.querySelector('.saintsmedia-accordion');
        if (!acc) return;
        const toggle = acc.querySelector('.saintsmedia-accordion-toggle');
        const panel = acc.querySelector('.saintsmedia-accordion-panel');
        if (!toggle || !panel) return;

        // Скрываем содержимое внутри панели для плавного появления
        const items = panel.querySelector('.saintsmedia-accordion-items');
        if (items) {
            items.style.opacity = '0';
            items.style.transition = 'opacity .4s cubic-bezier(.4,0,.2,1)';
        }

        const open = () => {
            panel.hidden = false;
            acc.dataset.open = 'true';
            toggle.setAttribute('aria-expanded', 'true');
            panel.style.height = 'auto';
            const h = panel.clientHeight + 'px';
            panel.style.height = '0px';
            requestAnimationFrame(() => {
                panel.style.transition = 'height .4s cubic-bezier(.4,0,.2,1)';
                panel.style.height = h;
            });
            panel.addEventListener('transitionend', function handler() {
                panel.style.height = 'auto';
                panel.style.transition = '';
                // Плавно показываем содержимое после открытия панели
                if (items) {
                    items.style.opacity = '1';
                }
                panel.removeEventListener('transitionend', handler);
            });
        };

        const close = () => {
            // Плавно скрываем содержимое перед закрытием панели
            if (items) {
                items.style.opacity = '0';
            }
            const h = panel.clientHeight + 'px';
            panel.style.height = h;
            requestAnimationFrame(() => {
                panel.style.transition = 'height .35s cubic-bezier(.4,0,.2,1)';
                panel.style.height = '0px';
            });
            panel.addEventListener('transitionend', function handler() {
                panel.hidden = true;
                panel.style.transition = '';
                acc.dataset.open = 'false';
                toggle.setAttribute('aria-expanded', 'false');
                panel.removeEventListener('transitionend', handler);
            });
        };

        acc.dataset.open = 'false';
        toggle.addEventListener('click', () => {
            const isOpen = acc.dataset.open === 'true';
            if (isOpen) {
                close();
            } else {
                open();
            }
        });
    });
</script>