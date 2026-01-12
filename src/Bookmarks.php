<?php
namespace ControlListings;
defined( 'ABSPATH' ) || exit;

/**
 * ControlListings/Bookmarks class.
 */
class Bookmarks {

	/**
	 * Constructor
	 */
	public function __construct() {				

		// Set up startup actions
		add_action( 'plugins_loaded', array( $this, 'init_plugin' ), 13 );

		// User deletion.
		add_action( 'delete_user', array( $this, 'remove_user_bookmarks' ), 10, 2 );

		// Personal data.
		add_filter( 'wp_privacy_personal_data_exporters', array( $this, 'register_personal_data_exporter' ) );
		add_filter( 'wp_privacy_personal_data_erasers', array( $this, 'register_personal_data_exporter_eraser' ) );

		// Ajax
		add_action( 'wp_ajax_ctrl_listing_bookmarks_form', [ $this, 'bookmarks_form' ] );
		add_action( 'wp_ajax_nopriv_ctrl_listing_bookmarks_form', [ $this, 'bookmarks_form' ] );

		add_action( 'wp_ajax_ctrl_listing_bookmarks_submit', [ $this, 'bookmark_handler' ] );
		add_action( 'wp_ajax_ctrl_listing_bookmarks_remove', [ $this, 'bookmark_handler' ] );
		
		add_action( 'control_listing_user_bookmarked', [$this, 'my_bookmarks'] );
		
	}

	/**
	 * Initializes plugin.
	 */
	public function init_plugin() {		
		// Add actions
		add_action( 'single_job_listing_meta_after', array( $this, 'bookmark_form' ) );
		add_action( 'single_resume_start', array( $this, 'bookmark_form' ) );
		
		add_shortcode( 'my_bookmarks', array( $this, 'my_bookmarks' ) );
		add_filter( 'post_class', array( $this, 'already_bookmarked_post_class' ), 20, 2 );
	}

	

	

	/**
	 * Get a user's bookmarks
	 * @param  integer $user_id
	 * @param  integer $limit
	 * @param  integer $offset
	 * @param  string  $orderby_key
	 * @param  string  $order_dir
	 * @return array|object
	 */
	public function get_user_bookmarks( $user_id = 0, $limit = 0, $offset = 0, $orderby_key = 'date', $order_dir = 'ASC' ) {
		global $wpdb;

		if ( ! $user_id && is_user_logged_in() ) {
			$user_id = get_current_user_id();
		} elseif ( ! $user_id ) {
			return false;
		}

		// Whitelist ORDER BY columns
		$order_columns = [
			'date'       => 'bm.date_created',
			'post_title' => 'p.post_title',
			'post_date'  => 'p.post_date',
		];
		$order_by = isset( $order_columns[ $orderby_key ] ) ? $order_columns[ $orderby_key ] : $order_columns['date'];

		// Whitelist ORDER direction
		$order_dir = strtoupper( $order_dir );
		$order_dir = in_array( $order_dir, ['ASC', 'DESC'], true ) ? $order_dir : 'ASC';

		$table_bookmarks = $wpdb->prefix . 'control_listings_bookmarks';

		if ( $limit > 0 ) {
			$sql = "
				SELECT SQL_CALC_FOUND_ROWS bm.*
				FROM {$table_bookmarks} bm
				LEFT JOIN {$wpdb->posts} p ON bm.post_id = p.ID
				WHERE bm.user_id = %d
				AND p.post_status = 'publish'
				ORDER BY {$order_by} {$order_dir}
				LIMIT %d, %d
			";
			// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
			$query = $wpdb->prepare( $sql, $user_id, $offset, $limit );
			// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
			$results = $wpdb->get_results( $query );
			$max_results = (int) $wpdb->get_var( 'SELECT FOUND_ROWS()' );

			return (object) [
				'max_found_rows' => $max_results,
				'max_num_pages'  => ceil( $max_results / $limit ),
				'results'        => $results,
			];
		}

		// No limit
		$sql = "
			SELECT bm.*
			FROM {$table_bookmarks} bm
			LEFT JOIN {$wpdb->posts} p ON bm.post_id = p.ID
			WHERE bm.user_id = %d
			AND p.post_status = 'publish'
			ORDER BY {$order_by} {$order_dir}
		";
		// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
		$query = $wpdb->prepare( $sql, $user_id );

		// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
		return $wpdb->get_results( $query );
	}


