<ul class="list-group list-group-flush">
    <li class="list-group-item">
        <?php echo control_listings_get_icon_svg('ui', 'child'); ?>
        <?php printf(
            esc_attr_x('Ages %s to %s years', 'Listing age minimum to Maximum', 'control-linstings'),
            get_post_meta( get_the_ID(), 'min_age', true ),
            get_post_meta( get_the_ID(), 'max_age', true )
        ); ?>
    </li>
    <li class="list-group-item">
        <?php echo control_listings_get_icon_svg('ui', 'map', 18); ?>
        <?php echo get_post_meta( get_the_ID(), 'address', true ); ?>
    </li>
    <li class="list-group-item">
        <?php echo control_listings_get_icon_svg('ui', 'clock', 16); ?>
        <?php echo get_post_meta( get_the_ID(), 'opening_closing_time', true ); ?>
    </li>    
</ul>


