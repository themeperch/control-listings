<?php
return [
    
    [
        'name' => __( 'Full Address', 'control-listings' ),
        'id'   => 'address_listing',
        'type' => 'text',
        'tab'  => $tab
    ],
    [
        'name'          => __( 'Building', 'control-listings' ),
        'id'            => $prefix . 'building',
        'type'          => 'text',
        'binding'       => 'building',
        'address_field' => 'address_listing',
        'tab'           => $tab
    ],
    [
        'name'          => __( 'House number', 'control-listings' ),
        'id'            => $prefix . 'house_number',
        'type'          => 'text',
        'binding'       => 'house_number',
        'address_field' => 'address_listing',
        'tab'           => $tab
    ],
    [
        'name'          => __( 'Street Address', 'control-listings' ),
        'id'            => $prefix . 'street_address',
        'type'          => 'text',
        'binding'       => 'road',
        'address_field' => 'address_listing',
        'tab'           => $tab
    ],
    [
        'name'          => __( 'Town', 'control-listings' ),
        'id'            => $prefix . 'town',
        'type'          => 'text',
        'address_field' => 'address_listing',
        'binding'       => 'town',
        'tab'           => $tab
    ],
    [
        'name'          => __( 'City', 'control-listings' ),
        'id'            => $prefix . 'city',
        'type'          => 'text',
        'address_field' => 'address_listing',
        'binding'       => 'city',
        'tab'           => $tab
    ],
    [
        'name'          => __( 'State', 'control-listings' ),
        'id'            => $prefix . 'state',
        'type'          => 'text',
        'address_field' => 'address_listing',
        'binding'       => 'state',
        'tab'           => $tab
    ],
    [
        'name'          => __( 'Postcode', 'control-listings' ),
        'id'            => $prefix . 'postcode',
        'type'          => 'text',
        'binding'       => 'postcode',
        'address_field' => 'address_listing',
        'tab'           => $tab
    ],
    [
        'name'          => __( 'Country', 'control-listings' ),
        'id'            => $prefix . 'country',
        'type'          => 'text',
        'binding'       => 'country',
        'address_field' => 'address_listing',
        'tab'           => $tab
    ],
    [
        'name'          => __( 'Country Code', 'control-listings' ),
        'id'            => $prefix . 'country_code',
        'type'          => 'text',
        'binding'       => 'country_code',
        'address_field' => 'address_listing',
        'tab'           => $tab
    ],
    [
        'name'          => __( 'Geometry', 'control-listings' ),
        'id'            => $prefix . 'geometry',
        'type'          => 'text',
        'desc'          => 'latitude,longitude',
        'binding'       => 'geometry',
        'address_field' => 'address_listing', 
        'tab'           => $tab
    ],
    [
        'name'          => __( 'Location', 'control-listings' ),
        'id'            => $prefix . 'map',
        'type'          => 'osm',
        'address_field' => 'address_listing',
        'language'      => 'en',
        'region'        => 'bd',
        'tab'           => $tab
    ]
];