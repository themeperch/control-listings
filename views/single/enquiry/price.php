<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<div class="price-wrapper d-flex gap-10 flex-column flex-md-row align-items-md-center justify-content-md-between">    
    <div class="price text-dark">
    <?php echo wp_kses_post(control_listings_get_price_html()); ?>  
    </div>  
    <?php 
    $buttons = get_post_meta(get_the_ID(), 'buttons'); 
    if(!empty($buttons)){
        foreach ($buttons as $button) {
            if(empty($button['title']) || empty($button['link'])) continue;
            printf('<a href="%s" class="btn btn-primary btn-enquiry">%s%s</a>', esc_url($button['link']), esc_attr($button['title']), wp_kses_post(control_listings_get_icon_svg('ui', 'cart', 24)));
        }
    }
    ?>
</div>

