<?php 
extract(wp_parse_args( $args, [
    'name' => '',
    'title' => '',
    'subtitle' => '',
    'videos' => [],
    'dots' => [],
    'shadow' => [],
    'separator' => ''  
] ));

?>
<!-- about sec start -->
<section id="about" class="listing-videos about-sec">
    <div class="container">
        <div class="section-head col-xl-9 m-auto text-center mb-5">
            <?php control_listings_content($name, '<span class="label">', '</span>'); ?>
            <?php control_listings_content($title, '<h1 class="title mb-4">', '</h1>'); ?>
            <?php control_listings_content($subtitle, '<p class="desc mx-3">', '</p>'); ?>       
        </div>

        <?php if(!empty($videos)): ?>
        <div class="about-items-wrap" data-aos="fade-right" data-aos-duration="1000">
            <div class="row g-4">
                <?php foreach ($videos as $key => $video): 
                    if(empty($video['image']['url'])) continue;
                    $video = wp_parse_args( $video, [
						'date' => '',
						'title' => '',
						'video_url' => '',
						'image' => [],
						'size' => ''
					] );                    
                    ?>
                <div class="col <?php echo esc_attr($video['size']) ?>" data-aos="fade-right" data-aos-duration="800">
                    <div class="about-item">
                    <div class="item-thumb">
                        <img src="<?php echo esc_url($video['image']['url']) ?>" alt="<?php echo esc_attr($video['title']) ?>">
                        <div class="item-content">
                            <div class="content-title text-white">
                                <?php control_listings_content($video['date'], '<span class="date">', '</span>'); ?>
                                <?php control_listings_content($video['title'], '<h5 class="title text-white">', '</h5>'); ?>
                            </div>
                            <?php if(!empty($video['video_url'])): ?>
                            <div class="about-video">
                                <a class="video-btn1 popup-video video-link" href="<?php echo esc_url($video['video_url']) ?>"><span><i class="fa fa-play"></i></span></a>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>      
                    </div>
                </div>
                <?php endforeach; ?>
               
                <?php if( !empty($dots['url']) ): ?>
                <div class="dots img-moving-anim5">
                    <img src="<?php echo esc_url($dots['url']) ?>" alt="<?php esc_attr_e( 'Shape Images', 'control-listings' ) ?>">
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
    <?php if( !empty($shadow['url']) ): ?>
    <div class="shape"><img src="<?php echo esc_url($shadow['url']) ?>" alt="<?php esc_attr_e( 'Shadow', 'control-listings' ) ?>"></div>
    <?php endif; ?>
</section>
<!-- about sec end -->
<?php if( !empty($separator) && ($separator == 'yes') ): ?>
<div class="container mt-5">
    <hr>
</div>
<?php endif; ?>