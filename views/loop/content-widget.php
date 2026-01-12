<div class="listing-widget d-flex gap-15">
    
   <?php  if(has_post_thumbnail()) : ?>
    <div class="d-inline-flex flex-shrink-0">
        <img width="80" height="80" src="<?php echo esc_url(get_the_post_thumbnail_url(null, 'thumbnail')) ?>" alt="<?php the_title() ?>" /> 
    </div>
   <?php endif; ?>
    <div class="listing-widget-content">
        <?php the_title('<h6 class="listing-title"><a class="stretched-link" href="'.get_permalink().'">', '</a></h6>') ?>
        <div class="listing-price">
            <?php echo wp_kses_post(control_listings_get_price_html()); ?>
            <?php echo wp_kses_post(control_listings_get_average_ratings_html(get_the_ID(), true)); ?>
        </div>
    </div>
</div>
