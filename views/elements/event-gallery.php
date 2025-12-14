<?php 
extract(wp_parse_args( $args, [
    'name' => '',
    'title' => '',
    'subtitle' => '',
    'hover_text' => '',
    'gallery' => [],
    'dots' => [],
    'shadow' => [],
    'separator' => ''  
] ));
?>
<!-- about sec start -->
<section class="listing-gallery gallery-sec position-relative bg-image" data-aos="fade-up" data-aos-duration="1200">
    <div class="container-fluid">
        
        <div class="col-xl-8 section-head text-center m-auto mb-5">
            <?php control_listings_content($name, '<span class="label">', '</span>'); ?>
            <?php control_listings_content($title, '<h2 class="title">', '</h2>'); ?>
            <?php control_listings_content($subtitle, '<p class="desc mt-3 mb-5">', '</p>'); ?>
        </div>

        <?php if(!empty($gallery)): ?>
        <div class="image-gallery-wrap zoom-gallery d-flex align-items-center">
            <div class="row g-4">
                
                    <?php foreach ($gallery as $key => $single_image): 
                        $single_image = wp_parse_args($single_image, [
                            'title' => '',
                            'image' => [],
                            'popup' => '',
                            'full_image' => [],
                            'video' => '',
                        ]);
                        if(empty($single_image['image']['url'])) continue;   
                        $extra_class = ' image-link';
                        $thumb_image = $popup_link = $single_image['image']['url'];     
                        if( !empty($single_image['popup']) && $single_image['popup'] == 'image' ){
                            $popup_link = !empty($single_image['full_image']['url'])? $single_image['full_image']['url'] : $popup_link;
                        }  
                        if( !empty($single_image['popup']) && $single_image['popup'] == 'video' ){                            
                            $popup_link = !empty($single_image['video'])? $single_image['video'] : $popup_link;
                            $extra_class = !empty($single_image['video'])? ' video-link' : $extra_class;
                        }                                
                        ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="image-gallery-item" data-aos="fade-up" data-aos-duration="1000">
                                <a class="item-thumb<?php echo esc_attr($extra_class) ?>" href="<?php echo esc_url($popup_link) ?>">
                                    <img src="<?php echo esc_url($thumb_image) ?>" alt="<?php echo esc_attr($single_image['title']); ?>"> 
                                    <span class="view"><?php echo esc_attr($hover_text) ?></span>
                                </a>
                                
                            </div>
                        </div>
                    
                    <?php endforeach; ?>
                </div>    
            </div>
            
            <?php if( !empty($dots['url']) ): ?>
            <div class="dots img-moving-anim1">
                <img src="<?php echo esc_url($dots['url']) ?>" alt="<?php esc_attr_e( 'Shape Images', 'control-listings' ) ?>">
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>
            
    </div>
    <?php if( !empty($shadow['url']) ): ?>
    <div class="shape"><img src="<?php echo esc_url($shadow['url']) ?>" alt="<?php esc_attr_e( 'Shadow', 'control-listings' ) ?>"></div>
    <?php endif; ?>
</section>
<!-- about sec end -->
<?php if( !empty($separator) && ($separator == 'yes') ): ?>
<div class="container">
    <hr>
</div>
<?php endif; ?>