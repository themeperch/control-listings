<?php
defined( 'ABSPATH' ) || exit;
use ControlListings\Favorite;

add_action('control_listing_single_content_before', 'control_listing_single_content_gallery', 1);
if( !function_exists('control_listing_single_content_gallery') ):
function control_listing_single_content_gallery(){
    wp_enqueue_style('ctrl-listings-swiper');
    wp_enqueue_script('ctrl-listings-swiper');
    $enable_gallery = get_post_meta( get_the_ID(), 'enable_gallery', true );
    if(empty($enable_gallery)) return;

    $gallery_meta = get_post_meta( get_the_ID(), 'gallery' );
    if(empty($gallery_meta)) return;
    $gallery = [];
    foreach ($gallery_meta as $key => $value) {
       if(empty($value['image'])) continue;
        $image = wp_get_attachment_image_src($value['image'], 'ctrl-listings-gallery-image');
        if(empty($image)) continue;
     
        $value['image'] = $image[0];
        $gallery[] = $value;
    }

    $args = [
        'gallery' => $gallery
    ];

    control_listings_locate_template('single/slider.php', $args);
}
endif;



add_action('control_listing_single_content_before', 'control_listing_single_content_title', 5);
function control_listing_single_content_title(){      
    control_listings_locate_template('single/title.php');    
}

add_action('control_listing_single_loop_content', 'control_listing_single_loop_content');
function control_listing_single_loop_content(){
    control_listings_template_part('single/enquiry');
    control_listings_template_part('single/content');
    control_listings_template_part('single/features');
    control_listings_template_part('single/specialities');
    control_listings_template_part('single/tags');
    control_listing_single_image_gallery_template();
    control_listing_single_awards_template();
    control_listing_single_video_gallery_template();    
    control_listing_single_tabs_template();    
    control_listings_template_part('single/navigations');   
}




function control_listing_single_awards_template(){
    $awards = get_post_meta(get_the_ID(), 'awards');
    foreach ($awards as $key => $value) {
        $value = wp_parse_args($value, [
            'image' => '',
            'title' => '',
            'year' => '',
            'desc' => '',
        ]);
        $awards[$key] = $value;
    }

    $args = [
        'awards' => $awards
    ];
    control_listings_locate_template('single/awards.php', $args);
}

function control_listing_single_image_gallery_images(){
    $images = get_post_meta(get_the_ID(), 'lising_images');
    foreach ($images as $key => $image) {   
        if(empty(wp_get_attachment_url($image))) continue;
        $images[$key] = [
            'attachment_id' => $image,
            'caption' => wp_get_attachment_caption($image),
            'thumbnail' => wp_get_attachment_url($image, 'thumbnail'),
            'medium' => wp_get_attachment_url($image, 'medium'),
            'full' => wp_get_attachment_url($image, 'full'),
        ];
    }
    return $images;
}

function control_listing_single_image_gallery_template(){    
    
    $args = [
        'images' => control_listing_single_image_gallery_images()
    ];
    control_listings_locate_template('single/image-gallery.php', $args);
}

function control_listing_single_video_gallery_template(){
    
    $videos_meta = get_post_meta(get_the_ID(), 'videos');
    $videos = [];
    foreach ($videos_meta as $key => $video) {
        $video = wp_parse_args($video, [
            'title' => '',
            'image' => [],
            'link' => '',
            'desc' => '',
        ]);
        if(empty($video['image'][0]) || empty($video['link'])){
            unset($videos[$key]);
            continue;
        } 

        if(empty($video['image'])) continue;
       
        $attachment_id = !empty($video['image'][0])? $video['image'] : $video['image'][0];      
        $video['attachment_id']  = $attachment_id;
        $video['image'] = wp_get_attachment_url($attachment_id, 'full');
        $video['thumbnail'] = wp_get_attachment_url($attachment_id, 'ctrl-listings-video-thumbnail');
        
        $videos[] = $video;
    }
    $args = [
        'videos' => $videos
    ];
    control_listings_locate_template('single/video-gallery.php', $args);
}

