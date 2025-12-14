<?php
$features = get_post_meta(get_the_ID(), 'features', true);
if(empty($features)) return;
?>
<div class="listing-features border-bottom pb-30">
    <h2 class="listing-tags-title mb-30"><?php esc_attr_e('Key features', 'control-listings') ?></h2>
    <ul class="list-arrow row row-cols-lg-2 gy-20 mb-0">
        <?php
        foreach ($features as $feature) {
            $feature_html = '<span>'.implode('</span><span>', $feature).'</span>';
            control_listings_formated_content($feature_html, '<li class="listing-feature d-flex align-items-center gap-2">', '</li>');
        }
        ?>
    </ul>
</div>