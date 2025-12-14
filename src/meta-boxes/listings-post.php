<?php
$meta_box = [
    'title'  => '',
    'id'     => 'control-listing-post-fields',
    'fields' => [  
        [
            'type' => 'text',
            'name' => 'Listing Title',
            'id'   => 'post_title',
            'required' => true,
        ],        
        [
            'type'             => 'wysiwyg',
            'name'             => 'Listing content',
            'id'               => 'post_content',
            'raw'     => false,
            'options' => [
                'textarea_rows' => 10,
                'teeny'         => true,
                'media_buttons' => false
            ],
            'required' => true
        ],
        [
            'name' => 'Thumbnail',
            'type' => 'single_image',
            'id'   => '_thumbnail_id',
            'required' => true
        ],
        [
            'name' => 'Category',
            'type' => 'taxonomy',
            'id'   => 'listing_cat',
            'taxonomy'   => 'listing_cat',
            'inline' => true,            
            'field_type' => 'checkbox_list'
        ],
        [
            'name' => 'Tags',
            'type' => 'text',
            'id'   => 'listing_tag',
            'attributes' => [
                'value' => control_listings_tags_by_post_id(),
            ],
            'desc'   => 'Multiple are comma separated. <br />Most used tags: '. implode(', ', control_listings_get_terms_options()),
        ]       
    ],
];

$options = [
    'draft' => 'Draft',
    'pending' => 'Request for Review',
];
if( current_user_can('editor') || current_user_can('administrator') ){
    $options['publish'] = 'Publish';
}
$edit_post_id = filter_input( INPUT_GET, 'listings_frontend_post_id', FILTER_SANITIZE_NUMBER_INT );
if( $edit_post_id && (get_post_status($edit_post_id) != 'publish') ){    
    $meta_box['fields'][] = [
        'type' => 'select',
        'name' => 'Listing status',
        'id'   => 'listing_status',
        'std' => 'draft',
        'options' => $options,
        'before' => '<div class="alert alert-warning" role="alert">',
        'after' => '</div>',
    ];
}

return $meta_box;