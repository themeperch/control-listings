<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<h2 class="page-title fs-2"><?php esc_html_e( 'Nothing here', 'control-listings' ); ?></h2>
<?php if ( current_user_can( 'publish_posts' ) && !control_listings_count_posts_published() ) : ?>

<?php
printf(
    '<p>' . wp_kses(
        /* translators: %s: Link to WP admin new post page. */
        __( 'Ready to publish your first listing? <a href="%s">Get started here</a>.', 'control-listings' ),
        array(
            'a' => array(
                'href' => array(),
            ),
        )
    ) . '</p>',
    esc_url( admin_url( 'post-new.php?post_type=ctrl_listings' ) )
);
else: ?>
<p class="no-listing">
    <?php esc_attr_e('No listings found.', 'control-listings'); ?>
    
</p>
<?php endif; ?>