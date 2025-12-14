<?php
namespace ControlListings;

final class Users{
	/**
	 * Query vars to add to wp.
	 *
	 * @var array
	 */
	public $query_vars = array();
    /**
	 * Add hooks when module is loaded.
	 */
	public function __construct() {  
		// Actions      
		add_action( 'control_listing_user_login', [$this, 'user_login'] );       
		add_action( 'control_listing_user_register', [$this, 'user_register'] );       
		add_action( 'control_listing_user_profile', [$this, 'user_profile'] );       
		add_action( 'control_listing_user_dashboard', [$this, 'user_dashboard'] ); 
		add_action( 'control_listing_user_favorites', [$this, 'user_favorites'] );		       
				       
		add_action( 'rwmb_meta_boxes', [$this, 'meta_boxes'] );   
		add_filter( 'pre_get_avatar', [ $this, 'get_avatar' ], 10, 5 );  	

		add_action( 'init', [$this, 'add_endpoints']);
		if ( ! is_admin() ) {
			add_filter( 'query_vars', array( $this, 'add_query_vars' ), 0 );
			add_action( 'parse_request', array( $this, 'parse_request' ), 0 );
		}
		$this->init_query_vars();
	}

	

	public function meta_boxes($meta_boxes){       
        $meta_boxes[] = include __DIR__ ."/users/default-fields.php";       
		
        return $meta_boxes;
        
    }

	public function get_avatar( $avatar, $id_or_email, $args ) {
		if(check_is_inactive_control_listings_pro()){
			return $avatar;
		}
		if ( is_numeric( $id_or_email ) ) {
			$user_id = $id_or_email;
		} elseif ( is_string( $id_or_email ) && ( $user = get_user_by( 'email', $id_or_email ) ) ) {
			$user_id = $user->ID;
		} elseif ( is_object( $id_or_email ) && ! empty( $id_or_email->user_id ) ) {
			$user_id = (int) $id_or_email->user_id;
		}

		if ( empty( $user_id ) ) {
			return $avatar;
		}

		$custom_avatar = rwmb_meta( 'control_listing_user_avatar', [ 'object_type' => 'user' ], $user_id );

		if ( ! $custom_avatar ) {
			return $avatar;
		}

		if(is_array(reset($custom_avatar))){
			$custom_avatar = reset($custom_avatar);
		}

		$alt = ! empty( $args['alt'] ) ? $args['alt'] : '' ;
		$alt = ! empty( $custom_avatar['alt'] ) ? $custom_avatar['alt'] : $alt ;
		
		if((int) $args['width'] < 300 ){
			$url = $custom_avatar['sizes']['ctrl-listings-thumbnail']['url'];
		}else{
			$url = $custom_avatar['full_url'];
		}
		

		$class = array( 'avatar', 'avatar-' . (int) $args['size'], 'photo' );
		if ( $args['class'] ) {
			if ( is_array( $args['class'] ) ) {
				$class = array_merge( $class, $args['class'] );
			} else {
				$class[] = $args['class'];
			}
		}

		return sprintf( '<img alt="%s" src="%s" class="%s" width="%d" height="%d" />', esc_attr( $alt ), esc_url( $url ), esc_attr( join( ' ', $class ) ), (int) $args['width'], (int) $args['height'] );
	}

	public function user_login(){
		if(is_user_logged_in()) return;
		if(check_is_inactive_control_listings_pro()){
			check_is_inactive_control_listings_pro(true);
			return;
		}
		echo do_shortcode('[mb_user_profile_login]');
	}

	public function user_register(){
		if(is_user_logged_in()) return;
		if(check_is_inactive_control_listings_pro()){
			check_is_inactive_control_listings_pro(true);
			return;
		}
		echo do_shortcode('[mb_user_profile_register]');
	}
	

	public function user_profile(){		
		if(check_is_inactive_control_listings_pro()){
			check_is_inactive_control_listings_pro(true);
			return;
		}
		
		echo do_shortcode('[mb_user_profile_info id="default-fields" redirect="'.add_query_arg(['tab' => 'profile'], get_permalink()).'"]');
	}

