<?php
namespace ControlListings;
defined( 'ABSPATH' ) || exit;

final class Favorite{
    private $post_types = ['ctrl_listings'];
    /**
	 * Add hooks when module is loaded.
	 */
	public function __construct() {        
		add_filter( 'rwmb_meta_boxes', [ $this, 'register_meta_boxes' ] );    
	}

	public static function get_favorites() {
		// phpcs:ignore
		$favorites = ! empty( $_COOKIE['ctrl_listing_favorite_posts'] ) ? json_decode( sanitize_text_field( $_COOKIE['ctrl_listing_favorite_posts'] ) ) : [];


		if ( is_user_logged_in() ) {
			$favorites = get_user_meta( get_current_user_id(), 'ctrl_listing_favorite_posts', true );
		}

		

		$favorites = ( array ) $favorites;
		
		$favorites = self::remove_deleted_posts( $favorites );
		if ( is_user_logged_in() ) {
			update_user_meta( get_current_user_id(), 'ctrl_listing_favorite_posts', $favorites );
		} else {
			ob_start();
			setcookie( 'ctrl_listing_favorite_posts', json_encode( $favorites ), strtotime( '+1 month' ), COOKIEPATH, COOKIE_DOMAIN );
			ob_get_clean();
		}

		return $favorites;
	}

	private static function remove_deleted_posts( $favorites ) {
		return array_filter( $favorites, function( $post_id ) {
			return $post_id && get_post_status( $post_id );
		} );
	}

	public static function get_count( $post_id ) {
		$count = get_post_meta( $post_id, 'ctrl_listing_favorite_count', true );
		return ! empty ( $count ) ? count( $count ) : 0;
	}

	public static function is_added( $id ) {
		$favorites = self::get_favorites();
		if ( empty( $favorites ) ) {
			return false;
		}

		return in_array( $id, $favorites );
	}

	public function register_meta_boxes( $meta_boxes ) {
		
		$meta_boxes[] = [
			'title'  => ' ',
			'type'   => 'user',
			'fields' => [
				[
					'name'      => __( 'Favorite listings', 'control-listings' ),
					'id'        => 'ctrl_listing_favorite_posts',
					'type'      => 'post',
					'post_type' => $this->post_types,
					'clone'     => true,
					'query_args' => [
						'post_status' => [ 'any', 'inherit', 'trash', 'auto-draft' ],
					]
				],
			],
		];

		return $meta_boxes;
	}
    
}