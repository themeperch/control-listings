<?php 
return [
    'title'  => '',
    'id'     => 'default-fields',
    'type'   => 'user', // NOTICE THIS
    'fields' => [    
        [
            'name' => __( 'Profile Picture', 'control-listings' ),
            'id'   => 'control_listing_user_avatar',
            'type' => is_admin()? 'single_image' : 'image',
            'max_file_uploads' => 1,
        ],   
        [
            'id'   => 'first_name',
            'name' => 'First Name',
            'type' => 'text',
            'size' => 50
        ],
        [
            'id'   => 'last_name',
            'name' => 'Last Name',
            'type' => 'text',
            'size' => 50
        ], 
        [
            'id'   => 'display_name',
            'name' => 'Display name publicly as',
            'type' => 'text',
            'size' => 50
        ], 
              
        [
            'id'   => 'user_email',
            'name' => __('Email', 'control-listings'),
            'desc' => __('If you change this, an email will be sent at your new address to confirm it. The new address will not become active until confirmed.', 'control-listings'),
            'type' => 'email',
            'size' => 50
        ],
        [
            'id'   => 'contact_phone',
            'name' => __('Phone', 'control-listings'),
            'placeholder' => __('Contact phone', 'control-listings'),
            'type' => 'text',
            'size' => 50
        ],
        [
            'id'   => 'user_url',
            'name' => __('Website', 'control-listings'),
            'type' => 'url',
            'size' => 50,
            'attributes' => [
                'class' => 'form-control'
            ]
        ],
        [
            'id'   => 'description',
            'name' => 'Biography',
            'type' => 'textarea',
        ],
        
    ],
];