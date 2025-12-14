<div class="bookmarks d-flex align-self-end text-primary gap-15">
    <?php
        printf(
            '<span class="%s" title="%s" %s>%s</span>',
            esc_attr($favourite_class),
            esc_attr($favourite_status),
            implode(' ', $data_attributes),
            control_listings_get_icon_svg('ui', esc_attr($favourite_icon), 20)
        );
    ?>  
    <?php
        printf(
            '<span class="%s" title="%s" %s>%s</span>',
            esc_attr($bookmark_class),
            esc_attr($bookmark_status),
            implode(' ', $data_attributes),
            control_listings_get_icon_svg('ui', esc_attr($bookmark_icon), 20)
        );
    ?>    
    <a href="#listingSocialShare" class="ctrl-listing-share text-primary" data-id="<?php the_ID() ?>" data-title="tooltip"  data-bs-toggle="modal" title="<?php esc_attr_e('Share listing', 'control-listings') ?>"><?php echo control_listings_get_icon_svg('ui', 'share'); ?></a>
</div>