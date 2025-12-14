<?php 
extract(wp_parse_args( $args, [
    'name' => '',
    'title' => '',
    'subtitle' => '',
    'speakers' => [],
    'dots' => [],
    'shadow' => [],
    'separator' => ''  
] ));

?>
<!-- about sec start -->
<section id="speakers" class="listing-speakers speakers-gallery-sec position-relative">
    <div class="container">
        <div class="section-head col-xl-9 m-auto text-center mb-5">
            <?php control_listings_content($name, '<span class="label">', '</span>'); ?>
            <?php control_listings_content($title, '<h1 class="title mb-4">', '</h1>'); ?>
            <?php control_listings_content($subtitle, '<p class="desc mx-3">', '</p>'); ?>       
        </div>

        <?php if(!empty($speakers)): ?>
        <div class="speakers-gallery-items-wrap">
            <div class="row g-4">
                <?php foreach ($speakers as $key => $speaker): 
                    if(empty($speaker['image']['url'])) continue;
                    $speaker = wp_parse_args( $speaker, [
						'name' => '',
						'designation' => '',
						'image' => [],
						'social_links' => []
					] );                    
                    ?>
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <div class="speakers-gallery-item" data-aos="fade-up" data-aos-easing="linear" data-aos-duration="400">
                            <div class="speakers-gallery-item-thumb overflow-hidden position-relative">
                            <img src="<?php echo esc_url($speaker['image']['url']) ?>" alt="<?php echo esc_attr($speaker['name']) ?>">
                            </div>
                            <?php if(!empty($speaker['social_links'])): ?>
                            <div class="">
                                <ul class="social-icons social">
                                    <?php 
                                    foreach ($speaker['social_links'] as $social) {
                                        if(empty($social['icon']['value']) || empty($social['url'])) continue;
                                        echo sprintf('<li><a href="%2$s" target="_blank"><i class="%1$s"></i></a></li>', esc_attr($social['icon']['value']), esc_url($social['url']));
                                    }
                                    ?>
                                 
                                </ul>
                            </div>
                            <?php endif; ?>
                            <div class="item-content">
                                <?php control_listings_content($speaker['name'], '<h3 class="title">', '</h3>'); ?>
                                <?php control_listings_content($speaker['designation'], '<span class="sub">', '</span>'); ?>                            
                            </div>
                        </div>
                    </div>
                
                <?php endforeach; ?>           
                
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