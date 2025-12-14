<?php
namespace ControlListings;

final class Post_Types{
    /**
	 * Add hooks when module is loaded.
	 */
	public function __construct() {        
		add_action( 'init', [$this, 'register_post_type'] );       
	}

    public function register_post_type(){
        $post_types = [
            'ctrl_listings' => include __DIR__ ."/post-types/listings.php",
        ];

        foreach ($post_types as $post_type => $args) {
            register_post_type( $post_type, $args );
        }
        
    }
}