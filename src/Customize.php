<?php
namespace ControlListings;

final class Customize{
    private $id = 'listing-options';
    private $parent = 'themes.php';
    private $option_name = 'control_listings_options';
    /**
	 * Add hooks when module is loaded.
	 */
	public function __construct() {        
		add_filter( 'mb_settings_pages', [$this, 'settings_pages'] );   
        add_action( 'rwmb_meta_boxes', [$this, 'settings_fields'] ); 
	}

    private function tabs(){
        return include __DIR__ .'/customize/tabs.php';
    }

    public function settings_pages($settings_pages){
        $settings_pages[] = [
            'menu_title'  => __( 'Control Listings', 'control-listings' ),
            'id'          => $this->id,
            'option_name' => $this->option_name,
			'customizer' => true,
			'customizer_only' => true,
            'parent'      => $this->parent,
            'tabs'        => $this->tabs(),
        ];
        return $settings_pages;
    }

    public function settings_fields($meta_boxes){
        foreach ($this->tabs() as $tab => $value) {
            $file = __DIR__ ."/customize/{$tab}.php";
            if( file_exists($file) ){
                $meta_boxes[] = [
                    'id'             => $tab,
                    'title'          => $value,
                    'settings_pages' => $this->id,
                    'context'        => 'normal',
                    'fields' => include $file,
                    'tab' => $tab
                ];
            }    
        }
        return $meta_boxes;
    }
}