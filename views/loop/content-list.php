<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<div class="card card-listing card-list flex-lg-row mb-30">
    
    <?php do_action('control_listing_loop_content_start'); ?>
    <div class="d-flex flex-column overflow-hidden w-100">
        <div class="card-body"> 
            <?php if(get_query_var('view') != 'grid'): ?>
            <div class="listing-categories text-uppercase small p-0 mb-10"><?php control_listings_get_categories(''); ?></div>
            <?php endif; ?> 
            <?php do_action('control_listing_loop_content_body'); ?>    
        </div>
        <div class="card-footer mt-auto text-muted d-flex flex-wrap justify-content-between">
            <?php do_action('control_listing_loop_content_end'); ?>
        </div>
    </div>
</div>
