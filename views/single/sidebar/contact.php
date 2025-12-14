<?php 
if(empty($shortcode)) return;
?>
<div class="card card-widget single-listing-widget">  
    <div class="card-body widget">
        <h4 class="widget-title mb-15"><?php esc_attr_e('Contact us', 'control-listings'); ?></h4>
        <?php echo do_shortcode($shortcode); ?>
    </div>
</div>