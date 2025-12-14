<ul class="list-unstyled d-flex flex-wrap gap-15 border-top py-15 mb-0">
    <li class="d-inline-flex gap-5 align-items-center">
        <span class="text-primary"><?php echo control_listings_get_icon_svg('ui', 'map', 16); ?></span>
        <?php echo get_post_meta( get_the_ID(), 'address', true ); ?>
    </li>
    <li class="d-inline-flex gap-5 align-items-center">
        <span class="text-primary"><?php echo control_listings_get_icon_svg('ui', 'child', 20); ?></span>
        <?php printf(
            esc_attr_x('Ages %s to %s years', 'Listing age minimum to Maximum', 'control-linstings'),
            get_post_meta( get_the_ID(), 'min_age', true ),
            get_post_meta( get_the_ID(), 'max_age', true )
        ); ?>
    </li>
    
    <li class="d-inline-flex gap-5 align-items-center">
    <span class="text-primary"><?php echo control_listings_get_icon_svg('ui', 'clock', 16); ?></span>
        <?php echo get_post_meta( get_the_ID(), 'opening_closing_time', true ); ?>
    </li>    
</ul>