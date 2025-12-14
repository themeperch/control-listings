<?php
namespace ControlListings;

final class Templates{

    public function __construct() {
        add_filter( 'archive_template', [$this, 'archive_template'] );
        add_filter( 'taxonomy_template', [$this, 'archive_template'] );
        add_filter( 'search_template', [$this, 'archive_template'] );
        add_filter( 'comments_template', [$this, 'comments_template'] );

        add_filter( 'single_template', [$this, 'single_template'] );
        
	}
    

    public function archive_template( $template ) {
    
        if(is_post_type_archive('ctrl_listings')){
            $template_file = control_listings_template('archive-listing.php');
        }

        if(is_tax(['listing_cat', 'listing_tag'])){
            $template_file = control_listings_template('archive-listing.php');
        }
        
        
        if ( !empty($template_file) ) {
            $template = $template_file;
        }

        
        return $template;
    }

    public function single_template( $template ) {       

        $post_type = get_post_type();
        switch ($post_type) {
           
            case 'ctrl_listings':           

                    if ( is_singular ( $post_type )  ) {            
                        $template_file = control_listings_template('single-listing.php');          
                    }                    
                break;    
            
            default:
                
                break;
        }


        if ( !empty($template_file) ) {
            $template = $template_file;
        }
       
        return $template;
    }

    public function comments_template($template){
        if(get_post_type() == 'ctrl_listings'){
            $template = control_listings_template('single/comments.php');
        }
        return $template;
    }
    
}