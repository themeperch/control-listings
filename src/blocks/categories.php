<?php 
return [
    'title'           => 'Listings Categories',
    'id'              => 'listing-categories',
    'icon'            => 'admin-post',
    'description'     => 'Display listings categories',
    'fields'          => [
        [
            'type' => 'checkbox',
            'id'   => 'display_all',
            'display'   => 'Display all categories',
            'std' => true            
        ],
        [
            'type' => 'taxonomy_advanced',
            'id'   => 'listing_cats',
            'name' => 'Choose listing categoies',
            'taxonomy'   => 'listing_category',
            'field_type' => 'checkbox_list',
            'hidden' => ['display_all', '=', true]
        ],        
        [
            'type' => 'select',
            'id'   => 'column',
            'name' => 'Column',
            'std' => '4',
            'options' => [
                '1' => 'Single column',
                '2' => '2 column',
                '3' => '3 column',
                '4' => '4 column',
            ],
        ],
          
        
    ],
];