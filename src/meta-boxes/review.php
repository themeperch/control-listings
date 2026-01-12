<?php
defined( 'ABSPATH' ) || exit;
$prefix = '';

return [
    'title'      => __( 'Review data', 'control-listings' ),
    'id'         => 'control-listing-review-data',
  //  'post_types' => ['comment'],
    'type' => 'comment',
    'fields'     => [
        [
            [
                'name' => 'Libary',
                'id'   => 'libary',
                'type' => 'number',
                'min'  => 1,
                'max'  => 5,
                'step' => 1,
            ],
        ]
    ]
];