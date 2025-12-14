<?php 
extract(wp_parse_args( $args, [
    'title' => '',
    'subtitle' => '',
    'image' => [],
    'image2' => [],
    'video_url' => '',
    'counter' => [],
    'button_text' => '',
    'button_url' => '',
    // Style
    'about_listing_bg' => [],
    'bg_shape1' => [],
    'bg_shape2' => [],
] ));
$parallax_bg = !empty($about_listing_bg['url'])? ' data-src="'.esc_url( $about_listing_bg['url'] ).'" data-parallax="true"' : '';
?>
<!-- video sec start -->
<section class="about-event video-sec bg-image" data-parallax="true">
    <div class="container">
    <div class="row align-items-center">
        <div class="col-lg-6">
            <div class="video-wrap">
                
                <div class="video-image img-moving-anim1">
                    <img src="<?php echo esc_url($image['url']) ?>" alt="<?php echo esc_attr($title) ?>">
                </div>
                <div class="video-play">
                    <img src="<?php echo esc_url($image2['url']) ?>" alt="<?php echo esc_attr($title) ?>"  data-bs-backdrop="static">
                    <?php if(!empty($video_url)): ?>
                    <a class="video-btn1 popup-video video-link" href="<?php echo esc_url($video_url) ?>"><span><i class="fa fa-play"></i></span></a>
                    <?php endif; ?>
                </div>
                <?php if(!empty($bg_shape1['url'])): ?>
                <div class="dots img-moving-anim2">
                    <img src="<?php echo esc_url($bg_shape1['url']) ?>" alt="<?php esc_attr_e( 'Shadow Image', 'control-listings' ) ?>">
                </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="video-content-wrap">
                <?php control_listings_content($title, '<h2 class="title">', '</h2>'); ?>
                <?php control_listings_content($subtitle, '<p class="desc">', '</p>'); ?>                

                <?php if(!empty($counter)): ?>
                <div class="management d-flex">
                    <?php foreach ($counter as $key => $value):
                        if(empty($value['count']) || empty($value['count_title'])) continue;   
                        ?>
                        <h3 class="event count-block p-lg-5 p-3">
                            <span><?php echo esc_attr($value['count']); ?></span>
                            <?php echo esc_attr($value['count_title']); ?>
                        </h3>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <?php if(!empty($bg_shape2['url'])): ?>
                <div class="dots img-moving-anim3">
                    <img src="<?php echo esc_url($bg_shape2['url']) ?>" alt="<?php esc_attr_e( 'Shadow Image', 'control-listings' ) ?>">
                </div>
                <?php endif; ?>
                <?php if( !empty($button_url) || !empty($button_text) ): ?>
                <a href="<?php echo esc_url($button_url) ?>" class="btn custom-btn2 video-btn"><?php echo esc_attr($button_text) ?></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    </div>
</section>
<!-- video sec end -->