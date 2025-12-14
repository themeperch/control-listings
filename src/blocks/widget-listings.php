<?php 
return [
    'title'           => 'Listings Widget',
    'id'              => 'widget-listings',
    'icon'            => 'admin-post',
    'description'     => 'Display listings template',
    'fields'          => [
        [
            'type' => 'text',
            'id'   => 'title',
            'name' => 'Title',
            'std' => 'Featured Activities',
        ],
        [
            'type' => 'select',
            'id'   => 'type',
            'std' => 'featured',
            'options' => [
                'featured' => 'Display Featured Listings',
                'new' => 'Display New Listings',
                'popular' => 'Display Popular Listings',
            ],
        ],  
        [
            'type' => 'number',
            'id'   => 'posts_per_page',
            'name' => 'Total',
            'std' => '5',
            'min' => 1,
            'max' => 10,
            'step' => 1
            
        ],      
        
    ],
];