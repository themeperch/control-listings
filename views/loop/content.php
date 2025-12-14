<div class="card card-listing">    
    
    <?php do_action('control_listing_loop_content_start'); ?>

    <div class="card-body">        
        <h3 class="card-title post-title fs-4">
            <a href="<?php the_permalink(); ?>" title="<?php echo get_the_title(); ?>"><?php the_title(); ?></a>
        </h3>    
    
        <?php control_listings_template_part('loop/listing-meta') ?>
        <div class="mt-15 text-muted d-flex flex-wrap justify-content-between">
            <?php do_action('control_listing_loop_content_end'); ?>
        </div>
    </div>
</div>
