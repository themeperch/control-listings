<?php 
return [
    'title'           => 'Search listings',
    'id'              => 'search-listings',
    'icon'            => 'search',
    'description'     => 'Search lisings with different terms',
    'fields'          => [
        [
            'id' => 'search_placeholder',
            'type' => 'text',
            'name' => __('Search placeholder','control-listings'),
            'std' => __('What are you looking for?', 'control-listings'),
        ],
        [
            'id' => 'enable_age',
            'type' => 'checkbox',
            'desc' => __('Enable age search','control-listings'),
            'std' => true,
        ],
        [
            'id' => 'age_placeholder',
            'type' => 'text',
            'name' => __('Age placeholder','control-listings'),
            'std' => __('Age min-max e.g. 2-10', 'control-listings'),
            'visible' => ['enable_age', '=', true]
        ],
        [
            'id' => 'enable_category',
            'type' => 'checkbox',
            'desc' => __('Enable category search','control-listings'),
            'std' => true,
        ],
        [
            'id' => 'category_placeholder',
            'type' => 'text',
            'name' => __('Category placeholder','control-listings'),
            'std' => __('Category', 'control-listings'),
            'visible' => ['enable_category', '=', true]
        ],
        [
            'id' => 'enable_zip',
            'type' => 'checkbox',
            'desc' => __('Enable ZIP search','control-listings'),
            'std' => false,
        ],
        [
            'id' => 'zip_placeholder',
            'type' => 'text',
            'name' => __('ZIP placeholder','control-listings'),
            'std' => __('Neighborhood or a ZIP code', 'control-listings'),
            'visible' => ['enable_zip', '=', true]
        ],
        [
            'id' => 'button_text',
            'type' => 'text',
            'name' => __('Button text','control-listings'),
            'std' => __('Search', 'control-listings'),
        ],
        [
            'id' => 'footer_text',
            'type' => 'textarea',
            'name' => __('Footer text','control-listings'),
            /* translators: %1$s: total listings, %2$s: Total category  */
            'desc' => sprintf(_x('Use %1$s for total published listings, %2$s for total categories','Toal listing', 'control-listings'), '<code>(total_listings)</code>', '<code>(total_category)</code>'),
            'std' => __('View all (total_listings) kids classes and activities in New York Area', 'control-listings'),
        ],
    ],
];