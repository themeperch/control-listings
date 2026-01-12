<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
extract(wp_parse_args( $args, [
    'name' => '',
    'title' => '',
    'subtitle' => '',
    'button_text' => '',
    'button_link' => '',
    'faqs' => [],
    'dots' => [],
    'shadow' => [],
    'separator' => ''  
] ));
$uniqueID = uniqid();
?>
<!-- about sec start -->
<section class="listing-faqs faq-sec position-relative bg-image">
    <div class="container">
        <div class="row align-items-end">
            <div class="col-lg-6 mb-5 mb-lg-0" data-aos="fade-right" data-aos-duration="1000">
                <?php control_listings_content($name, '<span class="label">', '</span>'); ?>
                <?php control_listings_content($title, '<h2 class="title mb-3">', '</h2>'); ?>
                <?php control_listings_content($subtitle, '<p class="desc mb-5">', '</p>'); ?>     
                <?php if( !empty($button_text) || !empty($button_link) ): ?>
                <a href="<?php echo esc_url($button_link) ?>" class="btn faq-btn custom-btn"><?php echo esc_attr($button_text) ?></a>  
                <?php endif; ?>
            </div>

            <?php if(!empty($faqs)): ?>
            <div class="col-lg-6" data-aos="fade-left" data-aos-duration="1000">
                <div class="question-area">
                    <div class="accordion" id="accordion-<?php echo esc_attr( $uniqueID ); ?>">
                        <?php foreach ($faqs as $key => $faq): 
                            if(empty($faq['question']) || empty($faq['answer'])) continue;  
                            $collapsed_class =  $key > 0? ' collapsed' : '';                                     
                            $aria_expand =  $key == 0? 'true' : 'false';                                     
                            $show_class =  $key == 0? '  show' : '';                                    
                            ?>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading-<?php echo esc_attr( $uniqueID ).'-'.esc_attr($key); ?>">
                                    <button class="accordion-button<?php echo esc_attr($collapsed_class)  ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo esc_attr( $uniqueID ).'-'.esc_attr($key); ?>" aria-expanded="<?php echo esc_attr($aria_expand)  ?>" aria-controls="collapse-<?php echo esc_attr( $uniqueID ).'-'.esc_attr($key); ?>">
                                        <?php control_listings_content($faq['question']); ?>
                                    </button>
                                </h2>
                                <div id="collapse-<?php echo esc_attr( $uniqueID ).'-'.esc_attr($key); ?>" class="accordion-collapse collapse<?php echo esc_attr($show_class)  ?>" aria-labelledby="heading-<?php echo esc_attr( $uniqueID ).'-'.esc_attr($key); ?>" data-bs-parent="#accordion-<?php echo esc_attr( $uniqueID ); ?>">
                                    <div class="accordion-body">
                                        <?php control_listings_content($faq['answer']); ?>
                                    </div>
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