<?php
defined( 'ABSPATH' ) || exit;
return [
    [
        'name'          => __( 'Logo', 'control-listings' ),
        'id'            => $prefix . 'logo',
        'type'          => 'single_image',
        'max_file_uploads' => 1,
        'desc' => 'Upload your institution logo',
        'admin_columns' => [
            'position'   => 'before title'
        ],
        'tab'           => $tab
    ],
    [
        'name'     => __( 'Slogan', 'control-listings' ),
        'id'       => $prefix . 'slogan',
        'type'     => 'textarea',
        'tab'      => $tab
    ],
    [
        'name'          => __( 'Age limit minimum', 'control-listings' ),
        'id'            => $prefix . 'min_age',
        'type'          => 'number', 
        'append'        => 'Year',  
        'desc'          => __( 'Number only', 'control-listings' ),
        'tab'           => $tab
    ], 
    [
        'name'          => __( 'Age limit maximum', 'control-listings' ),
        'id'            => $prefix . 'max_age',
        'type'          => 'number',   
        'append'        => 'Year',  
        'desc'          => __( 'Number only', 'control-listings' ),  
        'tab'           => $tab
    ], 
    [
        'name'          => __( 'Price limit minimum', 'control-listings' ),
        'id'            => $prefix . 'min_price',
        'type'          => 'number',
        'append'        => get_control_listings_currency(),   
        'desc'          => __( 'Number only', 'control-listings' ),
        'tab'           => $tab
    ], 
    [
        'name'          => __( 'Price limit maximum', 'control-listings' ),
        'id'            => $prefix . 'max_price',
        'type'          => 'number',   
        'append'        => get_control_listings_currency(),    
        'desc'          => __( 'Number only', 'control-listings' ), 
        'tab'           => $tab
    ],    
    [
        'name'     => __( 'Address', 'control-listings' ),
        'id'       => $prefix . 'address',
        'type'     => 'text',
        'tab'      => $tab
    ],
    [
        'name'     => __( 'Opening & Closing time', 'control-listings' ),
        'id'       => $prefix . 'opening_closing_time',
        'type'     => 'text',
        'tab'      => $tab
    ],
    
    
];