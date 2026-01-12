<?php
namespace ControlListings;
defined( 'ABSPATH' ) || exit;

class Ajax {
	public function __construct () {
		add_action( 'wp_ajax_ctrl_listing_favorite_add', [ $this, 'add' ] );
		add_action( 'wp_ajax_nopriv_ctrl_listing_favorite_add', [ $this, 'add' ] );
		add_action( 'wp_ajax_ctrl_listing_favorite_delete', [ $this, 'delete' ] );
		add_action( 'wp_ajax_nopriv_ctrl_listing_favorite_delete', [ $this, 'delete' ] );

		add_action( 'wp_ajax_ctrl_listing_sticky_posts', [ $this, 'sticky_posts' ] );

		add_action( 'wp_ajax_ctrl_listing_search', [ $this, 'listing_search' ] );
		add_action( 'wp_ajax_nopriv_ctrl_listing_search', [ $this, 'listing_search' ] );

		add_action( 'wp_ajax_ctrl_listing_share_post', [ $this, 'share_post' ] );
		add_action( 'wp_ajax_nopriv_ctrl_listing_share_post', [ $this, 'share_post' ] );

		// login form
		add_action( 'wp_ajax_nopriv_ctrl_listing_user_profile_form', [ $this, 'user_profile_form' ] );

		add_action( 'wp_ajax_controlListingsAjax', [$this, 'do_ajax'] );
		
		
	}

	public function do_ajax(){
		// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotValidated, WordPress.Security.ValidatedSanitizedInput.MissingUnslash, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized   
		if(!wp_verify_nonce( $_POST['nonce'], 'controlListings' )){
			die( esc_attr__( 'Security check', 'control-listings' ) ); 
		}
		
		// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotValidated, WordPress.Security.ValidatedSanitizedInput.MissingUnslash, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized   
		if(empty($_POST['data']['action'])){
			// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotValidated, WordPress.Security.ValidatedSanitizedInput.MissingUnslash, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized   
			Helper::debug_log($_POST['data']['action']);
			// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotValidated, WordPress.Security.ValidatedSanitizedInput.MissingUnslash, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized   
			wp_die('Action is missing', 'Button error!!', esc_js($_POST['data']));
		}

		// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotValidated, WordPress.Security.ValidatedSanitizedInput.MissingUnslash, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized   
		$method_name = $_POST['data']['action'];
		
		
		if(!method_exists($this, $method_name)){
			// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotValidated, WordPress.Security.ValidatedSanitizedInput.MissingUnslash, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized   
			wp_die('Method missing', esc_attr($method_name), esc_js($_POST['data']));
		}
		
		
		call_user_func( [$this, esc_attr($method_name)], $_POST);

		wp_die();
	}

	public function resetSettings($args){
		if(empty($args['data']['option_name'])) die;
		$option_name = $args['data']['option_name'];
		if(delete_option($option_name)){
			$response = [
				'error' => 0,
				// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotValidated, WordPress.Security.ValidatedSanitizedInput.MissingUnslash, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized   
				'redirect_to' => $_SERVER['HTTP_REFERER']
			];
			wp_send_json($response);
		}		
		
	}

	public function user_profile_form(){
		
		echo do_shortcode('[mb_user_profile_login]');
		wp_die();
	}

	public function share_post(){
		// phpcs:ignore WordPress.Security.NonceVerification.Missing, WordPress.Security.ValidatedSanitizedInput.InputNotValidated 
		$post_ID = (int)$_POST['id'];
		wp_send_json( [
			'title' => get_the_title($post_ID),
			'url' => get_permalink($post_ID),
			'text' => get_the_excerpt($post_ID),
			'utm_source' => get_bloginfo('name')
		] );
		wp_die();
	}

	public function add() {
		check_ajax_referer( 'add_to_favorites' );

		$post_id = rwmb_request()->filter_post( 'id', FILTER_VALIDATE_INT );

		if ( empty( $post_id ) ) {
			wp_send_json_error( __( 'No listing is added', 'control-listings' ) );
		}

		$favorites   = Favorite::get_favorites();
		$favorites[] = $post_id;

		$this->update( $favorites );
		$this->update_postmeta( $post_id, 'add' );
		$data = [];
		$data['count'] = Favorite::get_count( $post_id );
		$data['icon']	 = SVG_Icons::get_svg('ui', 'love-fill', 20);
		$data['msg']	 = __( 'Added to Favorite', 'control-listings' );
		
		wp_send_json_success( $data );
	}

