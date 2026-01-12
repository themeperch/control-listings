<?php
defined( 'ABSPATH' ) || exit;
return [
    [
        'id'         => 'listing_archive_page',
        'name'      => 'Archive page',
        'type'       => 'post',
        'post_type'  => 'page',
        'ajax'       => false,
        'query_args' => [
            'posts_per_page' => -1,
        ],
    ],
    [
        'name' => __( 'Listings per page', 'control-listings' ),
        'id'   => 'posts_per_page',
        'type' => 'number',
        'std'  => 12,
    ],
    [
        'name' => __( 'Enable for non-logged in users', 'control-listings' ),
        'id'   => 'non_logged_in',
        'type' => 'checkbox',
        'std'  => true,
    ]
];