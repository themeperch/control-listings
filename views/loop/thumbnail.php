<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php if( has_post_thumbnail() ): ?>
    <div class="card-img-wrap position-relative">
        <?php the_post_thumbnail( $thumbnail_size , ['class' => 'card-img-top listing-image']); ?>
        <?php if(get_query_var('view') != 'list'): ?>
        <div class="card-img-top-content listing-categories small text-uppercase position-absolute start-0 bottom-0"><?php control_listings_get_categories(''); ?></div>
        <?php endif; ?>
        <?php  if(is_sticky()): ?>
            <div class="listing-categories small text-uppercase position-absolute start-0 top-0"><span class="badge text-bg-secondary d-inline-flex gap-1 align-items-center"><?php echo wp_kses_post(control_listings_get_icon_svg('ui', 'star-fill', 12)) ?> Featured</span></div>
        <?php endif; ?>
    </div>
<?php endif; ?>