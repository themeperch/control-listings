<?php
return [
    [
        'id'                => $prefix . 'event_plans',
        'type'              => 'group',
        'clone'             => true,
        'clone_default'     => true,
        'clone_as_multiple' => true,
        'max_clone'         => 7,
        'add_button'        => __( 'Add Event', 'control-listings' ),
        'fields'            => [
            [
                'name' => __( 'Event image', 'control-listings' ),
                'id'   => $prefix . 'image',
                'type' => 'single_image',
                'max_file_uploads' => 1,
            ],
            [
                'name' => __( 'Title', 'control-listings' ),
                'id'   => $prefix . 'title',
                'type' => 'text',
            ],
            [
                'name' => __( 'Location', 'control-listings' ),
                'id'   => $prefix . 'location',
                'type' => 'text',
            ],
            [
                'name' => __( 'Start Date', 'control-listings' ),
                'id'   => $prefix . 'start_date',
                'type' => 'datetime',
            ],
            [
                'name' => __( 'End Date', 'control-listings' ),
                'id'   => $prefix . 'end_date',
                'type' => 'datetime',
            ],            
            [
                'name' => __( 'Description', 'control-listings' ),
                'id'   => $prefix . 'desc',
                'type' => 'textarea',
            ],
            [
                'name' => __( 'Link text', 'control-listings' ),
                'id'   => $prefix . 'link_text',
                'type' => 'text',
            ],
            [
                'name' => __( 'Link', 'control-listings' ),
                'id'   => $prefix . 'link',
                'type' => 'text',
            ],
            
        ],
        'tab'               => $tab,
    ],
    [
        'name' => __( 'Sponsors?', 'control-listings' ),
        'id'   => $prefix . 'enable_sponsors',
        'type' => 'checkbox',
        'desc' => __( 'Yes', 'control-listings' ),
        'tab'               => $tab,
    ],
    [
        'id'                => $prefix . 'sponsors',
        'type'              => 'group',
        'clone'             => true,
        'clone_default'     => true,
        'clone_as_multiple' => true,        
        'add_button'        => __( 'Add Sponsor', 'control-listings' ),
        'visible' => [$prefix . 'enable_sponsors', '=', true],
        'fields'            => [
            [
                'name' => __( 'Sponsor Title', 'control-listings' ),
                'id'   => $prefix . 'title',
                'type' => 'text',
            ],
            [
                'name' => __( 'Sponsor Logo', 'control-listings' ),
                'id'   => $prefix . 'image',
                'type' => 'single_image',
                'max_file_uploads' => 1,
            ],
            [
                'name' => __( 'Sponsor Website', 'control-listings' ),
                'id'   => $prefix . 'website',
                'type' => 'text',
            ],
        ],
        'tab'               => $tab,
    ],
];