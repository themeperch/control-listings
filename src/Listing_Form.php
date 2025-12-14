<?php
namespace ControlListings;

final class Listing_Form{
    /**
	 * Add hooks when module is loaded.
	 */
	public function __construct() {  
		 
		add_filter('rwmb_frontend_dashboard_edit_page_content', [$this, 'frontend_dashboard_edit_page_content']);
		add_filter('the_content', [$this, 'the_content']);
		add_filter('rwmb_frontend_field_value_post_id', [$this, 'form_post_id']);
		add_action('rwmb_frontend_after_save_post', [$this, 'save_post']);
		
		add_action( 'init', [$this, 'init']);
		add_action('pre_get_posts', [$this, 'users_own_attachments']);
		
	}

	public function init(){
		
			// Replace 'subscriber' with the required role to update, can also be contributor.
			$subscriber = get_role( 'subscriber' );
			$subscriber->add_cap( 'upload_files' );
		 
	}

	function users_own_attachments( $wp_query_obj ) {

		global $current_user, $pagenow;

		if( current_user_can('editor') || current_user_can('administrator') ) return $wp_query_obj;
	
		$is_attachment_request = ($wp_query_obj->get('post_type')=='attachment');
	
		if( !$is_attachment_request )
			return;
	
		if( !is_a( $current_user, 'WP_User') )
			return;
	
		if( !in_array( $pagenow, array( 'upload.php', 'admin-ajax.php' ) ) )
			return;
	
		if( !current_user_can('delete_pages') )
			$wp_query_obj->set('author', $current_user->ID );
	
		return;
	}
	
	public function form_post_id($post_id){
		$new_post_id = filter_input( INPUT_GET, 'listings_frontend_post_id', FILTER_SANITIZE_NUMBER_INT );
		if ( $new_post_id ) {
			$post_id = $new_post_id;
		}
		return $post_id;
	}

	public function frontend_dashboard_edit_page_content($content){		
			$content = $this->frontend_form();
		
		return $content;
	}

	public function the_content($content){

		
		$options = get_option('control_listings');
		if( !empty($options['post_listing_page']) && is_page($options['post_listing_page'])){
			if (strpos($content, '[control_listings_form]') !== false) {
				$content = str_replace('[control_listings_form]', $this->frontend_form(), $content);
			}else{
				$content = $this->frontend_form().$content;
			}			
		}
		
		return $content;
	}

	private function frontend_form_atts(){
		
		$args = [
			'id' => 'control-listing-post-fields,control-listing-data',
			

			// Google reCaptcha v3
			'recaptcha_key'       => '',
			'recaptcha_secret'    => '',

			// Post fields.
			'post_type'           => 'ctrl_listings',
			'post_status'         => 'draft',
			'post_fields'         => '',
			'label_title'         => __( 'Title', 'control-listings' ),
			'label_content'       => __( 'Content', 'control-listings' ),
			'label_excerpt'       => __( 'Excerpt', 'control-listings' ),
			'label_date'          => __( 'Date', 'control-listings' ),
			'label_thumbnail'     => __( 'Thumbnail', 'control-listings' ),

			// Appearance options.
			'submit_button'       => __( 'Submit Listing', 'control-listings' ),
			'add_button'          => __( 'Add new Listing', 'control-listings' ),
			'delete_button'       => __( 'Delete Listing', 'control-listings' ),
			'confirmation'        => __( 'Your Listing has been successfully submitted. Thank you.', 'control-listings' ),
			'delete_confirmation' => __( 'Your Listing has been successfully deleted.', 'control-listings' ),
		];

		
		// Redirect
		$options = get_option('control_listings');
		if( !empty($options['my_account_page'])){			
			$args['redirect'] = get_permalink($options['my_account_page']);
		}
		return $args;
	}

	private function frontend_form(){
		if( !is_user_logged_in() ){
			return '<p class="alert alert-warning">'.sprintf('Please %s to continue', 
			control_listings_login_link(__('Login to continue', 'control-listings'), __('Login', 'control-listings'))
		).'</p>';
		}

		
		$atts = [];
		foreach ($this->frontend_form_atts() as $key => $value) {
			if($value == '') continue;			
			$atts[] = $key.'="'.$value.'"';
		}
		ob_start();
		control_listings_locate_template('my-account/before-form.php');	
		
		$before_form = ob_get_clean();
		return $before_form.'[mb_frontend_form '.implode(' ', $atts).']';
	}

	public function save_post($post){
		if(!empty($_POST['listing_cat'])){
			wp_set_post_terms( $post->post_id, sanitize_title($_POST['listing_cat']), 'listing_cat' );
		}

		if(!empty($_POST['listing_tag'])){
			wp_set_post_terms( $post->post_id, sanitize_title($_POST['listing_tag']), 'listing_tag' );
		}	
		
		if(!empty($_POST['_thumbnail_id'])){
			set_post_thumbnail( $post->post_id, (int)$_POST['_thumbnail_id'] );
		}

		if(!empty($_POST['listing_status'])){
			wp_update_post(array(
				'ID'    =>  $post->post_id,
				'post_status'   =>  sanitize_title($_POST['listing_status'])
			));
			
		}
		
	}

	

}