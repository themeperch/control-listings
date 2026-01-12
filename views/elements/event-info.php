<?php 
extract(wp_parse_args( $args, [
    'countdown' => '',
    'days' => '',
    'hours' => '',
    'minutes' => '',
    'seconds' => '',
    // contact    
    'email' => '',
    'address' => '',
    'address_url' => '',
    'phone' => '',   
    // Style
    'icon_email' => [],
    'icon_address' => [],
    'icon_phone' => [],
    'dots' => [],
] ));
?>
 <!-- info sec start -->
<div class="listing-info info-sec">
    <div class="container">
        <?php if(!empty($countdown)): 
            $countdown_atts = [
                'data-countdown="'.esc_attr($countdown).'"',
                'data-days="'.(!empty($days)? esc_attr($days) : 'Days').'"',
                'data-hours="'.(!empty($hours)? esc_attr($hours) : 'Hours').'"',
                'data-minutes="'.(!empty($minutes)? esc_attr($minutes) : 'Minutes').'"',
                'data-seconds="'.(!empty($seconds)? esc_attr($seconds) : 'Seconds').'"',
            ];
            ?>
        <div class="listing-countdown info-countdown">
            <div class="counter-box d-flex justify-content-around" <?php
            // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
            echo implode(' ', $countdown_atts); 
            ?>></div>
            <?php if(!empty($dots['url'])): ?>
            <div class="dots img-moving-anim2">
                <img src="<?php echo esc_url( $dots['url'] ); ?>" alt="<?php esc_attr_e('Shadow Image', 'control-listings') ?>">
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        <div class="information-area">
            <div class="row g-4">
                 <?php if(!empty($email)): ?>
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-duration="600">
                    <div class="mail">
                    <?php if(!empty($icon_email['url'])): ?>
                    <div class="icon"><img src="<?php echo esc_url( $icon_email['url'] ); ?>" alt="<?php esc_attr_e('Mail', 'control-listings') ?>"></div>
                    <?php endif; ?>
                    <a href="mailto:<?php echo esc_attr($email) ?>" class="mail-link"><?php echo esc_attr($email) ?></a>
                    </div>
                </div>
                <?php endif; ?>

                <?php if(!empty($address)): ?>
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-duration="800">
                    <div class="location">
                    <?php if(!empty($icon_address['url'])): ?>
                    <div class="icon"><img src="<?php echo esc_url( $icon_address['url'] ); ?>" alt="<?php esc_attr_e('Address', 'control-listings') ?>"></div>
                    <?php endif; ?>
                    <a href="<?php echo esc_url($address_url) ?>" target="_blank" class="location-link"><?php echo esc_attr($address) ?></a>
                    </div>
                </div>
                <?php endif; ?>

                <?php if(!empty($phone)): ?>
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-duration="1000">
                    <div class="number">
                    <?php if(!empty($icon_phone['url'])): ?>
                    <div class="icon"><img src="<?php echo esc_url( $icon_phone['url'] ); ?>" alt="<?php esc_attr_e('Phone', 'control-listings') ?>"></div>
                    <?php endif; ?>
                    <a href="tel:<?php echo esc_attr($phone) ?>" class="number-link"><?php echo esc_attr($phone) ?></a>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<!-- info sec end -->