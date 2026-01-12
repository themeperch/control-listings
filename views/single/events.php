<?php
if(empty($events)) return;
$count = 1;
?>
<div class="listing-events">
    <h2 class="listing-events-title mb-30"><?php esc_attr_e('Upcoming Events', 'control-listings') ?></h2>
    <div class="d-grid gap-30">
        <?php foreach ($events as $event): 
            /* translators: %1$s is the event start date and time, %2$s is the event end date and time. */
            $event_date = sprintf(esc_attr_x('at %1$s to %2$s', 'Event start to end date', 'control-listings'), 
            // phpcs:ignore WordPress.DateTime.RestrictedFunctions.date_date
            date("F j, Y g:i A", strtotime($event['start_date'])),
            // phpcs:ignore WordPress.DateTime.RestrictedFunctions.date_date
            date("F j, Y g:i A", strtotime($event['end_date'])),
        );
            $meta = [
                $event['location'],
                $event_date
            ];
            $content = nl2br($event['desc']);
            if(!empty($event['link']) && !empty($event['link_text'])){
                $content .= ' <a href="'.esc_url($event['link']).'" target="_blank">'.esc_attr($event['link_text']).'</a>';
            }
            ?>
            <div class="listing-event<?php echo (count($events) != $count)? ' border-bottom pb-30' : '' ?>">
                <div class="row gy-15 gy-lg-0">
                    <div class="col-lg-4">
                        <img src="<?php echo esc_url(control_listings_get_attachment_url($event['image'])); ?>" alt="<?php echo esc_attr($event['title']) ?>" width="300" class="img-fluid border" />
                    </div>
                    <div class="col-lg-8 event-details d-grid">
                        <?php control_listings_formated_content($event['title'], '<h5 class="event-title mb-0">', '</h5>') ?>
                        <?php control_listings_formated_content(implode(' </span><span>', $meta), '<p class="event-location text-muted"><span>', '</span></p>') ?>
                        <?php control_listings_formated_content( $content, '<p class="event-desc">', '</p>') ?>
                    </div>
                </div>
            </div>
        <?php $count++; endforeach; ?>
    </div>
</div>