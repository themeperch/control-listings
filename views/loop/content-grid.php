<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<div class="col">
    <div class="card card-listing card-grid mb-30">    
        
        <?php do_action('control_listing_loop_content_start'); ?>

        <div class="card-body">        
            <?php do_action('control_listing_loop_content_body'); ?>            
        </div>
        <div class="card-footer text-muted d-flex flex-wrap justify-content-between">
            <?php do_action('control_listing_loop_content_end'); ?>
        </div>
    </div>
</div>
