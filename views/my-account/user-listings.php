<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<table class="table">
    <tr>
        <?php
        
        if ( in_array( 'title', $columns ) ) {
            echo '<th>', esc_html( $label_title ), '</th>';
        }
        if ( in_array( 'date', $columns ) ) {
            echo '<th>', esc_html( $label_date ), '</th>';
        }
        if ( in_array( 'status', $columns ) ) {
            echo '<th>', esc_html( $label_status ), '</th>';
        }
        ?>
        <th><?php echo esc_html( $label_actions ) ?></th>
    </tr>
    <?php
    while ( $user->have_posts() ) :
        $user->the_post();
        ?>
        <tr>
            <?php if ( in_array( 'title', $columns ) ) : ?>
                <?php
                if ( $title_link === 'edit' ) {
                    $title_link = add_query_arg( 'listings_frontend_post_id', get_the_ID(), $edit_page_atts['url'] );
                } else {
                    $title_link = get_the_permalink();
                }
                $title = '<a href="' . esc_url( $title_link ) . '" target="_blank">' . get_the_title() . '</a>';
                // filter the title links
                $title = apply_filters( 'mbfs_dashboard_post_title', $title, get_the_ID() );
                $title = apply_filters( 'rwmb_frontend_dashboard_post_title', $title, get_the_ID() );
                ?>
                <td>
                    <div class="d-flex align-items-start gap-2">
                    <?php  
                    if(has_post_thumbnail()){
                        echo '<img src="'.esc_url(get_the_post_thumbnail_url(get_the_ID(), 'thumbnail')).'" width="40" height="40" class="rounded" alt="">';
                    }
                    ?>
                    <?php echo wp_kses_post($title); ?>
                    </div>
                </td>
            <?php endif; ?>

            <?php if ( in_array( 'date', $columns ) ) : ?>
                <td><?php the_time( get_option( 'date_format' ) ) ?></td>
            <?php endif; ?>

            <?php if ( in_array( 'status', $columns ) ) : ?>
                <td><?php echo esc_attr(get_post_status_object( get_post_status() )->label) ?></td>
            <?php endif; ?>

            <td class="mbfs-actions">
                <div class="d-flex">
                <?php
                    if( current_user_can('administrator') ){
                        echo '<a href="' . esc_url( add_query_arg( 'listings_frontend_post_id', get_the_ID(), $edit_page_atts['url'] ) ) . '" title="' . esc_html( 'Edit', 'control-listings' ) . '"><img src="' . esc_url(MBFS_URL . 'assets/pencil.svg') . '"></a>';
                    }else{
                        echo (get_post_status() != 'pending')? '<a href="' . esc_url( add_query_arg( 'listings_frontend_post_id', get_the_ID(), $edit_page_atts['url'] ) ) . '" title="' . esc_html( 'Edit', 'control-listings' ) . '"><img src="' . esc_url(MBFS_URL . 'assets/pencil.svg') . '"></a>' : '<a class="text-white" href="#" title="' . esc_html( 'Reviewing', 'control-listings' ) . '">' . wp_kses_post(control_listings_get_icon_svg('ui', 'clock')) . '</a>';
                    }
                                       
               
                    echo do_shortcode( '[mb_frontend_form id="' . $edit_page_atts['id'] . '" post_id="' . get_the_ID() . '" ajax="true" allow_delete="true" force_delete="true" only_delete="true" delete_button="<img src=\'' . MBFS_URL . 'assets/trash.svg' . '\'>"]' );
               
                ?>
                </div>
            </td>
        </tr>
    <?php endwhile ?>
</table>