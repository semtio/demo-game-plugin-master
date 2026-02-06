<?php
$complex_slots_showcase = carbon_get_theme_option('complex_slots_showcase');

if (! empty($complex_slots_showcase)) :
?>

<section class="slots-showcase" id="slots-showcase">
    <div class="slots-showcase__grid">
<?php
    foreach ($complex_slots_showcase as $i) :
        $slot_img_attr = saintsmedia_responsive_bg($i['slot_showcase_img'], 'slots-showcase__img', 'medium_large');
?>
        <a class="slots-showcase__card" href="<?php echo esc_url($i['slot_showcase_url']); ?>">
            <figure class="slots-showcase__figure">
                <div <?php echo $slot_img_attr; ?>
                    alt="<?php echo esc_attr(basename($i['slot_showcase_img'])); ?>"
                    loading="lazy"></div>
                <figcaption class="slots-showcase__caption">
                    <div class="slots-showcase__title"><?php echo wp_kses_post($i['slot_showcase_article']); ?></div>
                </figcaption>
            </figure>
        </a>
<?php
    endforeach;
?>
    </div>
</section>
<?php
endif;


?>