	public function user_dashboard(){
		$options = get_option('control_listings');		
		if( !empty($options['post_listing_page'])){
			echo do_shortcode($this->frontend_dashboard());
		}
	}

	public function user_favorites(){
		$favorites = Favorite::get_favorites();
		$args = [
			'favorites' => $favorites
		];
    	control_listings_locate_template('my-account/favorites.php', $args);
	}

	private function frontend_dashboard_atts(){
		
		$args = [			
			// Meta box id.
			'id'                   => 'control-listing-data',

			// Add new post button text
			'add_new'              => __( 'Add New Listing', 'control-listings' ),

			// Delete permanently.
			'force_delete'         => 'false',

			// Columns to display.
			'columns'              => 'title,date,status',

			// Column header labels.
			'label_title'          => __( 'Title', 'control-listings' ),
			'label_date'           => __( 'Date', 'control-listings' ),
			'label_status'         => __( 'Status', 'control-listings' ),
			'label_actions'        => __( 'Actions', 'control-listings' ),
		];

		
		// Edit page id.
		$options = get_option('control_listings');
		if( !empty($options['post_listing_page'])){			
			$args['edit_page'] = $options['post_listing_page'];
		}
		return $args;
	}

	private function frontend_dashboard(){
		$atts = [];
		foreach ($this->frontend_dashboard_atts() as $key => $value) {
			if($value == '') continue;			
			$atts[] = $key.'="'.$value.'"';
		}
		return '[control_listings_frontend_dashboard '.implode(' ', $atts).']';
	}
	/**
	 * Endpoint mask describing the places the endpoint should be added.
	 *
	 * @return int
	 */
	public function get_endpoints_mask() {
		if ( 'page' === get_option( 'show_on_front' ) ) {
			$page_on_front     = get_option( 'page_on_front' );
			$myaccount_page_id = control_listings_setting('my_account_page');
			$checkout_page_id  = control_listings_setting('post_listing_page');

			if ( in_array( $page_on_front, array( $myaccount_page_id, $checkout_page_id ), true ) ) {
				return EP_ROOT | EP_PAGES;
			}
		}

		return EP_PAGES;
	}

	/**
	 * Add endpoints for query vars.
	 */
	public function add_endpoints() {
		$mask = $this->get_endpoints_mask();

		foreach ( $this->get_query_vars() as $key => $var ) {
			if ( ! empty( $var ) ) {
				add_rewrite_endpoint( $var, $mask );
			}
		}
	}

	/**
	 * Init query vars by loading options.
	 */
	public function init_query_vars() {
			// Query vars to add to WP.
		$this->query_vars = control_listing_get_account_end_points();
	}

	/**
	 * Get query vars.
	 *
	 * @return array
	 */
	public function get_query_vars() {
		return apply_filters( 'control_listings_get_query_vars', $this->query_vars );
	}

	/**
	 * Add query vars.
	 *
	 * @param array $vars Query vars.
	 * @return array
	 */
	public function add_query_vars( $vars ) {
		foreach ( $this->get_query_vars() as $key => $var ) {
			$vars[] = $key;
		}
		return $vars;
	}

	/**
	 * Get query current active query var.
	 *
	 * @return string
	 */
	public function get_current_endpoint() {
		global $wp;

		foreach ( $this->get_query_vars() as $key => $value ) {
			if ( isset( $wp->query_vars[ $key ] ) ) {
				return $key;
			}
		}
		return '';
	}

	/**
	 * Parse the request and look for query vars - endpoints may not be supported.
	 */
	public function parse_request() {
		global $wp;

		// phpcs:disable WordPress.Security.NonceVerification.Recommended
		// Map query vars to their keys, or get them if endpoints are not supported.
		foreach ( $this->get_query_vars() as $key => $var ) {
			if ( isset( $_GET[ $var ] ) ) {				
				$wp->query_vars[ $key ] = sanitize_text_field( wp_unslash( $_GET[ $var ] ) );
			} elseif ( isset( $wp->query_vars[ $var ] ) ) {
				$wp->query_vars[ $key ] = $wp->query_vars[ $var ];
			}
		}
		// phpcs:enable WordPress.Security.NonceVerification.Recommended
	}



}