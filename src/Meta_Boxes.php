<?php
namespace ControlListings;

final class Meta_Boxes{
    /**
	 * Add hooks when module is loaded.
	 */
	public function __construct() {        
        add_action( 'post_submitbox_misc_actions', [$this, 'add_sticky_post_checkbox'] ,10, 1 );
		add_action( 'rwmb_meta_boxes', [$this, 'meta_boxes'] );       
	}

    public function meta_boxes($meta_boxes){
		
        $meta_boxes[] = include __DIR__ ."/meta-boxes/listings-post.php";
        $meta_boxes[] = include __DIR__ ."/meta-boxes/listings.php";
        $meta_boxes[] = include __DIR__ ."/meta-boxes/review.php";
        

        return $meta_boxes;
        
    }


    /*
         * Implements the sticky checkbox on custom post type
         */
        public function add_sticky_post_checkbox( $post ) {
            if( $post->post_type != 'ctrl_listings' ) return;
            $post_id = $post->ID;

            $hyperlink_class = 'sticky-posts';
			$hyperlink_style = '';
			$icon_class = 'dashicons-star-empty';
			

			if(is_sticky($post_id))
			{
				$hyperlink_class .= ' active';
				$icon_class = 'dashicons-star-filled';
				printf('<input id="sticky" type="hidden" name="sticky" value="sticky" checked="checked">');
			}

			printf('<div class="misc-pub-section"><a id="%s" title="%s" class="%s" %s href="javascript:void(0);" data-id="%d" data-nonce="%s"><span class="dashicons %s"></span></a> %s</div>',
				'stiky-post-'.intval($post_id),
				is_sticky($post_id)? esc_attr__('Featured listing', 'control-listings') : esc_attr__('Click to make listing featured', 'control-listings'),
				esc_attr($hyperlink_class),
				esc_attr($hyperlink_style),
				intval($post_id),
				esc_attr(wp_create_nonce('sticky-post-nonce')),
				esc_attr($icon_class),
                esc_attr__('Featured status', 'control-listings'),
			);

            
        }
}