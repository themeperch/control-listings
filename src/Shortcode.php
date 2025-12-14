<?php
namespace ControlListings;

final class Shortcode{
    /**
	 * Add hooks when module is loaded.
	 */
	public function __construct() {        
		add_shortcode( 'control_listings_single', [$this, 'single_listing'] );    
		add_shortcode( 'control_listings_dashboard', [$this, 'dashboard'] );   
        
        
	}

    public function single_listing(){
        ob_start();
        control_listings_template_part('single-event');
        return ob_get_clean();
    }

    public function dashboard(){
    
        ob_start();
        if(!is_user_logged_in()){
            control_listings_locate_template('my-account/login-registration.php');
        }else{
            control_listings_locate_template('my-account/dashboard.php');
        }
        
        return ob_get_clean();
    }

    

    
}