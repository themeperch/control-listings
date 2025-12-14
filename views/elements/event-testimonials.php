<?php 
extract(wp_parse_args( $args, [
    'name' => '',
    'title' => '',
    'subtitle' => '',
    'testimonials' => [],
    'dots' => [],
    'shadow' => [],
    'separator' => ''  
] ));

?>
<!-- about sec start -->
<section class="listing-testimonials review-sec position-relative bg-image">
    <div class="container" data-aos="fade-down" data-aos-easing="linear" data-aos-duration="1000">
        <div class="col-10 col-md-10 col-lg-8 col-xl-7 my-5">
            <?php control_listings_content($name, '<span class="label">', '</span>'); ?>
            <?php control_listings_content($title, '<h2 class="review-title">', '</h2>'); ?>
            <?php control_listings_content($subtitle, '<p class="desc mx-3">', '</p>'); ?>       
        </div>

        <?php if(!empty($testimonials)): ?>
        <div class="review-cards-wrap">
            <div class="review-card-items-wrap">
                <?php foreach ($testimonials as $testimonial): 
                    if(empty($testimonial['content'])) continue;
                    $testimonial = wp_parse_args( $testimonial, [
						'name' => '',
						'designation' => '',
						'content' => '',
						'image' => [],
						'ratings' => [],
                        'ratings_desc' => '',
					] );                    
                    ?>
                    <div class="review-card-item">
                        <?php control_listings_content($testimonial['content'], '<p class="card-desc">', '</p>'); ?>
                    
                        <div class="profile">
                            <?php if( !empty($testimonial['image']['url']) ): ?>
                            <div class="thumb">
                                <img src="<?php echo esc_url($testimonial['image']['url']) ?>" alt="<?php echo esc_url($testimonial['name']) ?>">
                            </div>
                            <?php endif; ?>
                            <div class="content">
                                <?php control_listings_content($testimonial['name'], '<h5 class="name">', '</h5>'); ?>
                                <?php control_listings_content($testimonial['designation'], '<span>', '</span>'); ?>
                            </div>
                        </div>
                        <?php if( !empty($testimonial['ratings']) ): ?>
                            <ul class="rating-star list-unstyled d-flex">
                                <?php for ($i=1; $i < $testimonial['ratings']; $i++) { 
                                    echo wp_kses(__('<li class="active"><i class="fas fa-star"></i></li>', 'control-listings'), [
                                        'li' => ['class' => []],
                                        'i' => ['class' => []]
                                    ]);
                                } ?>                             
                            </ul>
                        <?php endif; ?>
                        <?php control_listings_content($testimonial['ratings_desc'], '<span>', '</span>'); ?>
                  </div>
                <?php endforeach; ?>
            </div>
            <div class="carousel-nav">
                <button type="button" class="main-left-arrow"><i class="fas fa-chevron-left"></i></button>
                <button type="button" class="main-right-arrow"><i class="fas fa-chevron-right"></i></button>
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
<div class="container mt-5">
    <hr>
</div>
<?php endif; ?>