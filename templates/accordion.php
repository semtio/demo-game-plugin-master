<?php
// Получаем данные (предполагается что это массив повторителя Carbon Fields)
$complex_accordion = carbon_get_theme_option('complex_accordion');


?>

<?php if (!empty($complex_accordion) && is_array($complex_accordion)) : ?>
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
                <?php foreach ($complex_accordion as $i) :
                    if (empty($i['accordion_hesh_tags'])) continue;
                    $tag_text = wp_kses_post($i['accordion_hesh_tags']); // допускаем безопасный HTML (если это нужно), иначе esc_html
                ?>
                    <h2 class="saintsmedia-accordion-item">
                        <i class="fa-solid fa-plus"></i>
                        <span class="saintsmedia-accordion-item-text"><?php echo $tag_text; ?></span>
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

        const open = () => {
            panel.hidden = false;
            acc.dataset.open = 'true';
            toggle.setAttribute('aria-expanded', 'true');
            // плавная высота
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
                panel.removeEventListener('transitionend', handler);
            });
        };

        const close = () => {
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