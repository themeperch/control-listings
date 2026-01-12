<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<ul class="list-group list-group-flush">
    <li class="list-group-item">
        <?php echo wp_kses_post(control_listings_get_icon_svg('ui', 'child')); ?>
        <?php /* translators: %1$s is the minimum age, %2$s is the maximum age. */ printf(
            esc_attr_x('Ages %1$s to %2$s years', 'Listing age minimum to Maximum', 'control-listings'),
            wp_kses_post(get_post_meta( get_the_ID(), 'min_age', true )),
            wp_kses_post(get_post_meta( get_the_ID(), 'max_age', true ))
        ); ?>
    </li>
    <li class="list-group-item">
        <?php echo wp_kses_post(control_listings_get_icon_svg('ui', 'map', 18)); ?>
        <?php echo wp_kses_post(get_post_meta( get_the_ID(), 'address', true )); ?>
    </li>
    <li class="list-group-item">
        <?php echo wp_kses_post(control_listings_get_icon_svg('ui', 'clock', 16)); ?>
        <?php echo wp_kses_post(get_post_meta( get_the_ID(), 'opening_closing_time', true )); ?>
    </li>    
</ul>


