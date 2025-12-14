<?php 
get_header(); 
    do_action('control_listing_content_before');
    if(have_posts()):
        do_action('control_listing_loop_start');    
        /* Start the Loop */
        while ( have_posts() ) :
            the_post(); 
            do_action('control_listing_loop_content');           
        endwhile;
        do_action('control_listing_loop_end');
        
    else:    
        do_action('control_listing_loop_no_results');
    endif;
    
    do_action('control_listing_content_after');    
get_footer(); 
?>
