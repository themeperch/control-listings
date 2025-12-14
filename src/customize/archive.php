<?php
return [
    [
        'id'         => 'ctrl_listings_display_map_in_archive',
        'desc'      => 'Display map in archive page',
        'type'       => 'checkbox',
        'std' => true,
       
    ],
    [
        'id'         => 'ctrl_listings_display_map_in_taxonomy',
        'desc'      => 'Display map in Category/Tag page',
        'type'       => 'checkbox',
        'std' => false,
       
    ],
    [
        'id'         => 'ctrl_listings_display_map_in_search',
        'desc'      => 'Display map in search page',
        'type'       => 'checkbox',
        'std' => false,
       
    ],
    [
        'id'         => 'ctrl_listings_display_view_switch',
        'desc'      => 'Allow user to display switcher',
        'type'       => 'checkbox',
        'std' => true,
       
    ],
    [
        'id'         => 'ctrl_listings_view',
        'name'      => 'Default Listing style',
        'type'       => 'select',
        'std' => apply_filters('control_listings_archive_view_std', 'grid'),
        'options' => [
            'map' => 'Map view',
            'grid' => 'Grid view',
            'list' => 'List view'
        ],
    ],
    [
        'id'         => 'ctrl_listings_archive_column_class',
        'name'      => 'Column for grid view',
        'type'       => 'select',
        'std' => '3',
        'options' => [
            '2' => '2 column',
            '3' => '3 column',
            '4' => '4 column',
        ],
    ],    
];