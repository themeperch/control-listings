<?php
if(empty($awards)) return;
?>
<div class="listing-awards">
    <h2 class="listing-awards-title mb-30"><?php esc_attr_e('Awards', 'control-listings') ?></h2>
    <div class="d-grid gap-30">
        <?php foreach ($awards as $award): ?>            
            <div class="listing-award border-bottom pb-30">
                <div class="row gy-10">
                    <div class="col-lg-4">
                        <img src="<?php echo control_listings_get_attachment_url($award['image']); ?>" alt="<?php echo esc_attr($award['title']) ?>" width="300" class="img-fluid border" />
                    </div>
                    <div class="col-lg-8 award-details d-flex flex-column">
                        <?php control_listings_formated_content($award['title'], '<h5 class="award-title mb-0">', '</h5>') ?>
                        <?php control_listings_formated_content($award['year'], '<p class="award-year">', '</p>') ?>
                        <?php control_listings_formated_content($award['desc'], '<p class="award-desc">', '</p>') ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>