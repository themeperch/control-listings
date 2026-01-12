<?php
defined( 'ABSPATH' ) || exit;
return [
    [
        'name' => __( 'Opening hours', 'control-listings' ),
        'id'   => $prefix . 'opening_hours',
        'type' => 'radio',
        'inline'  => false,
        'std' => 'business_hour',
        'options' => [
            'business_hour' => 'Show when your business is open',
            'hide_business_hour' => 'Don\'t show any business hours',
            'temporary_closed' => 'Temporarily closed - Show that your business will open again in the future',
        ],
        'tab'               => $tab,
    ],
    [
        'id'                => $prefix . 'working_hours',
        'type'              => 'group',
        'clone'             => true,
        'clone_default'     => true,
        'clone_as_multiple' => true,
        'max_clone'         => 7,
        'visible' => [$prefix . 'opening_hours', '=', 'business_hour'],
        'std'               => [
            [
                $prefix . 'day' => 'Monday',
                $prefix . 'start_time' => '08:30',
                $prefix . 'end_time' => '20:00',
            ],
            
            [
                $prefix . 'day' => 'Tuesday',
                $prefix . 'start_time' => '08:30',
                $prefix . 'end_time' => '20:00',
            ],
            [
                $prefix . 'day' => 'Wednesday',
                $prefix . 'start_time' => '08:30',
                $prefix . 'end_time' => '20:00',
            ],
            [
                $prefix . 'day' => 'Thrusday',
                $prefix . 'start_time' => '08:30',
                $prefix . 'end_time' => '20:00',
            ],
            [
                $prefix . 'day' => 'Friday',
                $prefix . 'start_time' => '08:30',
                $prefix . 'end_time' => '20:00',
            ],
            [
                $prefix . 'day' => 'Saturady',
                $prefix . 'closed' => true,
                $prefix . 'start_time' => '08:30',
                $prefix . 'end_time' => '20:00',
                
            ],
            [
                $prefix . 'day' => 'Sunday',
                $prefix . 'closed' => true,
                $prefix . 'start_time' => '08:30',
                $prefix . 'end_time' => '20:00',
            ]

        ],
        'fields'            => [            
            [
                'name' => __( 'Day', 'control-listings' ),
                'id'   => $prefix . 'day',
                'type' => 'text',
                'required' => true
            ],
            [
                'name' => __( 'Closed', 'control-listings' ),
                'id'   => $prefix . 'closed',
                'type' => 'checkbox',
            ],
            [
                'name' => __( 'Opening time', 'control-listings' ),
                'id'   => $prefix . 'start_time',
                'type' => 'time',
                'hidden' => [$prefix . 'closed', '=', true]
            ],
            [
                'name' => __( 'Closing time', 'control-listings' ),
                'id'   => $prefix . 'end_time',
                'type' => 'datetime',
                'hidden' => [$prefix . 'closed', '=', true]
            ],            
            [
                'name' => __( 'Description', 'control-listings' ),
                'id'   => $prefix . 'desc',
                'type' => 'text',
                'desc' => 'Optional, Additional details'
            ],
            
        ],
        'tab'               => $tab,
    ],
];