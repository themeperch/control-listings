<?php
namespace ControlListings;
defined( 'ABSPATH' ) || exit;

final class Settings{
    private $id = 'listing-settings';
    private $parent = 'edit.php?post_type=ctrl_listings';
    private $option_name = 'control_listings';
    /**
	 * Add hooks when module is loaded.
	 */
	public function __construct() {       
		add_filter( 'mb_settings_pages', [$this, 'settings_pages'] );   
        add_action( 'rwmb_meta_boxes', [$this, 'settings_fields'] ); 
        add_filter( 'display_post_states', [$this, 'display_post_states'], 10, 2 );
        add_filter( 'mb_settings_pages', [ $this, 'register_settings_page' ], 9999 );
        add_action( 'mb_settings_page_submit_buttons', [$this, 'settings_page_submit_buttons'] );
        add_action( 'mb_settings_page_after_title', [$this, 'settings_page_after_title'] );
	}

    private static function tabs(){
        return include __DIR__ .'/settings/tabs.php';
    }

    private static function fields($tab = false){
        $fields = [];
        if(!empty($tab)){
            $file = __DIR__ ."/settings/{$tab}.php";
            if( file_exists($file) ) {
                $fields  =  include $file;                
            }
        }else{            
            foreach (self::tabs() as $tab => $value) {
                $file = __DIR__ ."/settings/{$tab}.php";
                if( !file_exists($file) ) continue;

                $new_fields  =  include $file;
                $fields = array_merge($fields, $new_fields);                               
            }
        }    
        
        return $fields;
        
    }

    public function settings_pages($settings_pages){
        $settings_pages[] = [
            'menu_title'  => __( 'Settings', 'control-listings' ),
            'id'          => $this->id,
            'option_name' => $this->option_name,
            'position'    => 0,
            'parent'      => $this->parent,
            'style'       => 'no-boxes',
            'columns'     => 2,
            'class'     => 'control-listings-settings-page',
            'tabs'        => $this->tabs(),
            'icon_url'    => 'dashicons-admin-generic',
        ];
        return $settings_pages;
    }

    public function register_settings_page( $settings_pages ) {
        if(!empty($settings_pages)){
            foreach ($settings_pages as $key => $settings_page) {
                if($settings_page['id'] == 'user-profile'){
                    $settings_page['parent'] = $this->parent;
                }
                $settings_pages[$key] = $settings_page;
            }
        }		

		return $settings_pages;
	}

    public function settings_fields($meta_boxes){
        foreach (self::tabs() as $tab => $value) {            
            $meta_boxes[] = [
                'id'             => $tab,
                'title'          => $value,
                'settings_pages' => $this->id,
                'context'        => 'normal',
                'fields' => self::fields($tab),
                'tab' => $tab
            ];               
        }
        $meta_boxes = $this->get_sidebar_fields($meta_boxes);
        return $meta_boxes;
    }

    

    public static function get( $name, $default = null ) {
		$option = get_option( 'control_listings' );
		$default_values = array_column(self::fields(), 'std', 'id');
        
		return $option[ $name ] ?? $default_values[ $name ] ?? $default;
	}

    function display_post_states( $post_states, $post ) {
        $pages = [
            'listing_archive_page' => __( 'Listings Archive Page', 'control-listings' ),
            'my_account_page' => __( 'Listings Dashboard Page', 'control-listings' ),
            'post_listing_page' => __( 'Add Listing Page', 'control-listings' ),
        ];
        foreach ($pages as $option_id => $title) {
            $page_id = control_listings_setting( $option_id );
            $post_exists = (new \WP_Query(['post_type' => 'any', 'p'=>$page_id]))->found_posts > 0;
            if($post_exists && $page_id == $post->ID){
            $post_states[ ] = $title;			
            }
        } 
                
        return $post_states;
    }

    public function settings_page_after_title(){
        printf(
            '<div id="control-listings-settings-page-notice" class="notice notice-info"><p><strong>%s</strong> %s</p></div>', 
            esc_attr__('Note:', 'control-listings'),
            /* translators: %s: Admin links  */
            sprintf(esc_attr__('If the archive page isn\'t functioning properly, try refreshing the %s. For optimal performance, consider using Pretty permalinks (e.g., Post name, Day and name, etc.). This can enhance the usability and SEO-friendliness of your site.
            ', 'control-listings'), 
            sprintf('<a href="'.esc_url(admin_url('options-permalink.php')).'" target="_blank"><strong>%s</strong></a>', esc_attr__('Permalink Settings', 'control-listings'))),
        ); 
    }

    public function settings_page_submit_buttons(){
        $options = get_option($this->option_name, []);
        if(!empty($options)){
            printf('<a href="#" class="button button-danger controlListingsReset" data-option_name="%s">%s</a>', esc_attr($this->option_name), esc_attr__('Reset', 'control-listings') );
        }
        
    }

    public function get_sidebar_fields($meta_boxes){     
           
        
        ob_start();
        include __DIR__ .'/about/plugin-info.php';
        $plugin_info = ob_get_clean();
       

        $meta_boxes[] = array (
            'title' => esc_attr__('Help & Support', 'control-listings'),
            'id' => 'sidebar-support-settings',
            'context' => 'side',	
            'text_domain' => 'control-listings',
            'fields' => array(
                array(
                    'type' => 'custom_html',
                    'std' => '<div class="control-listings-settings-sidebar">'.$plugin_info.'</div>',                        
                )
    
            ),			
            'settings_pages' => $this->id,
        );  
        
        

         return $meta_boxes;
    }
}