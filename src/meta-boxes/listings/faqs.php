<?php
return [
    [
        'id'                => $prefix . 'faqs',
        'type'              => 'group',
        'clone'             => true,
        'clone_default'     => true,
        'clone_as_multiple' => true,
        'collapsible'   => true,
        'default_state'   => 'collapsed',
        'group_title'   => '{#}. {question}',
        'max_clone'         => 10,
        'add_button'        => __( 'Add FAQ', 'control-listings' ),
        'fields'            => [
            
            [
                'name' => __( 'Question', 'control-listings' ),
                'id'   => $prefix . 'question',
                'type' => 'text',
            ],            
                    
            [
                'name' => __( 'Answer', 'control-listings' ),
                'id'   => $prefix . 'answer',
                'type'    => 'wysiwyg',
                'raw'     => false,
                'options' => [
                    'textarea_rows' => 4,
                    'teeny'         => true,
                    'media_buttons' => false,
                    'dfw' => false,
                ],
            ],
            
            
        ],
        'tab'               => $tab,
    ],
    
];