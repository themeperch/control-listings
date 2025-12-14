<?php 
get_header(); 
    do_action('control_listing_single_content_before');
    ?>
    <div class="row gx-50">
        <div class="col-lg-8">
            <div class="d-grid gap-50 pt-50">
            <?php
            do_action('control_listing_single_loop_start');
            /* Start the Loop */
            while ( have_posts() ) :
                the_post(); 
                do_action('control_listing_single_loop_content');                       
            endwhile; 
            do_action('control_listing_single_loop_end');
            ?>
            </div>
        </div>
        <div class="col-lg-4">
            <div id="sidebar" class="widget-area d-grid gap-30">
                <?php do_action('control_listing_single_content_sidebar'); ?>
            </div>
        </div>
    </div>
    <?php
    do_action('control_listing_single_content_after');    
get_footer(); 
?>
