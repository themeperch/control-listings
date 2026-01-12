<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if(empty($images)) return;
?>
<div class="listing-images">
    <h2 class="listing-images-title mb-30"><?php esc_attr_e('Gallery', 'control-listings') ?></h2>
    <div  class="row g-5 popup-gallery" data-masonry='{"percentPosition": true }'>
        <?php foreach ($images as $image): ?>
            <div class="col-6 col-sm-3 listing-image">
                <a class="image-link" href="<?php echo esc_url($image['full']); ?>"><img src="<?php echo esc_url($image['medium']); ?>" alt="<?php echo esc_attr($image['caption']) ?>" class="img-fluid" /></a>
            </div>
        <?php endforeach; ?>
    </div>
</div>