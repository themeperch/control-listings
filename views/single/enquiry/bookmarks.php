<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<div class="bookmarks text-primary d-flex align-self-center gap-15">
    <?php
        printf(
            '<span class="%s" title="%s" %s>%s</span>',
            esc_attr($favourite_class),
            esc_attr($favourite_status),
            // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            implode(' ', $data_attributes),
            wp_kses_post(control_listings_get_icon_svg('ui', esc_attr($favourite_icon), 20))
        );
    ?>  
    <?php
        printf(
            '<span class="%s" title="%s" %s>%s</span>',
            esc_attr($bookmark_class),
            esc_attr($bookmark_status),
            // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            implode(' ', $data_attributes),
            wp_kses_post(control_listings_get_icon_svg('ui', esc_attr($bookmark_icon), 20))
        );
    ?>    
    <a href="#listingSocialShare" class="ctrl-listing-share text-primary" data-id="<?php the_ID() ?>" data-title="tooltip"  data-bs-toggle="modal" title="<?php esc_attr_e('Share listing', 'control-listings') ?>"><?php echo wp_kses_post(control_listings_get_icon_svg('ui', 'share')); ?></a>
</div>