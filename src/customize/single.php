<?php
return [
    [
        'desc' => __( 'Enable contact form in sidebar', 'control-listings' ),
        'id'   => 'enable_listing_sidebar_contact',
        'type' => 'checkbox',
        'std'  => true,
    ],
    [
        'name' => __( 'Contact form shortcode', 'control-listings' ),
        'id'   => 'listing_sidebar_form_shortcode',
        'type' => 'text',
        'std'  => '',
        'visible' => ['enable_listing_sidebar_contact', '=', true]
    ],
    [
        'desc' => __( 'Enable claim listing in sidebar', 'control-listings' ),
        'id'   => 'enable_listing_sidebar_claim',
        'type' => 'checkbox',
        'std'  => true,
    ],
    [
        'name' => __( 'Claim title', 'control-listings' ),
        'id'   => 'listing_sidebar_claim_title',
        'type' => 'text',
        'std'  => __('Claim the Listing', 'control-listings'),
        'visible' => ['enable_listing_sidebar_claim', '=', true],
        'active_callback' => static function() {
            return get_theme_mod('enable_listing_sidebar_claim', true);
        }
    ],
    [
        'name' => __( 'Claim email address', 'control-listings' ),
        'id'   => 'listing_sidebar_claim_email',
        'type' => 'text',
        'std'  => '#',
        'visible' => ['enable_listing_sidebar_claim', '=', true],
        'active_callback' => static function() {
            return get_theme_mod('enable_listing_sidebar_claim', true);
        }
    ],
];