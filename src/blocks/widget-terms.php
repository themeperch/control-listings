<?php 
return [
    'title'           => 'Listings Terms Widget',
    'id'              => 'widget-listing-terms',
    'icon'            => 'admin-post',
    'description'     => 'Display listings categories, tags',
    'fields'          => [
        [
            'type' => 'text',
            'id'   => 'title',
            'std'   => 'Popular categoies',
            'placeholder'   => 'Widget title',
        ],
        [
            'type' => 'select',
            'id'   => 'taxonomy',
            'std'   => 'lising_cat',
            'options'   => [
                'listing_cat' => 'Category',
                'listing_tag' => 'Tag',
            ],
        ],
        [
            'type' => 'select',
            'id'   => 'display',
            'std'   => 'list',
            'options'   => [
                'list' => 'List',
                'inline' => 'Inline',
            ],
        ],
        [
            'type' => 'checkbox',
            'id'   => 'dropdown',
            'desc'   => 'Display as dropdown',
        ],
        [
            'type' => 'checkbox',
            'id'   => 'count',
            'desc'   => 'Show post counts',
            'std'   => true
        ],
        [
            'type' => 'checkbox',
            'id'   => 'parent',
            'desc'   => 'Show only top level categories',
            'std'   => true
        ],
    ],
];