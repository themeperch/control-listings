<?php
defined( 'ABSPATH' ) || exit;
return [
    [
        'id'         => 'load_bs5_css',
        'name'      => __('Load bootrap5 CSS', 'control-listings'),
        'type'       => 'checkbox',
        'std'  => apply_filters('control_listings_templates_load_bs5_css', true),
        'desc' => __('Enable', 'control-listings'),
        'attributes' => has_filter('control_listings_templates_load_bs5_css')? ['disabled' => true] : [],
        'label_description' => has_filter('control_listings_templates_load_bs5_js')? 'Filtered by theme or other plugin' : '',       
       
    ],
    [
        'id'         => 'load_bs5_js',
        'name'      => __('Load bootrap5 Bundle JS', 'control-listings'),
        'type'       => 'checkbox',
        'std'  => apply_filters('control_listings_templates_load_bs5_css', true),
        'desc' => __('Enable', 'control-listings'),
        'attributes' => has_filter('control_listings_templates_load_bs5_js')? ['disabled' => true] : [],       
        'label_description' => has_filter('control_listings_templates_load_bs5_js')? 'Filtered by theme or other plugin' : '',       
       
    ],
    
];