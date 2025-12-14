<div class="d-flex gap-10">
    <span class="text-small text-showing">
        <?php
        // phpcs:disable WordPress.Security
        if ( 1 === intval( $total ) ) {
            _e( 'Showing the single result', 'control-listings' );
        } elseif ( $total <= $per_page || -1 === $per_page ) {
            /* translators: %d: total results */
            printf( _n( 'Showing all %s result', 'Showing all %s results', $total, 'control-listings' ), '<strong>'.$total.'</strong>' );
        } else {
            $first = ( $per_page * $current_page ) - $per_page + 1;
            $last  = min( $total, $per_page * $current_page );
            /* translators: 1: first result 2: last result 3: total results */
            printf( _nx( 'Showing %1$s&ndash;%2$s of %3$s result', 'Showing %1$s&ndash;%2$s of %3$s results', $total, 'with first and last result', 'control-listings' ), '<strong>'.$first.'</strong>', '<strong>'.$last.'</strong>', '<strong>'.$total.'</strong>' );
        }
        // phpcs:enable WordPress.Security
        ?>
    </span>  
    <?php if(get_query_var('view') != 'map'): ?>
    <a class="advanced-filter text-heading text-decoration-underline" data-bs-toggle="offcanvas" href="#listingAdvancedSearch"><?php esc_attr_e('Filter results', 'control-listings') ?></a>  
    <?php endif; ?>
    <?php if( !empty(control_listings_option('ctrl_listings_display_view_switch')) ): ?>
    <a class="text-heading text-decoration-underline" href="<?php echo add_query_arg('view', get_query_var('view') == 'map'? 'grid' : 'map'); ?>"><?php echo get_query_var('view') == 'map'? __('Classic view', 'control-listings') : __('Map view', 'control-listings') ?></a>
    <?php endif; ?>
</div>