	public function delete() {
		check_ajax_referer( 'delete_from_favorites' );
		$post_id = isset( $_POST['id'] ) ? intval( $_POST['id'] ) : '';
		if ( empty( $post_id ) ) {
			wp_send_json_error( __( 'No listing to delete', 'control-listings' ) );
		}
		$deleted_post = [ $post_id ];
		$favorites    = Favorite::get_favorites();
		$favorites    = array_diff( $favorites, $deleted_post );
		$favorites    = array_values( $favorites );

		$this->update( $favorites );
		$this->update_postmeta( $post_id, 'delete' );

		$data = [];
		$data['count'] = Favorite::get_count( $post_id );
		if( empty( $favorites ) ) {
			$data[ 'empty_notice'] =  __( 'You haven\'t added any listings yet', 'control-listings' );			
		}
		$data['icon']	 = SVG_Icons::get_svg('ui', 'love', 20);
		$data['msg']	 = __( 'Add to Favorite', 'control-listings' );
		wp_send_json_success( $data );
	}

	public function update( $favorites ) {
		if ( is_user_logged_in() ) {
			update_user_meta( get_current_user_id(), 'ctrl_listing_favorite_posts', $favorites );
		} else {
			setcookie( 'ctrl_listing_favorite_posts', json_encode( $favorites ), strtotime( '+1 month' ), COOKIEPATH, COOKIE_DOMAIN );
		}
	}

	public function update_postmeta( $post_id, $action ) {
		$count = get_post_meta( $post_id, 'ctrl_listing_favorite_count', true );

		if ( empty( $count ) ) {
			$count = [];
		}

		if ( 'add' === $action ) {
			$count[] = get_current_user_id();
			update_post_meta( $post_id, 'ctrl_listing_favorite_count', $count );
		}

		if ( 'delete' === $action ) {
			update_post_meta( $post_id, 'ctrl_listing_favorite_count', array_diff( $count, [ get_current_user_id() ] ) );
		}
	}


	public function bookmarks_form(){
		// phpcs:ignore WordPress.Security.NonceVerification.Missing, WordPress.Security.ValidatedSanitizedInput.InputNotValidated
		$post_ID = (int)$_POST['id'];
		ob_start();		
		if( is_user_logged_in() ){
			$args = [
				'post_ID' => $post_ID,
				'post_type' => get_post_type_object( get_post_type($post_ID) ),
				'is_bookmarked' => Bookmarks::is_bookmarked($post_ID)
			];
			control_listings_locate_template('bookmarks/bookmark-form.php', $args);			
		}
		
		$content = ob_get_clean();
		$response = [
			'title' => sprintf('%s %s', __('Bookmark:', 'control-listings'), get_the_title($post_ID)), 
			'content' => $content
		];
		wp_send_json($response);
		wp_die();
	}

	public function sticky_posts(){
		// phpcs:ignore WordPress.Security.NonceVerification.Missing, WordPress.Security.ValidatedSanitizedInput.InputNotValidated 
		$post_id = absint($_POST['post_id']);
		$post_obj = get_post($post_id);
		$post_type_object = get_post_type_object($post_obj->post_type);
		$status = false;
		$msg = '';

		// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotValidated, WordPress.Security.ValidatedSanitizedInput.MissingUnslash, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized  
		if(wp_verify_nonce($_POST['nonce'], 'sticky-post-nonce')){
			
			
            // Check capabilities
            if (!current_user_can( $post_type_object->cap->edit_others_posts ) || !current_user_can( $post_type_object->cap->publish_posts ) ) {
                wp_send_json_error(esc_attr__('Sorry, you are not allowed to edit this item.', 'control-listings'));
            }

            // Mark the post as currently being edited by the current user
            wp_set_post_lock( $post_id );

            // Sticky posts are not available on password or private posts
            $sticky_available = true;
            if(post_password_required($post_obj) || $post_obj->post_status == 'private'){
                unstick_post( $post_id );
                $sticky_available = false;
            }

		
			if($sticky_available){
				$status = true;
				if(is_sticky($post_id)){
					unstick_post( $post_id );				
					$msg = '';
				}else{
					stick_post($post_id);
					$msg = '';
				}
			}
			
			
		}
		$response = [
			'status' => $status,
			'msg' => $msg
		];
		// Get all post states
		ob_start();
		_post_states(get_post($post_id));
		$post_states = ob_get_clean();

		// Ajax output response
		wp_send_json_success(array(
			'sticky'    => is_sticky($post_id),
			'states'    => $post_states,
			'available' => $sticky_available
		));
		wp_die();
	}

	public function listing_search(){
		$msg = '';
		// phpcs:ignore WordPress.Security.NonceVerification.Missing, WordPress.Security.ValidatedSanitizedInput.InputNotValidated, WordPress.Security.ValidatedSanitizedInput.MissingUnslash, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
		parse_str($_POST['form_data'], $form_data);
		$vars = array_filter($form_data);
		$action_url = $form_data['redirect_to'];
		unset($vars['redirect_to']);
		$result_links = add_query_arg($vars, $action_url);
		$msg = '<a href="'.esc_url($result_links).'">View Search results</a>';

	
		$data = [
			'success' => true,
			'msg' => $msg,
			'link' => $result_links 
		];
		
		wp_send_json( $data );
		wp_die();
	}
}
