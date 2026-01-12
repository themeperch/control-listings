<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<!-- Modal -->
<div class="modal fade" id="listingSocialShare" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="listingSocialShareLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title fs-5" id="listingSocialShareLabel"><?php // translators: %s is the post title. printf(__('Share: %s', 'control-listings'), '<span class="post-title"></span>') ?></h2>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?php 
        $social_medias = [
            'fb' => __('Facebook', 'control-listings'),
            'twitter' => __('Twitter', 'control-listings'),
            'vk' => __('VK.com', 'control-listings'),
            'tumblr' => __('Tumblr', 'control-listings'),
            'pinterest' => __('Pinterest', 'control-listings'),
            'linkedin' => __('LinkedIn', 'control-listings'),
            'reddit' => __('Reddit', 'control-listings'),
            'weibo' => __('Weibo', 'control-listings'),
            'skype' => __('Skype', 'control-listings'),
            'telegram' => __('Telegram', 'control-listings'),
            'whatsapp' => __('Whatsapp', 'control-listings'),
            'email' => __('Email', 'control-listings')
        ];
        ?>
        <div class="social-medias d-flex flex-wrap gap-10 justify-content-center">
            <?php 
            foreach ($social_medias as $key => $value) {
               printf('<a class="btn btn-outline-dark btn-%1$s listing_social_share" data-type="%1$s" href="#">%3$s %2$s</a>', esc_attr($key), esc_attr($value), wp_kses_post(control_listings_get_icon_svg('social', $key, '18')));
            }
            ?>
        </div>
      </div>   
      <div class="modal-footer">
        <a href="#" data-bs-dismiss="modal"><?php esc_attr_e('Close', 'control-listings') ?></a>
      </div>
  
    </div>
  </div>
</div>
