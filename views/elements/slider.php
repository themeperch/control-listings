<?php 
extract(wp_parse_args( $args, [
    'slides' => []
] ));
if(empty($slides)) return;
$slide_args = [
    'style' => '',
	'align' => '',
    'name' => '',
    'title' => '',
    'subtitle' => '',    
    'action' => '',
    'buttons' => [],
    'video_url' => '',
    // Media
    'media_type' => '',
    'media_image' => [],
    'media_image2' => [],
    'media_video_url' => '',
    // Style
    'about_listing_bg' => [],
    'bg_shape1' => [],
    'bg_shape2' => [],
];
 

?>
<!-- hero sec start -->
<section class="hero-sec"  style="background-image: url(<?php echo get_theme_file_uri( 'assets/images/banner/group.png' ) ?>);">
    <div class="hero-slider-wrap">
        <?php
        foreach ($slides as $key => $slide):           
            extract(wp_parse_args( $slide, $slide_args ), EXTR_OVERWRITE);
            ?>
            <?php ob_start(); ?>
            <?php if($action == 'buttons' && !empty($buttons)): ?>
                <div class="button-group d-inline-flex gap-2<?php control_listings_css_class($align, ' justfy-content-') ?>">
                    <?php 
                    foreach ($buttons as $button) {                        
                        control_listings_button_html($button);                                       
                    }
                    ?>                                        
                </div>
            <?php endif; ?>

            <?php if($action == 'video' && !empty($video_url)): ?>
                <div class="conference-video d-inline-flex">
                    <a href="<?php esc_url($video_url) ?>" class="video-link"><i class="fa fa-play"></i></a>
                </div>
            <?php endif; ?>
            <?php $action_html = ob_get_clean(); ?>

            <?php ob_start(); ?>
            <?php if( $media_type == 'image_group' ): ?>
                <div class="item-image">
                    <?php if(!empty($media_image['url'])):  ?>
                    <div class="img-1 img-moving-anim1">
                        <img src="<?php echo esc_url($media_image['url']); ?>" alt="<?php echo esc_attr($title) ?>">
                    </div>
                    <?php endif; ?>
                    <?php if(!empty($media_image2['url'])):  ?>
                    <div class="img-2 img-moving-anim2">
                        <img src="<?php echo esc_url($media_image2['url']); ?>" alt="<?php echo esc_attr($title) ?>">
                    </div>
                    <?php endif; ?>
                    <img src="<?php echo get_theme_file_uri( 'assets/images/dots/dots2.png' ) ?>" alt="<?php echo esc_attr($name) ?>" class="dots-2 img-moving-anim3">
                </div>
            <?php endif; ?>

            <?php if( $media_type == 'video' && !empty($media_image['url']) ): ?>
                <div class="item-video">
                    <div class="img-3 img-moving-anim1">
                        <img src="<?php echo esc_url($media_image['url']); ?>" alt="<?php echo esc_attr($title) ?>">
                        <?php if(!empty($media_video_url)): ?>
                        <a class="video-link" href="<?php echo esc_url($media_video_url); ?>"><i class="fa fa-play"></i></a>
                        <?php endif; ?>
                    </div>
                </div>
                <img src="<?php echo get_theme_file_uri( 'assets/images/dots/dots2.png' ) ?>" alt="<?php echo esc_attr($name) ?>" class="dots-5 img-moving-anim3">                
            <?php endif; ?>
            <?php $column2_html = ob_get_clean(); ?>

            <?php if($style == 'style1'): ?>
            <div class="hero-slider-item overflow-hidden">
                <div class="container">
                    <div class="row align-items-center">
                        <!-- Column 1 start -->
                        <div class="col-lg-8 col-md-6 order-md-1 order-2">
                            <div class="slider-item-content-wrap">
                                <div class="item-content<?php control_listings_css_class($align, ' text-') ?>">
                                    <?php control_listings_content($title, '<h3 class="item-title1">', '</h3>'); ?>
                                    <?php control_listings_content($subtitle, '<p class="item-sub">', '</p>'); ?>                                    
                                    <?php echo wp_kses_post($action_html); ?>
                                    <img src="<?php echo get_theme_file_uri( 'assets/images/dots/dots.png' ) ?>" alt="<?php echo esc_attr($name) ?>" class="dots-1 opacity-50 img-moving-anim2">
                                </div>
                            </div>
                        </div><!-- Column 1 end -->
                        
                        <!-- Column 2 start -->
                        <div class="col-lg-4 col-md-6 order-md-2 order-1"> 
                            <?php echo wp_kses_post($column2_html); ?>
                        </div>
                        <!-- Column 2 end -->

                    </div>
                    <div class="highlight-text img-moving-anim4">
                        <?php control_listings_content( $name, '<strong class="big-title"><span class="text">', '</span></strong>' ); ?>
                    </div>
                    
                </div>
            </div>
            <?php endif; ?>
            
            <?php if($style == 'style2'): ?>
            <div class="hero-slider-item overflow-hidden">
                  <div class="container position-relative">
                     <div class="row align-items-center slide-2">
                        <div class="<?php control_listings_css_class($align, 'text-') ?>">
                           <div class="slider-item-content-wrap">
                              <div class="item-content2">
                                    <?php control_listings_content($title, '<h3 class="item-title2">', '</h3>'); ?>
                                    <?php control_listings_content($subtitle, '<p class="item-sub">', '</p>'); ?>
                                    
                                    <?php echo wp_kses_post($action_html); ?>
                                    <div class="highlight-text2 img-moving-anim4">
                                        <?php control_listings_content( $name, '<strong class="big-title"><span class="text">', '</span></strong>' ); ?>
                                    </div>
                                    <?php echo wp_kses_post($column2_html); ?>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="dots">
                        <img src="<?php echo get_theme_file_uri( 'assets/images/dots/dots2.png' ) ?>" alt="<?php echo esc_attr($name) ?>" class="dots-4 img-moving-anim2">
                     </div>
                  </div>
                  <img src="<?php echo get_theme_file_uri( 'assets/images/dots/dots5.png' ) ?>" alt="<?php echo esc_attr($name) ?>" class="dots-3 img-moving-anim3">
               </div>
            <?php endif; ?>   

            <?php if($style == 'style3'): ?>
                <div class="hero-slider-item overflow-hidden">
                  <div class="container">
                     <div class="row align-items-center slide-3">
                        <div class="col-lg-8 col-md-6 order-md-1 order-2">
                           <div class="slider-item-content-wrap">
                              <div class="item-content<?php control_listings_css_class($align, ' text-') ?>">
                                    <?php control_listings_content($title, '<h3 class="item-title1">', '</h3>'); ?>
                                    <?php control_listings_content($subtitle, '<p class="item-sub">', '</p>'); ?>
                                    
                                    <?php echo wp_kses_post($action_html); ?>
                                 <img src="<?php echo get_theme_file_uri( 'assets/images/dots/dots.png' ) ?>" alt="<?php echo esc_attr($name) ?>" class="dots-1 img-moving-anim3">
                              </div>
                           </div>
                        </div>
                        <div class="col-lg-4 col-md-6 order-md-2 order-1">
                            <?php echo wp_kses_post($column2_html); ?>
                           <img src="<?php echo get_theme_file_uri( 'assets/images/dots/dots2.png' ) ?>" alt="<?php echo esc_attr($name) ?>" class="dots-5 img-moving-anim3">
                        </div>
                     </div>
                     <div class="highlight-text3 img-moving-anim4">
                        <?php control_listings_content( $name, '<strong class="big-title"><span class="text">', '</span></strong>' ); ?>
                     </div>
                  </div>
               </div>
            <?php endif; ?>   

        <?php endforeach; ?>        
    </div>
</section>