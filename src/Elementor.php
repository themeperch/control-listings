<?php
namespace ControlListings;

class Elementor{
    /**
	 * Add hooks when module is loaded.
	 */
	public function __construct() {        
		add_action( 'elementor/widgets/register', [$this, 'register_widget'] );  
        add_action( 'elementor/elements/categories_registered', [$this, 'add_widget_categories'] );    
	}

    public function register_widget($widgets_manager){
        $widgets_manager->register( new Widgets\Slider() );
        $widgets_manager->register( new Widgets\Listing_Info() );
        $widgets_manager->register( new Widgets\Listing_Videos() );
        $widgets_manager->register( new Widgets\About_Listing() );        
        $widgets_manager->register( new Widgets\Listing_Speakers() );        
        $widgets_manager->register( new Widgets\Listing_Testimonials() );        
        $widgets_manager->register( new Widgets\Listing_Pricing_Tables() );        
        $widgets_manager->register( new Widgets\Listing_FAQs() );        
        $widgets_manager->register( new Widgets\Listing_Gallery() );        
        $widgets_manager->register( new Widgets\Listing_Contact() );        
        $widgets_manager->register( new Widgets\Listing_News() );        
    }

    public function add_widget_categories( $elements_manager ) {

        $elements_manager->add_category(
            'control-listings',
            [
                'title' => esc_html__( 'Control Listings', 'control-listings' ),
                'icon' => 'fa fa-plug',
            ]
        );
    
    }
    
    
}