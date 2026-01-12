<?php 
$ratings = control_listings_get_ratings_by_type(get_the_ID());
if(empty($ratings)) return;
$count = 0;
?>
<div class="card card-widget single-listing-widget">  
    <ul class="list-group list-group-flush">        
        <?php foreach ($ratings as $rating) : if( !$rating['enable']) continue;  ?>
            <li class="list-group-item d-grid gap-1">    
                <?php if($count < 1): ?>        
                    <h4 class="widget-title mb-15"><?php esc_attr_e('Reviews', 'control-listings'); ?></h4>
                <?php endif; ?>
                <span class="text-uppercase"><?php echo esc_attr($rating['label']) ?></span>                
                <span class="fs-5"><?php echo wp_kses_post(control_listings_get_star_ratings_html($rating['average'])); ?></span>               
            </li>
            <?php $count++; ?>
        <?php endforeach; ?>     
    </ul>
</div>
