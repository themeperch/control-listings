<?php
defined( 'ABSPATH' ) || exit;
return array(
    'title'      => ' ',
    'taxonomies' => 'listing_cat', 

    'fields' => array(
        array(
            'name' => 'Category image',
            'id'   => 'image',
            'type' => 'single_image',
        ),
        array(
            'name' => 'Marker icon',
            'id'   => 'icon',
            'type' => 'select',
            'inline' => true,
            'std' => 'child',
            'options' => control_listings_marker_icon_options()
        ),
        
    ),
);