	/**
	 * See if a post is bookmarked by ID
	 * @param  int post ID
	 * @return boolean
	 */
	public static function is_bookmarked( $post_id ) {
		global $wpdb;

		return $wpdb->get_var( $wpdb->prepare( "SELECT id FROM {$wpdb->prefix}control_listings_bookmarks WHERE post_id = %d AND user_id = %d;", $post_id, get_current_user_id() ) ) ? true : false;
	}

	/**
	 * Get the total number of bookmarks for a post by ID
	 * @param  int $post_id
	 * @return int
	 */
	public function bookmark_count( $post_id ) {
		global $wpdb;

		if ( false === ( $bookmark_count = get_transient( 'bookmark_count_' . $post_id ) ) ) {
			$bookmark_count = absint( $wpdb->get_var( $wpdb->prepare( "SELECT COUNT( id ) FROM {$wpdb->prefix}control_listings_bookmarks WHERE post_id = %d;", $post_id ) ) );
			set_transient( 'bookmark_count_' . $post_id, $bookmark_count, YEAR_IN_SECONDS );
		}

		return absint( $bookmark_count );
	}

	/**
	 * Get a bookmark's note
	 * @param  int post ID
	 * @return string
	 */
	public function get_note( $post_id ) {
		global $wpdb;

		return $wpdb->get_var( $wpdb->prepare( "SELECT bookmark_note FROM {$wpdb->prefix}control_listings_bookmarks WHERE post_id = %d AND user_id = %d;", $post_id, get_current_user_id() ) );
	}

