<ul class="enquiry-contact list-unstyled d-flex flex-wrap justify-content-space-between gap-15 gap-lg-30 pt-15 mb-0">
    <li class="d-inline-flex gap-5 align-items-center">
        <span class="text-primary"><?php echo wp_kses_post(control_listings_get_icon_svg('ui', 'phone', 16)); ?></span>
        <?php printf('<a href="tel:%1$s">%1$s</a>', esc_attr(get_post_meta( get_the_ID(), 'phone', true ))); ?>
    </li>
    <li class="d-inline-flex gap-5 align-items-center">
        <span class="text-primary"><?php echo wp_kses_post(control_listings_get_icon_svg('ui', 'printer', 16)); ?></span>
        <?php printf('<a href="tel:%1$s">%1$s</a>', esc_attr(get_post_meta( get_the_ID(), 'fax', true )))   ; ?>
    </li>
    <li class="d-inline-flex gap-5 align-items-center">
        <span class="text-primary"><?php echo wp_kses_post(control_listings_get_icon_svg('ui', 'mail', 16)); ?></span>
        <?php printf('<a href="mailto:%1$s">%1$s</a>', esc_attr(get_post_meta( get_the_ID(), 'email', true ))); ?>
    </li>
    <li class="d-inline-flex gap-5 align-items-center">
        <span class="text-primary"><?php echo wp_kses_post(control_listings_get_icon_svg('ui', 'globe', 16)); ?></span>
        <?php printf('<a href="%1$s" target="_blank">%1$s</a>', esc_attr(get_post_meta( get_the_ID(), 'website', true ))); ?>
    </li> 
</ul>