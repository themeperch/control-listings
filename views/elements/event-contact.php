<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
extract(wp_parse_args( $args, [
    'name' => '',
    'title' => '',
    'subtitle' => '',
    'contact_form' => '',
    'contact_info_title' => '',
    'contact_info_subtitle' => '',
    'contact_info' => [],
    'dots' => [],
    'dots2' => [],
    'shadow' => [],
    'separator' => ''  
] ));
?>
<!-- about sec start -->
<section class="listing-contact contact-sec position-relative bg-image" data-aos="zoom-in" data-aos-duration="1000">
    <div class="container">
        
        <div class="col-xl-5 section-head text-center m-auto mb-5">
            <?php control_listings_content($name, '<span class="label">', '</span>'); ?>
            <?php control_listings_content($title, '<h2 class="title mx-2">', '</h2>'); ?>
            <?php control_listings_content($subtitle, '<p class="desc mt-3 mb-5">', '</p>'); ?>
        </div>

        <div class="contact-wrap bg-none p-0">
            <?php if( !empty($dots['url']) ): ?>
            <div class="dots">
                <img class="contact-dots-1 img-moving-anim2" src="<?php echo esc_url($dots['url']) ?>" alt="<?php esc_attr_e( 'Shape Images', 'control-listings' ) ?>">
            </div>
            <?php endif; ?>
            
            <div class="contact-wrap row py-4 px-3 contact align-items-center m-0">
                <div class="col-lg-4">
                    <div class="contact-thumb-wrap">
                    <div class="contact-content">
                        <?php control_listings_content($contact_info_title, '<h5 class="title text-white">', '</h5>'); ?>
                        <?php control_listings_content($contact_info_subtitle, '<p class="desc">', '</p>'); ?>
                        <?php if( !empty($contact_info) ): ?>
                        <div class="info">
                            <?php foreach ($contact_info as $key => $info) :
                                if(empty($info['title'])) continue;
                                $info = wp_parse_args( $info, [
                                    'type' => '',
                                    'title' => '',
                                    'icon' => [],
                                    'address' => ''
                                ] );
                                $link_url = '';
                                if($info['type'] == 'email'){
                                    $link_url = 'mailto:'.esc_attr($info['title']);
                                }
                                if($info['type'] == 'phone'){
                                    $link_url = 'tel:'.esc_attr($info['title']);
                                }
                                if($info['type'] == 'address'){
                                    $link_url = $info['address'];
                                }
                                ?>
                                <a class="icon d-block mb-3" href="<?php echo esc_url($link_url) ?>">
                                    <?php echo !empty($info['icon']['url'])? '<img src="'.esc_url($info['icon']['url']).'" alt="'.esc_attr($info['type']).'">' : '';  ?>
                                    <?php echo wp_kses_post( $info['title'] ); ?> 
                                </a>
                            <?php endforeach; ?>                           
                        </div>
                        <?php endif; ?>
                    </div>
                    </div>
                </div>
                <div class="col-lg-8 mt-4 mt-lg-0">
                    <div class="contact-form">
                        <?php echo do_shortcode($contact_form); ?>
                    </div>
                </div>
            </div> 
            <!-- .row -->
            <?php if( !empty($dots2['url']) ): ?>
            <div class="dots">
                <img class="contact-dots-2 img-moving-anim3" src="<?php echo esc_url($dots['url']) ?>" alt="<?php esc_attr_e( 'Shape Images', 'control-listings' ) ?>">
            </div>
            <?php endif; ?>
        </div>    

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