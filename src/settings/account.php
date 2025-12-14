<?php
return [
    [
        'id'         => 'my_account_page',
        'name'      => 'Dashboard page',
        'type'       => 'post',
        'post_type'  => 'page',
        'ajax'       => false,
        'desc' => sprintf('Use this shortcode %s in the page content editor', '<code>[control_listings_dashboard]</code>'),
        'query_args' => [
            'posts_per_page' => -1,
        ],
    ],
    [
        'id'         => 'post_listing_page',
        'name'      => 'Add listing page',
        'type'       => 'post',
        'post_type'  => 'page',
        'ajax'       => false,
        'desc' => sprintf('Use this shortcode %s in the page content editor', '<code>[control_listings_form]</code>'),
        'query_args' => [
            'posts_per_page' => -1,
        ],
    ],
];