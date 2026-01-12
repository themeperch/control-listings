<?php
defined( 'ABSPATH' ) || exit;
return [    
    [
        'name' => __( 'Website', 'control-listings' ),
        'id'   => $prefix . 'website',
        'type' => 'text',
        'placeholder' => 'httpss://',
        'tab'  => $tab
    ],
    [
        'name' => __( 'Email', 'control-listings' ),
        'id'   => $prefix . 'email',
        'type' => 'text',
        'desc' => __( 'Separate emails with commas', 'control-listings' ),
        'tab'  => $tab
    ],
    [
        'name' => __( 'Phone', 'control-listings' ),
        'id'   => $prefix . 'phone',
        'type' => 'text',
        'desc' => __( 'Separate phones with commas', 'control-listings' ),
        'tab'  => $tab
    ],
    [
        'name' => __( 'FAX', 'control-listings' ),
        'id'   => $prefix . 'fax',
        'type' => 'text',
        'desc' => __( 'Separate faxs with commas', 'control-listings' ),
        'tab'  => $tab
    ],
    [
        'id'                => $prefix . 'buttons',
        'type'              => 'group',
        'clone'             => false,
        'clone_default'     => true,
        'clone_as_multiple' => true,
        'collapsible'   => false,
        'fields'            => [
            [
                'name' => __( 'Enquiry Button Title', 'control-listings' ),
                'id'   => $prefix . 'title',
                'type' => 'text',
                'std' => 'Book Now',
            ],            
            [
                'name' => __( 'Enquiry Button Link', 'control-listings' ),
                'id'   => $prefix . 'link',
                'type' => 'text',
                'std' => '#'
            ],
        ],
        'std' => [
            [
                'title' => 'Book Now',
                'link' => '#',
            ],            
        ],
        'tab'               => $tab,
    ],
    [
        'id'                => $prefix . 'social_links',
        'name'              => __( 'Social links', 'control-listings' ),
        'type'              => 'group',
        'clone'             => true,
        'clone_default'     => true,
        'clone_as_multiple' => true,
        'collapsible'   => true,
        'default_state'   => 'collapsed',
        'group_title'   => '{#}. {title}',
        'add_button'        => __( 'Add Social Link', 'control-listings' ),
        'fields'            => [
            [
                'name' => __( 'Title', 'control-listings' ),
                'id'   => $prefix . 'title',
                'type' => 'text',
            ],            
            [
                'name' => __( 'Link', 'control-listings' ),
                'id'   => $prefix . 'link',
                'type' => 'text',
            ],
        ],
        'std' => [
            [
                'title' => 'Facebook',
                'link' => 'https://facebook.com/',
            ],
            [
                'title' => 'Twitter',
                'link' => 'https://twitter.com/',
            ],
            [
                'title' => 'Instagram',
                'link' => 'https://instagram.com/',
            ],
            [
                'title' => 'Linkedin',
                'link' => 'https://linkedin.com/',
            ],
        ],
        'tab'               => $tab,
    ],
];