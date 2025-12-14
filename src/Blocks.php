<?php
namespace ControlListings;

final class Blocks{
    /**
	 * Add hooks when module is loaded.
	 */
	public function __construct() {  
        add_filter( 'block_categories_all', [$this, 'category'] );       
		add_action( 'rwmb_meta_boxes', [$this, 'blocks'] );    
	}  
    
    public function category( $categories ) {
        // Adding a new category.
        $categories[] = array(
            'slug'  => 'control-listings',
            'title' => 'Control Listings'
        );        
    
        return $categories;
    }

    public function blocks($blocks){  
        // elements      
        foreach (glob(__DIR__ ."/blocks/*.php") as $filename) {
            $block = include $filename;
            $blocks[] = $this->configure_block($block);
        }  
       

        return $blocks;        
    }

    private function configure_block($block){         

        $configuration = [
            'type'            => 'block',            
            'category'        => 'control-listings',
            'context'         => 'side',
            'render_callback' => 'control_listings_render_block_template',
            'preview' => $this->block_preview_args($block),
            'supports' => [
                'align' => false,
                'customClassName' => false,
                'anchor' => false
            ],
        ];
        $block['fields'] = $this->set_block_common_field($block['fields']);
        
        return array_merge($configuration, $block);        
    }

    private function block_preview_args($block){
        return array_column($block['fields'], 'std', 'id');
    }

    private function set_block_common_field($fields){
        $new_fields = [  
            [
                'type' => 'select',
                'id'   => 'align',
                'name' => 'Align',
                'options' => [
                    '' => 'Inherit',
                    'text-start' => 'Left',
                    'text-center' => 'Center',
                    'text-end' => 'Right',
                ]
            ],          
            [
                'id' => 'css_class',
                'type' => 'text',
                'name' => 'CSS class'
            ],
            [
                'id' => 'css_id',
                'type' => 'text',
                'name' => 'CSS ID'
            ],
        ];
        return array_merge($fields, $new_fields);
    }

    
}