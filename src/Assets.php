<?php
namespace ControlListings;
defined( 'ABSPATH' ) || exit;

final class Assets{
    
    /**
	 * Add hooks when module is loaded.
	 */
	public function __construct() {        
        add_action('init', [$this, 'add_image_size']);        
        add_action('init', [$this, 'assets']);        
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);        
        add_action('admin_enqueue_scripts', [$this, 'admin_enqueue_scripts']);        
	}

    public function add_image_size(){
        add_image_size( 'ctrl-listings-thumbnail', 400, 400, true );
        add_image_size( 'ctrl-listings-archive-image', 450, 350, true );
        add_image_size( 'ctrl-listings-archive-list-image', 500, 500, true );
        add_image_size( 'ctrl-listings-map-image', 400, 250, true );
        add_image_size( 'ctrl-listings-gallery-image', 750, 400, true );
        add_image_size( 'ctrl-listings-video-thumbnail', 900, 503, true );
    }
    

    public function assets(){
        // Bootstrap
        // phpcs:ignore PluginCheck.CodeAnalysis.EnqueuedResourceOffloading.OffloadedContent 
        wp_register_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css', false, '5.0.3');
        wp_register_script('bootstrap-bundle', CTRL_LISTINGS_ASSETS.'bootstrap/dist/js/bootstrap.bundle.min.js', false, '5.0.3');

        // Swiper
        wp_register_style('swiper-bundle', CTRL_LISTINGS_ASSETS.'swiper/swiper-bundle.min.css', false, '8.4.5');
        wp_register_style('ctrl-listings-swiper', CTRL_LISTINGS_ASSETS.'css/swiper-style.css', ['swiper-bundle'], CTRL_LISTINGS_VER);
        wp_register_script('swiper-bundle', CTRL_LISTINGS_ASSETS.'swiper/swiper-bundle.min.js', false , '8.4.5', true);
        wp_register_script('ctrl-listings-swiper', CTRL_LISTINGS_ASSETS.'js/swiper-scripts.js', ['jquery', 'swiper-bundle'] , CTRL_LISTINGS_VER, true);
        
        
        // Leaflet
        wp_register_style('leaflet', CTRL_LISTINGS_ASSETS.'leaflet/leaflet.css', false, '1.9.3');
        wp_register_style('markercluster', CTRL_LISTINGS_ASSETS.'leaflet/MarkerCluster.css', false, '1.4.1');
        wp_register_style('markercluster-default', CTRL_LISTINGS_ASSETS.'leaflet/MarkerCluster.Default.css', false, '1.4.1');
        wp_register_style('ctrl-listings-leaflet', CTRL_LISTINGS_ASSETS.'css/leaflet-style.css', ['leaflet', 'markercluster', 'markercluster-default'], CTRL_LISTINGS_VER);
        wp_register_script('leaflet', CTRL_LISTINGS_ASSETS.'leaflet/leaflet.js', false , '1.9.3', true);
        wp_register_script('leaflet-markercluster', CTRL_LISTINGS_ASSETS.'leaflet/leaflet.markercluster-src.js', false , '1.4.1', true);
        wp_register_script('ctrl-listings-leaflet', CTRL_LISTINGS_ASSETS.'js/leaflet-scripts.js', ['jquery', 'leaflet', 'leaflet-markercluster'] , CTRL_LISTINGS_VER, true);

        
        
    }

    public function enqueue_scripts(){
        //if(!control_listings_is_page()) return;
        $load_bs5_css = apply_filters('control_listings_templates_load_bs5_css', control_listings_setting('load_bs5_css', false));
        if( $load_bs5_css ){
            wp_enqueue_style('bootstrap' );
        }

        $load_bs5_js = apply_filters('control_listings_templates_load_bs5_js', control_listings_setting('load_bs5_js', false));
        if( $load_bs5_js ){
            wp_enqueue_script('bootstrap-bundle' );
        }

        if(apply_filters('control_listings_templates_load_style_css', control_listings_setting('load_style_css', true))){
            wp_enqueue_style('contorl-listings-style', CTRL_LISTINGS_ASSETS.'css/style.css', ['dashicons'], CTRL_LISTINGS_VER);
        }
       

        wp_enqueue_script('ctrl-listings-jsshare', CTRL_LISTINGS_ASSETS.'js/jsshare.js', ['jquery'] , CTRL_LISTINGS_VER, true);
        wp_enqueue_script('contorl-listings-scripts', CTRL_LISTINGS_ASSETS.'js/scripts.js', ['jquery', 'bootstrap-bundle'], CTRL_LISTINGS_VER, true);
        wp_enqueue_script('contorl-listings-searchform', CTRL_LISTINGS_ASSETS.'js/search.js', ['contorl-listings-scripts', 'jquery-ui-slider'], CTRL_LISTINGS_VER, true);
        wp_enqueue_script('contorl-listings-favorites', CTRL_LISTINGS_ASSETS.'favorite/favorites.js', ['contorl-listings-scripts'], CTRL_LISTINGS_VER, true);
        wp_localize_script( 'contorl-listings-scripts', 'CTRLListings', [
			'ajaxUrl'		=> admin_url( 'admin-ajax.php' ),            
			'addNonce'		=> wp_create_nonce( 'add_to_favorites' ),
			'deleteNonce'	=> wp_create_nonce( 'delete_from_favorites' ),
			'nonLoggedIn'	=> ! is_user_logged_in() && ! Settings::get( 'non_logged_in' ),
			'confirmDelete' => __( 'Are you sure to remove this item from favorites?', 'control-listings' ),
			'loginAlert'	=> __( 'Please log in to add this item to favorites', 'control-listings' ),
			'btnUpdateReview'	=> __( 'Update Review', 'control-listings' ),
			'titleUpdateReview'	=> __( 'Update your Review', 'control-listings' ),
			'icon'			=>  [
				'heart'		=> '<path d="M12,4.595c-1.104-1.006-2.512-1.558-3.996-1.558c-1.578,0-3.072,0.623-4.213,1.758c-2.353,2.363-2.352,6.059,0.002,8.412 l7.332,7.332c0.17,0.299,0.498,0.492,0.875,0.492c0.322,0,0.609-0.163,0.792-0.409l7.415-7.415 c2.354-2.354,2.354-6.049-0.002-8.416c-1.137-1.131-2.631-1.754-4.209-1.754C14.513,3.037,13.104,3.589,12,4.595z M18.791,6.205 c1.563,1.571,1.564,4.025,0.002,5.588L12,18.586l-6.793-6.793C3.645,10.23,3.646,7.776,5.205,6.209 c0.76-0.756,1.754-1.172,2.799-1.172s2.035,0.416,2.789,1.17l0.5,0.5c0.391,0.391,1.023,0.391,1.414,0l0.5-0.5 C14.719,4.698,17.281,4.702,18.791,6.205z"/>',
				'star'		=> '<path d="M6.516,14.323l-1.49,6.452c-0.092,0.399,0.068,0.814,0.406,1.047C5.603,21.94,5.801,22,6,22 c0.193,0,0.387-0.056,0.555-0.168L12,18.202l5.445,3.63c0.348,0.232,0.805,0.223,1.145-0.024c0.338-0.247,0.487-0.68,0.372-1.082 l-1.829-6.4l4.536-4.082c0.297-0.268,0.406-0.686,0.278-1.064c-0.129-0.378-0.47-0.644-0.868-0.676L15.378,8.05l-2.467-5.461 C12.75,2.23,12.393,2,12,2s-0.75,0.23-0.911,0.589L8.622,8.05L2.921,8.503C2.529,8.534,2.192,8.791,2.06,9.16 c-0.134,0.369-0.038,0.782,0.242,1.056L6.516,14.323z M9.369,9.997c0.363-0.029,0.683-0.253,0.832-0.586L12,5.43l1.799,3.981 c0.149,0.333,0.469,0.557,0.832,0.586l3.972,0.315l-3.271,2.944c-0.284,0.256-0.397,0.65-0.293,1.018l1.253,4.385l-3.736-2.491 c-0.336-0.225-0.773-0.225-1.109,0l-3.904,2.603l1.05-4.546c0.078-0.34-0.026-0.697-0.276-0.94l-3.038-2.962L9.369,9.997z"/>',
				'pin'		=> '<path d="M12,22l1-2v-3h5c0.553,0,1-0.447,1-1v-1.586c0-0.526-0.214-1.042-0.586-1.414L17,11.586V8c0.553,0,1-0.447,1-1V4 c0-1.103-0.897-2-2-2H8C6.897,2,6,2.897,6,4v3c0,0.553,0.448,1,1,1v3.586L5.586,13C5.213,13.372,5,13.888,5,14.414V16 c0,0.553,0.448,1,1,1h5v3L12,22z M8,4h8v2H8V4z M7,14.414l1.707-1.707C8.895,12.52,9,12.266,9,12V8h6v4 c0,0.266,0.105,0.52,0.293,0.707L17,14.414V15H7V14.414z"/>',
				'like'		=> '<path d="M20,8h-5.612l1.123-3.367c0.202-0.608,0.1-1.282-0.275-1.802S14.253,2,13.612,2H12c-0.297,0-0.578,0.132-0.769,0.36 L6.531,8H4c-1.103,0-2,0.897-2,2v9c0,1.103,0.897,2,2,2h3h10.307c0.829,0,1.581-0.521,1.873-1.298l2.757-7.351 C21.979,12.239,22,12.12,22,12v-2C22,8.897,21.103,8,20,8z M4,10h2v9H4V10z M20,11.819L17.307,19H8V9.362L12.468,4l1.146,0 l-1.562,4.683c-0.103,0.305-0.051,0.64,0.137,0.901C12.377,9.846,12.679,10,13,10h7V11.819z"/>',
				'award'		=> '<path d="M5,8.999c0,1.902,0.765,3.627,2,4.89V21c0,0.347,0.18,0.668,0.474,0.851c0.295,0.184,0.664,0.198,0.973,0.044L12,20.118 l3.553,1.776C15.694,21.965,15.847,22,16,22c0.183,0,0.365-0.05,0.525-0.149C16.82,21.668,17,21.347,17,21v-7.11 c1.235-1.263,2-2.988,2-4.891C19,5.14,15.86,2,12,2S5,5.14,5,8.999z M12.447,18.105c-0.281-0.141-0.613-0.141-0.895,0L9,19.382 v-4.067C9.911,15.749,10.926,16,12,16s2.089-0.25,3-0.685v4.066L12.447,18.105z M12,4c2.756,0,5,2.242,5,4.999 C17,11.757,14.757,14,12,14c-2.757,0-5-2.243-5-5.001C7,6.242,9.243,4,12,4z"/>',
				'hearts'	=> '<path d="M20.205,4.791c-1.137-1.131-2.631-1.754-4.209-1.754c-1.483,0-2.892,0.552-3.996,1.558 c-1.104-1.006-2.512-1.558-3.996-1.558c-1.578,0-3.072,0.623-4.213,1.758c-2.353,2.363-2.352,6.059,0.002,8.412L12,21.414 l8.207-8.207C22.561,10.854,22.562,7.158,20.205,4.791z"/>',
				'stars'		=> '<path d="M21.947,9.179c-0.129-0.378-0.47-0.645-0.868-0.676L15.378,8.05l-2.467-5.461C12.75,2.23,12.393,2,12,2	s-0.75,0.23-0.911,0.588L8.622,8.05L2.921,8.503C2.53,8.534,2.193,8.791,2.06,9.16s-0.039,0.782,0.242,1.056l4.213,4.107	l-1.49,6.452c-0.092,0.399,0.069,0.814,0.406,1.047C5.603,21.94,5.801,22,6,22c0.193,0,0.387-0.056,0.555-0.168L12,18.202	l5.445,3.63c0.348,0.232,0.805,0.223,1.145-0.024c0.338-0.247,0.487-0.68,0.372-1.082l-1.829-6.4l4.536-4.082	C21.966,9.976,22.075,9.558,21.947,9.179z"/>',
				'pins'		=> '<path d="M15,11.586V6h2V4c0-1.104-0.896-2-2-2H9C7.896,2,7,2.896,7,4v2h2v5.586l-2.707,1.707C6.105,13.48,6,13.734,6,14v2 c0,0.553,0.448,1,1,1h2h2v3l1,2l1-2v-3h4c0.553,0,1-0.447,1-1v-2c0-0.266-0.105-0.52-0.293-0.707L15,11.586z"/>',
				'likes'		=> '<path d="M4 21h1V8H4c-1.104 0-2 .896-2 2v9C2 20.104 2.896 21 4 21zM20 8h-7l1.122-3.368C14.554 3.337 13.59 2 12.225 2H12L7 7.438V21h11l3.912-8.596C21.937 12.291 21.976 12.114 22 12v-2C22 8.896 21.104 8 20 8z"/>',
				'awards'	=> '<path d="M5 8.999c0 2.318 1.138 4.371 2.879 5.646l.001.001c.569.416 1.201.749 1.881.979.017.006.034.013.051.019.316.104.643.185.977.243.062.011.124.02.186.028C11.311 15.966 11.65 16 11.999 16 12 16 12 16 12 16c0 0 0 0 0 0 .35 0 .69-.034 1.027-.084.061-.009.121-.018.182-.028.336-.059.664-.139.981-.243.015-.005.028-.011.042-.016C17 14.693 19 12.078 19 8.999 19 5.14 15.86 2 12 2S5 5.14 5 8.999zM12 4c2.756 0 5 2.242 5 4.999h-2C15 7.346 13.654 6 12 6V4zM7.521 16.795l0 5.205L12 20.5l4.479 1.5.001-5.205C15.158 17.557 13.632 18 12 18 10.369 18 8.841 17.557 7.521 16.795z"/>',
			]
		] );

    }
    
    public function admin_enqueue_scripts(){
        wp_enqueue_style('contorl-listings-admin', CTRL_LISTINGS_ASSETS.'admin/style.css', false, CTRL_LISTINGS_VER);
        wp_enqueue_script('contorl-listings-admin', CTRL_LISTINGS_ASSETS.'admin/scripts.js', ['jquery'], CTRL_LISTINGS_VER, true);
        wp_localize_script( 'contorl-listings-admin', 'CTRLListingsAdmin', [
			'ajaxUrl'		=> admin_url( 'admin-ajax.php' )
		] );

        $l10n = [
			'ajax' => admin_url( 'admin-ajax.php' ),
			'nonce' => wp_create_nonce('controlListings'),
		];
		wp_localize_script( 'control-agency-admin', 'controlListingsAdmin', $l10n );
    }
}