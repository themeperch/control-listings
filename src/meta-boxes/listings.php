<?php
defined( 'ABSPATH' ) || exit;
$prefix = '';
$tabs = [
    'general'     => [
        'label' => 'General Information',
        'icon'  => 'dashicons-info',
    ],
    'contact'     => [
        'label' => 'Enquiry & Contact',
        'icon'  => 'dashicons-sos',
    ],
    'features'     => [
        'label' => 'Features & Specialities',
        'icon'  => 'dashicons-plugins-checked',
    ],    
    'awards' => [
        'label' => 'Awards Wining',
        'icon'  => 'dashicons-awards',
    ],
    'media' => [
        'label' => 'Media Gallery',
        'icon'  => 'dashicons-admin-media',
    ],    
    'events' => [
        'label' => 'Events & Sponsors',
        'icon'  => 'dashicons-megaphone',
    ],
    'faqs' => [
        'label' => 'FAQs',
        'icon'  => 'dashicons-editor-help',
    ],
    'working-hours' => [
        'label' => 'Working Hours',
        'icon'  => 'dashicons-share-alt',
    ],
    'location'    => [
        'label' => 'Location Details',
        'icon'  => 'dashicons-location-alt',
    ],
];

$tabs = apply_filters('control_listings_listing_data_tabs', $tabs);

$fields = [];
foreach ($tabs as $tab => $value) {
    $file = __DIR__ ."/listings/{$tab}.php";
    if( file_exists($file) ){
        $new_fields = include $file;
        $new_fields = apply_filters("control_listings_listing_data_{$tab}_fields", $new_fields);
        $fields = array_merge($fields, $new_fields);
    }    
}


return [
    'title'      => apply_filters('control_listings_listing_data_meta_box_title', __( 'Listing data', 'control-listings' )),
    'id'         => 'control-listing-data',
    'post_types' => ['ctrl_listings'],
    'tab_style'  => 'left',
    'geo'        => true,
    'tabs'       => $tabs,
    'fields'     => $fields
];