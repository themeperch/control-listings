<?php
defined( 'ABSPATH' ) || exit;
return [
    [
        'id'   => $prefix . 'enable_gallery',
        'type' => 'checkbox',
        'desc' => __( 'Enable banner slider', 'control-listings' ),
        'tab'               => $tab,
    ],
    [
        'id'                => $prefix . 'gallery',
        'name'              => __( 'Slider images', 'control-listings' ),
        'type'              => 'group',
        'clone'             => true,
        'clone_default'     => true,
        'clone_as_multiple' => true,
        'collapsible'   => true,
        'default_state'   => 'collapsed',
        'group_title'   => '{#}. {title}',
        'add_button'        => __( 'Add Image', 'control-listings' ),
        'visible' => [$prefix . 'enable_gallery', '=', true],
        'fields'            => [
            [
                'name' => __( 'Image Title', 'control-listings' ),
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
                'name' => __( 'Image Description', 'control-listings' ),
                'id'   => $prefix . 'desc',
                'type' => 'textarea',
            ],
        ],
        'tab'               => $tab,
    ],
    [
        'name' => __( 'Image Gallery', 'control-listings' ),
        'id'   => $prefix . 'lising_images',
        'type' => 'image_advanced',
        'max_file_uploads' => 8,
        'tab'               => $tab,
    ],
    [
        'id'   => $prefix . 'enable_videos',        
        'type' => 'checkbox',
        'desc' => __( 'Enable Video gallery', 'control-listings' ),
        'tab'               => $tab,
    ],
    [
        'id'                => $prefix . 'videos',
        'name'              => __( 'Video gallery', 'control-listings' ),
        'type'              => 'group',
        'clone'             => true,
        'clone_default'     => true,
        'clone_as_multiple' => true,
        'collapsible'   => true,
        'default_state'   => 'collapsed',
        'group_title'   => '{#}. {title}',
        'add_button'        => __( 'Add Video', 'control-listings' ),
        'visible' => [$prefix . 'enable_videos', '=', true],
        'fields'            => [
            [
                'name' => __( 'Video Title', 'control-listings' ),
                'id'   => $prefix . 'title',
                'type' => 'text',
            ],
            [
                'name' => __( 'Video Image', 'control-listings' ),
                'id'   => $prefix . 'image',
                'type' => 'single_image',
                'max_file_uploads' => 1,
            ],
            [
                'name' => __( 'Video link', 'control-listings' ),
                'id'   => $prefix . 'link',
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