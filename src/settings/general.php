<?php
$currency_code_options = get_control_listings_currencies();

foreach ( $currency_code_options as $code => $name ) {
    $currency_code_options[ $code ] = $name . ' (' . get_control_listings_currency_symbol( $code ) . ')';
}
return [
    [
        'type' => 'custom_html',
        'desc' => sprintf('<h3 style="margin-bottom: 0">%s</h3><p style="margin-top: 0">%s</p>', __( 'Currency options', 'control-listings' ), __( 'The following options affect how prices are displayed on the frontend.', 'control-listings' ))
    ],
    [
        'name'    => __( 'Currency', 'control-listings' ),
        'desc'     => __( 'This controls what currency prices are listed at in the catalog and which currency gateways will take payments in.', 'control-listings' ),
        'id'       => 'currency',
        'std'  => 'USD',
        'type'     => 'select_advanced',
        'options'  => $currency_code_options,
    ],

    [
        'name'    => __( 'Currency position', 'control-listings' ),
        'desc'     => __( 'This controls the position of the currency symbol.', 'control-listings' ),
        'id'       => 'currency_pos',
        'class'    => 'wc-enhanced-select',
        'std'  => 'left',
        'type'     => 'select',
        'options'  => [
            'left'        => __( 'Left', 'control-listings' ),
            'right'       => __( 'Right', 'control-listings' ),
            'left_space'  => __( 'Left with space', 'control-listings' ),
            'right_space' => __( 'Right with space', 'control-listings' ),
        ],
    ],

    [
        'name'    => __( 'Thousand separator', 'control-listings' ),
        'desc'     => __( 'This sets the thousand separator of displayed prices.', 'control-listings' ),
        'id'       => 'price_thousand_sep',
        'css'      => 'width:50px;',
        'std'  => ',',
        'type'     => 'text',
    ],

    [
        'name'    => __( 'Decimal separator', 'control-listings' ),
        'desc'     => __( 'This sets the decimal separator of displayed prices.', 'control-listings' ),
        'id'       => 'price_decimal_sep',
        'css'      => 'width:50px;',
        'std'  => '.',
        'type'     => 'text',
    ],

    [
        'name'             => __( 'Number of decimals', 'control-listings' ),
        'desc'              => __( 'This sets the number of decimal points shown in displayed prices.', 'control-listings' ),
        'id'                => 'price_num_decimals',
        'css'               => 'width:50px;',
        'std'           => '2',
        'type'              => 'number',
        'attributes' => [
            'min'  => 0,
            'step' => 1,
        ],
    ],
    [
        'type' => 'custom_html',
        'desc' => sprintf('<h3 style="margin-bottom: 0">%s</h3><p style="margin-top: 0">%s</p>', __( 'Business Address', 'control-listings' ), __( 'This is where your business is located.', 'control-listings' ))
    ],   
    [
        'name'          => __( 'Address line 1 ', 'control-listings' ),
        'id'            => 'address_line_1',
        'type'          => 'text',
        'desc'     => __( 'The street address for your business location.', 'control-listings' ),
        'address_field' => 'address_listing',        
        'binding'       => 'administrative_area_level_1', 
    ],
    [
        'name'          => __( 'Address line 2 ', 'control-listings' ),
        'id'            => 'address_line_2',
        'type'          => 'text',
        'desc'     => __( 'An additional, optional address line for your business location.', 'control-listings' ),
        'address_field' => 'address_listing',
        'binding'       => 'administrative_area_level_2', 
    ],
    [
        'name'          => __( 'City', 'control-listings' ),
        'id'            => 'city',
        'type'          => 'text',
        'desc'     => __( 'The city in which your business is located.', 'control-listings' ),
        'address_field' => 'address_listing',
        'binding'       => 'city', 
    ],
    [
        'name'          => __( 'State', 'control-listings' ),
        'id'            => 'state',
        'type'          => 'text',
        'desc'     => __( 'The country and state or province, if any, in which your business is located.', 'control-listings' ),
        'address_field' => 'address_listing',
        'binding'       => 'state', 
    ],
    [
        'name'          => __( 'Postcode/ZIP', 'control-listings' ),
        'id'            => 'postcode',
        'type'          => 'text',
        'desc'     => __( 'The postal code, if any, in which your business is located.', 'control-listings' ),
        'binding'       => 'postcode',
        'address_field' => 'address_listing', 
    ],
    [
        'name'          => __( 'Country', 'control-listings' ),
        'id'            => 'country',
        'type'          => 'text',
        'binding'       => 'country',
        'address_field' => 'address_listing', 
    ],
    [
        'name'          => __( 'Country Code', 'control-listings' ),
        'id'            => 'country_code',
        'type'          => 'text',
        'binding'       => 'country_code',
        'address_field' => 'address_listing', 
    ],
    [
        'name' => __( 'Full Address', 'control-listings' ),
        'id'   => 'address_listing',
        'type' => 'text',
    ],
    [
        'name'          => __( 'Geometry', 'control-listings' ),
        'id'            => 'geometry',
        'type'          => 'text',
        'desc'          => 'latitude,longitude',
        'binding'       => 'geometry',
        'address_field' => 'address_listing', 
    ],
    [
        'name'          => __( 'Location', 'control-listings' ),
        'id'            => 'map',
        'type'          => 'osm',
        'address_field' => 'address_listing',
        'language'      => 'en',
        'region'        => 'bd', 
    ],
    
    
    
];