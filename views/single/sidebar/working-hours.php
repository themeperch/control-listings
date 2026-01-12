<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
$opening_hours = get_post_meta(get_the_ID(), 'opening_hours', true);
if($opening_hours != 'business_hour') return;
$working_hours = get_post_meta(get_the_ID(), 'working_hours');
if(empty($working_hours)) return;
$count = 0;
?>
<div class="card card-widget single-listing-widget">  
    <ul class="list-group list-group-flush">
        <?php foreach ($working_hours as $working_hour) :  ?>
            <li class="list-group-item d-grid">    
                <?php if($count < 1): ?>        
                    <h4 class="widget-title mb-20"><?php esc_attr_e('Opening Times', 'control-listings') ?></h4>
                <?php endif; ?>
                <span class="text-uppercase"><?php echo esc_attr($working_hour['day']) ?></span>
                <p class="mb-0">
                <?php
                if(!empty($working_hour['closed']) && $working_hour['closed']){
                    esc_attr_e('Closed', 'control-listings');
                }else{
                    printf(
                        '%s - %s',
                        // phpcs:ignore WordPress.DateTime.RestrictedFunctions.date_date
                        esc_html( date( 'g:i A', strtotime( $working_hour['start_time'] ) ) ),
                        // phpcs:ignore WordPress.DateTime.RestrictedFunctions.date_date
                        esc_html( date( 'g:i A', strtotime( $working_hour['end_time'] ) ) )
                    );
                }
                ?>
                </p>
            </li>
            <?php $count++; ?>
        <?php endforeach; ?>       
    </ul>
</div>
