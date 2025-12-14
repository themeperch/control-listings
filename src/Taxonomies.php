<?php
namespace ControlListings;

final class Taxonomies{
    /**
	 * Add hooks when module is loaded.
	 */
	public function __construct() {        
		add_action( 'init', [$this, 'register_taxonomies'] );   
        add_filter( 'rwmb_meta_boxes', [$this, 'register_taxonomy_meta_boxes'] );    
	}

    public function register_taxonomies(){
        $taxonomies = [
            'listing_cat' => include __DIR__ ."/taxonomies/category.php",
            'listing_tag' => include __DIR__ ."/taxonomies/tag.php",
        ];

        foreach ($taxonomies as $taxonomy => $args) {
            register_taxonomy( $taxonomy, ['ctrl_listings'], $args );
        }
        
    }

    public function register_taxonomy_meta_boxes($meta_boxes){
        $meta_boxes[] = include __DIR__ ."/taxonomies/category-meta.php";
        return $meta_boxes;
    }
}