<?php 
defined( 'ABSPATH' ) || exit;
return [
    'title'           => 'Listings',
    'id'              => 'listings',
    'icon'            => 'admin-post',
    'description'     => 'Display listings template',
    'fields'          => [
        [
            'type' => 'checkbox_list',
            'id'   => 'display',
            'std' => ['featured', 'new', 'popular'],
            'options' => [
                'featured' => 'Display Featured Listings',
                'new' => 'Display New Listings',
                'popular' => 'Display Popular Listings',
            ],
        ],
        [
            'type' => 'text',
            'id'   => 'featured_title',
            'name' => 'Featured tab title',
            'std' => 'Featured Activities',
            'visible' => ['display', 'contains', 'featured']
        ],
        [
            'type' => 'text',
            'id'   => 'new_title',
            'name' => 'New tab title',
            'std' => 'New Activities',
            'visible' => ['display', 'contains', 'new']
        ],
        [
            'type' => 'text',
            'id'   => 'popular_title',
            'name' => 'Popupular tab title',
            'std' => 'Popular Activities',
            'visible' => ['display', 'contains', 'popular']
        ],
        [
            'type' => 'select',
            'id'   => 'column',
            'name' => 'Column',
            'std' => '3',
            'options' => [
                '1' => 'Single column',
                '2' => '2 column',
                '3' => '3 column',
                '4' => '4 column',
                '5' => '5 column',
                '6' => '6 column',
            ],
        ],
        [
            'type' => 'number',
            'id'   => 'posts_per_page',
            'name' => 'Total',
            'std' => '6',
            'min' => 1,
            'max' => 10,
            'step' => 1
            
        ],      
        
    ],
];