<?php
namespace ControlListings;
defined( 'ABSPATH' ) || exit;

final class Loader{
    
    /**
	 * Add hooks when module is loaded.
	 */
	public function __construct() {        
		$this->init();        
        add_action( 'init', [$this, 'settings_page_load'], 5 );
        add_filter( 'rwmb_admin_menu', '__return_false', 999 );
	}

   

    private function init(){
        

        
        // Fields
        new Fields\Tabs;
        new Fields\Group;
        new Fields\Conditional_Logic;
        new Fields\Geolocation;
        

        new Assets;
        new Post_Types;
        new Taxonomies;
        new Settings;
        new Customize;
        new Meta_Boxes;
        new Users;
        new Listing_Form;
        new Query;
        new Shortcode;
        new Templates;
        new Elementor;
        new AdminColumn;
        new Ajax;
        new Favorite;
        new Widgets;
        new Blocks;
        new User\Dashboard;        
        
        $GLOBALS['control_listings_bookmarks'] = new Bookmarks();
    }

    function settings_page_load(){
        if ( ! function_exists( 'mb_settings_page_load' ) ) {
            new SettingsPage\Loader;        
            new SettingsPage\Customizer\Manager;            
        }

        
        new TermMeta\Loader;
        new Gutenberg\Loader;
    }

    
}