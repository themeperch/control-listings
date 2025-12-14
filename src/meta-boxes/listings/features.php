<?php
return [
    [
        'id'                => $prefix . 'features',
        'name'                => 'Features',
        'type'              => 'key_value',        
        'add_button'        => __( 'Add Feature', 'control-listings' ),        
        'tab'               => $tab,
    ],
    [
        'id'                => $prefix . 'specialities',
        'name'                => 'Specialities',
        'type'              => 'text',        
        'clone'              => true,        
        'add_button'        => __( 'Add Speciality', 'control-listings' ),        
        'tab'               => $tab,
    ],
];