	/**
	 * Handle the book mark form
	 */
	public function bookmark_handler() {
		global $wpdb;

		if ( ! is_user_logged_in() ) {
			return;
		}
		$action_data = null;

		if ( ! empty( $_POST['submit_bookmark'] ) ) {
			// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotValidated, WordPress.Security.ValidatedSanitizedInput.MissingUnslash, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized 
			if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'update_bookmark' ) ) {
				$action_data = array(
					'error_code' => 400,
					'error' => esc_attr__( 'Bad request', 'control-listings' ),
				);
			} else {
				// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotValidated
				$post_id = absint( $_POST[ 'bookmark_post_id' ] );
				// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotValidated, WordPress.Security.ValidatedSanitizedInput.MissingUnslash, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized 
				$note    = wp_kses_post( stripslashes( $_POST[ 'bookmark_notes' ] ) );

				if ( $post_id ) {
					if ( ! self::is_bookmarked( $post_id ) ) {
						$wpdb->insert(
							"{$wpdb->prefix}control_listings_bookmarks",
							array(
								'user_id'       => get_current_user_id(),
								'post_id'       => $post_id,
								'bookmark_note' => $note,
								'date_created'  => current_time( 'mysql' )
							)
						);
					} else {
						$wpdb->update(
							"{$wpdb->prefix}control_listings_bookmarks",
							array(
								'bookmark_note' => $note
							),
							array(
								'post_id' => $post_id,
								'user_id' => get_current_user_id()
							)
						);
					}

					delete_transient( 'bookmark_count_' . $post_id );
					$action_data = array( 'success' => true, 'note' =>  $note );
				}
			}
		}

		if ( ! empty( $_GET['remove_bookmark'] ) ) {
			// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotValidated, WordPress.Security.ValidatedSanitizedInput.MissingUnslash, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized 
			if ( ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'remove_bookmark' ) ) {
				$action_data = array(
					'error_code' => 400,
					'error' => esc_attr__( 'Bad request', 'control-listings' ),
				);
			} else {
				$post_id = absint( $_GET[ 'remove_bookmark' ] );

				$wpdb->delete(
					"{$wpdb->prefix}control_listings_bookmarks",
					array(
						'post_id' => $post_id,
						'user_id' => get_current_user_id()
					)
				);

				delete_transient( 'bookmark_count_' . $post_id );
				$action_data = array( 'success' => true );
			}
		}

		if ( null === $action_data ) {
			return;
		}
		if ( ! empty( $_REQUEST['wpjm-ajax'] ) && ! defined( 'DOING_AJAX' ) ) {
			define( 'DOING_AJAX', true );
		}
		if ( wp_doing_ajax() ) {
			wp_send_json( $action_data, ! empty( $action_data['error_code'] ) ? $action_data['error_code'] : 200 );
		} else {
			wp_safe_redirect( remove_query_arg( array( 'submit_bookmark', 'remove_bookmark', '_wpnonce', 'wpjm-ajax' ) ) );
		}
	}

	

	/**
	 * User bookmarks shortcode
	 */
	public function my_bookmarks( $atts ) {
		if ( ! is_user_logged_in() ) {
			return __( 'You need to be signed in to manage your bookmarks.', 'control-listings' );
		}

		$atts = shortcode_atts( array(
			'posts_per_page' => '25',
			'orderby'        => 'date', // Options: date, post_date, post_title
			'order'          => 'DESC',
		), $atts );

		

		

		if ( $atts['posts_per_page'] >= 0 ) {
			$bookmarks = $this->get_user_bookmarks( get_current_user_id(), $atts['posts_per_page'], ( max( 1, get_query_var('paged') ) - 1 ) *  $atts['posts_per_page'], $atts['orderby'], $atts['order'] );

			control_listings_locate_template( 'bookmarks/my-bookmarks.php', array(
				'bookmarks'     => $bookmarks->results,
				'max_num_pages' => $bookmarks->max_num_pages
			) );
		} else {
			$bookmarks = $this->get_user_bookmarks( get_current_user_id(), 0, 0, $atts['orderby'], $atts['order'] );

			control_listings_locate_template( 'bookmarks/my-bookmarks.php', array(
				'bookmarks'     => $bookmarks,
				'max_num_pages' => 1
			) );
		}

		
	}

	/**
	 * Add note that the listing is bookmarked
	 */
	public function already_bookmarked_post_class( $classes ) {
		global $post;

		if ( is_user_logged_in() && self::is_bookmarked( $post->ID ) ) {
			$classes[] = 'listing-bookmarked';
		}

		return $classes;
	}

	/**
	 * Remove user bookmarks on user deletion.
	 * Hooked into `delete_user`.
	 *
	 * @access private
	 *
	 * @param int $user_id  User ID to remove bookmarks.
	 * @param int $reassign User ID to remove bookmarks.
	 */
	public function remove_user_bookmarks( $user_id, $reassign = null ) {
		global $wpdb;

		if ( null !== $reassign ) {
			// Reassign bookmarks.
			$wpdb->update(
				"{$wpdb->prefix}control_listings_bookmarks",
				array(
					'user_id' => $reassign
				),
				array(
					'user_id' => $user_id
				)
			);

			return;
		}

		// Get post_ids to be removed from user.
		$sql_query = $wpdb->prepare( "SELECT post_id FROM `{$wpdb->prefix}control_listings_bookmarks` " .
			"WHERE `user_id` = %d", $user_id );
		// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared 
		$results = $wpdb->get_results( $sql_query );

		// Delete user bookmarks.
		$wpdb->delete(
			"{$wpdb->prefix}control_listings_bookmarks",
			array(
				'user_id' => $user_id
			)
		);

		// Reset bookmark counters.
		foreach( $results as $result ) {
			delete_transient( 'bookmark_count_' . $result->post_id );
		}
	}

	/**
	 * Export bookmark personal data for a user using the supplied email.
	 *
	 * @access private
	 *
	 * @param string $email_address Email address to manipulate.
	 * @param int    $page          Pagination.
	 *
	 * @return array Data to be exported.
	 */
	public function bookmarks_personal_data_exporter( $email_address, $page = 1 ) {
		global $wpdb;

		$page   = (int) $page;
		$limit  = 100;
		$offset = $limit * ( $page - 1 );

		$sql_query = $wpdb->prepare( "SELECT `bm`.`id`, `bm`.`bookmark_note`, `bm`.`post_id`, `p`.`post_title` " .
			"FROM `{$wpdb->prefix}control_listings_bookmarks` `bm`, `{$wpdb->posts}` `p`, `{$wpdb->users}` `u` " .
			"WHERE `u`.`user_email` = %s AND `bm`.`user_id` = `u`.`id` AND `bm`.`post_id` = `p`.`ID` " .
			"ORDER BY `bm`.`post_id` ".
			"LIMIT %d, %d;", $email_address, $offset, $limit );
		// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
		$results      = $wpdb->get_results( $sql_query );
		$export_items = [];

		foreach ( $results as $result ) {
			$data = [
				[
					'name'  => __( 'Bookmarked job', 'control-listings' ),
					'value' => $result->post_title,
				],
				[
					'name'  => __( 'Bookmark note', 'control-listings' ),
					'value' => $result->bookmark_note,
				],
				[
					'name'  => __( 'Job link', 'control-listings' ),
					'value' => get_permalink( $result->post_id ),
				],
			];

			$export_items[] = [
				'group_id'    => 'listing-bookmarks',
				'group_label' => __( 'Listing Bookmarks', 'control-listings' ),
				'item_id'     => "job-bookmark-{$result->id}",
				'data'        => $data,
			];
		}

		return [
			'data' => $export_items,
			'done' => count( $results ) < $limit
		];
	}

	/**
	 * Registers bookmarks personal data exporter.
	 * Hooked into `wp_privacy_personal_data_exporters`.
	 *
	 * @access private
	 *
	 * @param array $exporters Current exporters.
	 *
	 * @return array Filtered exporters.
	 */
	public function register_personal_data_exporter( $exporters ) {
		$exporters['control-listings-bookmarks'] = [
			'exporter_friendly_name' => esc_attr__( 'Listing Bookmarks', 'control-listings' ),
			'callback'               => [ $this, 'bookmarks_personal_data_exporter' ],
		];

		return $exporters;
	}

	/**
	 * Removes bookmark personal data for a user using the supplied email.
	 *
	 * @access private
	 *
	 * @param string $email_address Email address to manipulate.
	 *
	 * @return array Data to be removed.
	 */
	public function bookmarks_personal_data_eraser( $email_address, $page = 1 ) {
		$user = get_user_by( 'email', $email_address );

		$this->remove_user_bookmarks( $user->ID );

		return [
			'items_removed'  => true,
			'items_retained' => false,
			'messages'       => [],
			'done'           => true,
		];
	}

	/**
	 * Registers bookmarks personal data eraser.
	 * Hooked into `wp_privacy_personal_data_erasers`
	 *
	 * @access private
	 *
	 * @param array $erasers Current erasers.
	 *
	 * @return array Filtered erasers.
	 */
	public function register_personal_data_exporter_eraser( $erasers ) {
		$erasers['control-listings-bookmarks'] = [
			'eraser_friendly_name' => esc_attr__( 'Listing Bookmarks', 'control-listings' ),
			'callback'             => [ $this, 'bookmarks_personal_data_eraser' ],
		];

		return $erasers;
	}

	public function bookmarks_form(){
		// phpcs:ignore WordPress.Security.NonceVerification.Missing, WordPress.Security.ValidatedSanitizedInput.InputNotValidated, WordPress.Security.ValidatedSanitizedInput.MissingUnslash, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized  
		$post_ID = intval($_POST['id']);
		ob_start();		
		if( is_user_logged_in() ){
			$is_bookmarked = self::is_bookmarked( $post_ID );

			if ( $is_bookmarked ) {
				$note = $this->get_note( $post_ID );
			} else {
				$note = '';
			}
			$args = [
				'post_type'     => get_post_type_object( get_post_type($post_ID) ),
				'post'          => get_post($post_ID),
				'is_bookmarked' => $is_bookmarked,
				'note'          => $note
				
			];
			control_listings_locate_template('bookmarks/bookmark-form.php', $args);			
		}
		
		$content = ob_get_clean();
		$response = [
			/* translators: %s: Listing title  */
			'title' => sprintf(__('Bookmark: %s', 'control-listings'), get_the_title($post_ID)),
			'content' => $content
		];
		wp_send_json($response);
		wp_die();
	}
	
}