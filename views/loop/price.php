<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<div class="price text-dark align-self-center">    
    <?php echo wp_kses_post(control_listings_get_price_html()); ?>  
    <div class="fs-6"><?php echo wp_kses_post(control_listings_get_average_ratings_html(get_the_ID(), true)); ?></div>  
</div>