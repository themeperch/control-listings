<?php
/*
Plugin Name: Control Listings - Classifieds Ads Directory Portal Manager
Plugin URI: https://controllistings.com
Description: Classifieds ads directory portal manager
Author: Themeperch
Version: 1.0.6
Author URI: https://themeperch.net/
*/

// Exit if accessed directly.
defined( 'ABSPATH' ) || die;

if( defined('CTRL_LISTINGS_VER') ) return;


class Control_Listings_Init{
	public function __construct() {	
		$this->constants();
		// Activate
		register_activation_hook( basename( dirname( __FILE__ ) ) . '/' . basename( __FILE__ ), [ $this, 'activate' ] );

		add_action('wpmu_new_blog', [$this, 'install_for_new_blog'], 10, 1 );

		// Set up startup actions
		add_action( 'init', [$this, 'init'], 1 );
		
	}

	private function constants(){
		define( 'CTRL_LISTINGS_URI', trailingslashit(plugin_dir_url( __FILE__ )) );
		define( 'CTRL_LISTINGS_VER', '1.0.6' );
		define( 'CTRL_LISTINGS_ASSETS', trailingslashit(CTRL_LISTINGS_URI.'assets') );
		define( 'CTRL_LISTINGS_DIR', trailingslashit(plugin_dir_path( __FILE__ )) );
		define( 'CTRL_LISTINGS_TEMPLATEPATH', trailingslashit(plugin_dir_path( __FILE__ ).'views') );
	}

	public function init() {
		if ( ! defined( 'RWMB_VER' ) ) {
			require __DIR__ . '/vendor/wpmetabox/meta-box/meta-box.php';
		}
		require __DIR__ . '/vendor/autoload.php';
		new ControlListings\Loader;
		
	}

	/**
	 * Install when a new site is added to a network
	 *
	 * @param $blog_id
	 */
	public function install_for_new_blog( $blog_id ) {

		if( is_plugin_active_for_network( basename( dirname( __FILE__ ) ) . '/' . basename( __FILE__ ) ) ) {
			switch_to_blog( $blog_id );
			$this->install();
			restore_current_blog();
		}
	}

	/**
	 * Install plugin for all sites in a multi-site environment when network activated
	 *
	 * @param $network_wide
	 */
	public function activate( $network_wide ) {
		if( is_multisite() && $network_wide ) {
			global $wpdb;
			foreach( $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" ) as $blog_id ) {
				switch_to_blog( $blog_id );
				$this->install();
				restore_current_blog();
			}
		} else {
			$this->install();
		}
	}

	/**
	 * Install
	 */
	public function install() {
		global $wpdb;

		$wpdb->hide_errors();

		$collate = '';
	    if ( $wpdb->has_cap( 'collation' ) ) {
			if( ! empty( $wpdb->charset ) ) {
				$collate .= "DEFAULT CHARACTER SET $wpdb->charset";
			}
			if( ! empty( $wpdb->collate ) ) {
				$collate .= " COLLATE $wpdb->collate";
			}
	    }

	    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

	    $sql = "
CREATE TABLE {$wpdb->prefix}control_listings_bookmarks (
  id bigint(20) NOT NULL auto_increment,
  user_id bigint(20) NOT NULL,
  post_id bigint(20) NOT NULL,
  bookmark_note longtext NULL,
  date_created datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY  (id)
) $collate;
";
	    dbDelta( $sql );
	}
}

new Control_Listings_Init();