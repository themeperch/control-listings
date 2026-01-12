<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<div class="card card-widget single-listing-widget">
    <div class="card-body widget border-bottom pb-0">
        <h4 class="widget-title"><?php esc_attr_e('Contact Info', 'control-listings') ?></h4>
        <?php if( !empty($address) ): ?>
        <span class="text-uppercase"><?php esc_attr_e('Location', 'control-listings') ?></span>
        <address class="listing-sidebar-address"><?php echo wp_kses_post($address) ?></address>
        <?php endif; ?>
    </div>
    <?php echo wp_kses_post($google_map); ?>
    <ul class="list-group list-group-flush">
        <?php if( !empty($phone) ): ?>
        <li class="list-group-item d-grid">            
            <span class="text-uppercase"><?php esc_attr_e('Phone', 'control-listings') ?></span>
            <a href="tel:<?php echo esc_attr($phone) ?>"><?php echo esc_attr($phone) ?></a>
        </li>
        <?php endif; ?>
        <?php if( !empty($email) ): ?>
        <li class="list-group-item d-grid">            
            <span class="text-uppercase"><?php esc_attr_e('Email', 'control-listings') ?></span>
            <a href="mailto:<?php echo esc_attr($email) ?>"><?php echo esc_attr($email) ?></a>
        </li>
        <?php endif; ?>
        <?php if( !empty($website) ): ?>
        <li class="list-group-item d-grid">            
            <span class="text-uppercase"><?php esc_attr_e('Website', 'control-listings') ?></span>
            <a href="<?php echo esc_url($website) ?>" target="_blank"><?php echo esc_attr($website) ?></a>
        </li>
        <?php endif; ?>
        <?php if( !empty($social_links) ): ?>
        <li class="list-group-item d-grid">            
            <span class="text-uppercase mb-5"><?php esc_attr_e('Social links', 'control-listings') ?></span>
            <div class="d-flex gap-10">
                <?php foreach ($social_links as $social): if(empty($social['link']) || empty($social['title'])) continue; ?>
                    <a href="<?php echo esc_url($social['link']) ?>" title="<?php echo esc_attr($social['title']) ?>" target="_blank"><?php echo wp_kses_post(control_listings_get_social_link_svg( $social['link'], 24 )); ?></a>
                <?php endforeach; ?>
            </div>
            
        </li>
        <?php endif; ?>    
    </ul>
</div>
