<div class="listing-slider-wrapper mx-lg-auto">
    <div class="swiper singleListingSlider">
        <div class="swiper-wrapper">
            <?php  foreach ($gallery as $key => $value) : 
                $value = wp_parse_args($value, [
                    'image' => '',
                    'title' => '',
                    'desc' => '',
                ]);
                ?>
                <div class="swiper-slide bg-dark">
                    <img src="<?php echo esc_url($value['image']) ?>" alt="<?php echo esc_attr($value['title']) ?>" class="single-listing-gallery-image" />
                    <div class="slide-caption align-items-end h-100">
                        <div class="d-grid p-50 text-white">
                            <?php control_listings_formated_content($value['title'], '<h2>', '</h2>') ; ?>
                            <?php control_listings_formated_content($value['desc'], '<p class="mb-0">', '</p>') ; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="swiper-button swiper-button-next"></div>
        <div class="swiper-button swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
    </div>
</div>