function control_listing_single_events_meta(){
    $events_meta = get_post_meta(get_the_ID(), 'event_plans');
    $events = [];
    foreach ($events_meta as $event) {
        if(empty($event['image'])) continue;
        if(!empty($event['_index_image'])){
            unset($event['_index_image']);
            $event['image'] = $event['image'][0];
        } 
        
        $events[] = $event;
    }
    return $events;
}

function control_listing_single_events_template(){    
    
    $args = [
        'events' => control_listing_single_events_meta()
    ];
    control_listings_locate_template('single/events.php', $args);
}

function control_listing_single_faqs_meta(){
    $faqs_meta = get_post_meta(get_the_ID(), 'faqs');
    $faqs = [];
    foreach ($faqs_meta as $faq) {
        if(empty($faq['question']) || empty($faq['answer'])) continue;
        
        
        $faqs[] = $faq;
    }
    return $faqs;
}

function control_listing_single_faqs_template(){    
    
    $args = [
        'faqs' => control_listing_single_faqs_meta()
    ];
    control_listings_locate_template('single/faqs.php', $args);
}

function control_listing_single_reviews_template(){        
    // If comments are open or there is at least one comment, load up the comment template.
    if ( comments_open() || get_comments_number() ) {
        comments_template();
    }
}

function control_listing_single_tabs_template(){
    $tabs = [];
    $events = control_listing_single_events_meta();
    if(!empty($events)){
        $tabs['events'] = __('Events', 'control-listings'); 
    }
    $faqs = control_listing_single_faqs_meta();
    if(!empty($events)){
        $tabs['faqs'] = __('FAQs', 'control-listings'); 
    }
    $tabs['reviews'] = __('Reviews', 'control-listings');

    $tabs = apply_filters('control_listing_single_tabs', $tabs);
    $args = [
        'tabs' => $tabs
    ];
    
    control_listings_locate_template('single/tabs.php', $args);
}

function control_listings_single_tab_content($tab){
    $function_name = "control_listing_single_{$tab}_template";
    if(function_exists($function_name)){
        call_user_func($function_name);
    }
}

add_action('control_listing_single_enquiry_content', 'control_listing_single_enquiry_content');
function control_listing_single_enquiry_content(){
    control_listings_locate_template('single/enquiry/content.php');
}

add_action('control_listing_single_enquiry_footer', 'control_listing_single_enquiry_footer');
function control_listing_single_enquiry_footer(){
    control_listing_single_enquiry_footer_bookmarks();
    control_listing_single_enquiry_footer_price();
}
function control_listing_single_enquiry_footer_bookmarks(){
    $data_attributes = [
        'data-id="'.get_the_ID().'"',
        'data-bs-toggle="tooltip"'
    ];
    if(!Favorite::is_added(get_the_ID())){
        
        $args = [
            'favourite_status' => 'Add to favourite',
            'favourite_icon' => 'love',
            'favourite_class' => 'ctrl-listing-favorite',
            'data_attributes' => $data_attributes
        ];
    }else{
        $args = [
            'favourite_status' => 'Added as favourite',
            'favourite_icon' => 'love-fill',
            'favourite_class' => 'ctrl-listing-favorite ctrl-listing-favorite-added',
            'data_attributes' => $data_attributes
        ];
    }   
   

    global $control_listings_bookmarks;
   
    if(!$control_listings_bookmarks->is_bookmarked(get_the_ID())){
        
        $new_args = [
            'bookmark_status' => 'Add to Bookmark',
            'bookmark_icon' => 'star',
            'bookmark_class' => 'ctrl-listing-bookmark-btn',
            'data_attributes' => $data_attributes
        ];
    }else{
        $new_args = [
            'bookmark_status' => 'Edit/Remove Bookmark',
            'bookmark_icon' => 'star-fill',
            'bookmark_class' => 'ctrl-listing-bookmark-btn ctrl-listing-bookmark-added',
            'data_attributes' => $data_attributes
        ];
    }


    $args = array_merge($args, $new_args);


    control_listings_locate_template('single/enquiry/bookmarks.php', $args);
}

