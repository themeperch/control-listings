<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
extract(wp_parse_args( $args, [
    'name' => '',
    'title' => '',
    'subtitle' => '',
    'pricing_tables' => [],
    'dots' => [],
    'shadow' => [],
    'separator' => ''  
] ));

?>
<!-- about sec start -->
<section id="pricing" class="listing-pricing-tables pricing-sec position-relative bg-image">
    <div class="container" data-aos="fade-down" data-aos-easing="linear" data-aos-duration="1000">
        <div class="section-head col-xl-8 m-auto text-center px-5">
            <?php control_listings_content($name, '<span class="label">', '</span>'); ?>
            <?php control_listings_content($title, '<h2 class="title mb-4">', '</h2>'); ?>
            <?php control_listings_content($subtitle, '<p class="desc mb-5">', '</p>'); ?>       
        </div>

        <?php if(!empty($pricing_tables)): ?>
        <div class="pricing-cart-wrap">
            <div class="row row-cols-1 row-cols-lg-3 g-4">
                <?php foreach ($pricing_tables as $pricing_table): 
                    $pricing_table = wp_parse_args( $pricing_table, [
						'name' => '',
						'price' => '',
						'duration' => '',
						'features' => [],
						'footer_desc' => '',
						'button_text' => '',
						'button_link' => '',
					] );                    
                    ?>
                    <div class="col col-md-6 col-lg-4">
                        <div class="card  h-100" data-aos="flip-left" data-aos-easing="ease-out-cubic" data-aos-duration="2000">
                            <div class="card-body">
                                <?php control_listings_content($pricing_table['name'], '<span class="card-lable"><i class="fa-sharp fas fa-circle"></i>', '</span>'); ?>
                                <h3 class="price-pacage">
                                    <?php echo esc_attr($pricing_table['price']) ?> 
                                    <?php control_listings_content($pricing_table['duration'], '<span class="regular-price">', '</span>'); ?>
                                </h3>
                                <?php if( !empty($pricing_table['features']) ): ?>
                                    <ul>
                                        <?php foreach ($pricing_table['features'] as $feature): if(empty($feature['title'])) continue; ?>
                                            <li<?php echo (isset($feature['enable']) && ($feature['enable'] != 'yes'))? ' class="text-muted"' : ''; ?>>
                                                <?php control_listings_content($feature['title'], '<i class="fas fa-check"></i>'); ?>
                                                <?php !empty($feature['desc'])? control_listings_content($feature['desc'], '<small>', '</small>') : ''; ?>                                               
                                            </li>
                                        <?php endforeach; ?>                                       
                                    </ul>
                                <?php endif; ?>    
                                <div class="card-btn">
                                    <?php if( !empty($pricing_table['button_text']) || !empty($pricing_table['button_link']) ): ?>
                                        <a href="<?php echo esc_url($pricing_table['button_link']); ?>" class="btn custom-btn custom-btn2 mb-3"><?php echo esc_attr($pricing_table['button_text']); ?></a>
                                    <?php endif; ?>    
                                    <?php control_listings_content($pricing_table['footer_desc'], '<span class="card-footer-label">', '</span>'); ?>
                                </div>
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
<div class="container">
    <hr>
</div>
<?php endif; ?>
<!-- pricing sec end -->