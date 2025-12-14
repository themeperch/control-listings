<?php
if(empty($videos)) return;
$count = 0;
?>
<div class="listing-videos">
    <h2 class="listing-videos-title mb-30"><?php esc_attr_e('Video', 'control-listings') ?></h2>
    <div id="carouselListingVideos" class="carousel slide">
        <div class="carousel-inner">
            <?php foreach ($videos as $video): 
                $active_class = $count == 0 ? ' active' : '';
                ?>
                <div class="carousel-item shadow-bottom<?php echo esc_attr(($active_class)) ?>">
                    <img src="<?php echo esc_url($video['thumbnail']); ?>" alt="<?php echo esc_attr($video['title']) ?>" class="img-fluid" />
                    <a class="popup-video position-absolute start-0 top-50 w-100 text-center mt-n30" href="<?php echo esc_url($video['link']); ?>">
                        <?php echo control_listings_get_icon_svg('ui', 'play', 60); ?>
                    </a> 
                    <div class="carousel-caption d-none d-md-block text-white">
                        <?php control_listings_formated_content($video['title'], '<h5>', '</h5>'); ?>
                        <?php control_listings_formated_content($video['desc'], '<p>', '</p>'); ?>
                    </div>
   
                </div>        
            <?php 
            $count++;
            endforeach; ?>
        </div>
        <?php if(count($videos) > 1): ?>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselListingVideos" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselListingVideos" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>

        <?php endif; ?>    
    </div>
</div>