function control_listings_get_price_html(){
    $min_price = get_post_meta(get_the_ID(), 'min_price', true);
    $max_price = get_post_meta(get_the_ID(), 'max_price', true);

    if(intval($min_price) > intval($max_price)){
        $max_price = false;
    }

    if(!empty($min_price) && !empty($max_price)){
        return sprintf('<span class="fw-bold">%s</span> to <span class="fw-bold">%s</span>', 
            control_listings_price($min_price),
            control_listings_price($max_price)
        );
    }

    if(!empty($min_price) && empty($max_price)){
        return sprintf('<span class="fw-bold">%s</span>', 
            control_listings_price($min_price)
        );
    }
}

function control_listing_single_enquiry_footer_price(){
    
    control_listings_locate_template('single/enquiry/price.php');
}




add_action('control_listing_single_content_sidebar', 'control_listing_single_content_sidebar');
function control_listing_single_content_sidebar(){
    control_listing_single_content_sidebar_logo();    
    control_listing_single_content_sidebar_contact_info();
    control_listing_single_content_sidebar_working_hours();
    control_listing_single_content_sidebar_reviews();
    if(control_listings_option('enable_listing_sidebar_contact', true)){
        control_listing_single_content_sidebar_contact();
    }
    if(control_listings_option('enable_listing_sidebar_claim', true)){
        control_listing_single_content_sidebar_claim_listing();
    }
    
}

function control_listing_single_content_sidebar_contact(){
    $args = [
        'title' => control_listings_option('listing_sidebar_contact_title', 'Email us'),
        'shortcode' => control_listings_option('listing_sidebar_form_shortcode', '')
    ];
    control_listings_locate_template('single/sidebar/contact.php', $args);
}

function control_listing_single_content_sidebar_claim_listing(){
    $args = [
        'title' => control_listings_option('listing_sidebar_claim_title'),
        'email' => control_listings_option('listing_sidebar_claim_email', '#'),
    ];
    control_listings_locate_template('single/sidebar/claim-listing.php', $args);
}

function control_listing_single_content_sidebar_logo(){
    $args = [
        'logo' => get_post_meta(get_the_ID(), 'logo', true)
    ];
    control_listings_locate_template('single/sidebar/logo.php', $args);
}

function control_listing_single_content_sidebar_contact_info(){
    $args = [
        'address' => get_post_meta(get_the_ID(), 'address', true),
        'phone' => get_post_meta(get_the_ID(), 'phone', true),
        'email' => get_post_meta(get_the_ID(), 'email', true),
        'website' => get_post_meta(get_the_ID(), 'website', true),
        'social_links' => get_post_meta(get_the_ID(), 'social_links'),
        'google_map' => control_listing_single_google_map()
    ];
    control_listings_locate_template('single/sidebar/contact-info.php', $args);
}

function control_listing_single_content_sidebar_working_hours(){
    $args = [];
    control_listings_locate_template('single/sidebar/working-hours.php', $args);
}

function control_listing_single_google_map(){
    $geometry = get_post_meta(get_the_ID(), 'map', true);
    if(is_string($geometry)) $geometry = explode(',', $geometry);

    if(!isset($geometry[0]) && !isset($geometry[1])) return;

    $map_location_src = 'https://maps.google.com/maps?q=' .esc_attr($geometry[0]). ',' .esc_attr($geometry[1]). '&amp;z=16&amp;output=embed';
    return '<iframe src="'. esc_url($map_location_src) . '" allowfullscreen="1" height="300" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>';

    
}

function control_listing_single_content_sidebar_reviews(){
    if ( post_password_required() || !have_comments() ) {
        return;
    }
    
    $total_review_count = get_comments_number();
    if(!$total_review_count) return;
    $args = [
        'total_review_count' => $total_review_count
    ];
    control_listings_locate_template('single/sidebar/reviews.php', $args);
}

