<?php
return [
    [
        'id'   => $prefix . 'enable_awards',
        'type' => 'checkbox',
        'desc' => __( 'Enable awards?', 'control-listings' ),
        'tab'               => $tab,
    ],
    [
        'id'                => $prefix . 'awards',
        'name' =>           __( 'Awards', 'control-listings' ),
        'type'              => 'group',
        'clone'             => true,
        'clone_default'     => true,
        'clone_as_multiple' => true,        
        'add_button'        => __( 'Add awards', 'control-listings' ),
        'visible' => [$prefix . 'enable_awards', '=', true],
        'fields'            => [
            [
                'name' => __( 'Title', 'control-listings' ),
                'id'   => $prefix . 'title',
                'type' => 'text',
            ],
            [
                'name' => __( 'Image', 'control-listings' ),
                'id'   => $prefix . 'image',
                'type' => 'single_image',
                'max_file_uploads' => 1,
            ],
            [
                'name' => __( 'Wininig year', 'control-listings' ),
                'id'   => $prefix . 'year',
                'type' => 'text',
            ],
            [
                'name' => __( 'Description', 'control-listings' ),
                'id'   => $prefix . 'desc',
                'type' => 'textarea',
            ],
        ],
        'tab'               => $tab,
    ],
   
];