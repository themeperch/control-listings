<?php
defined( 'ABSPATH' ) || exit;
use ControlListings\Favorite;


if(!function_exists('control_listings_get_icon_svg')):
/**
 * Gets the SVG code for a given icon.
 *
 * @param   string    $group The icon group.
 * @param   string    $icon  The icon.
 * @param   int       $size  The icon size in pixels.
 * @return  string
 */
function control_listings_get_icon_svg( $group, $icon, $size = 24 ) {
	return ControlListings\SVG_Icons::get_svg( $group, $icon, $size );
}
endif;


if(!function_exists('control_listings_get_social_link_svg')):
/**
 *
 * @param   string    $uri      (required)
 * @param   int       $size     The icon size in pixels.
 * 
 * @return  string
 */
function control_listings_get_social_link_svg( $uri, $size = 24 ) {
	return ControlListings\SVG_Icons::get_social_link_svg( $uri, $size );
}
endif;


function control_listings_meta_query(){
    
}

if(!function_exists('control_listings_post_options')):
/**
 *
 * @param  string 	$post_type  ctrl_listings.
 *
 * @return array
 */
function control_listings_post_options($post_type = 'ctrl_listings'){
    $posts = get_posts(array(
            'post_type'        => $post_type, 
            'post_status'      => 'publish', 
            'suppress_filters' => false, 
            'posts_per_page'   =>-1
        )
    );

    $options = [];
    foreach ($posts as $post) {
        $options[$post->ID] = $post->post_title;
    }
    return $options;
}
endif;

if(!function_exists('control_listings_active_address_points')):
/**
 *
 * @return array
 */
function control_listings_active_address_points(){
    $address_points = [];
    if(have_posts()){
        while ( have_posts() ) {
            the_post();
            $map = get_post_meta(get_the_ID(), 'map', true);
            if(empty($map)) continue;            

            ob_start();
            control_listings_locate_template('loop/content.php');            
            $content = ob_get_clean();

            ob_start();
            $marker_args = [
                'icon_class' => 'citykid-home',
                'css_class' => 'text-primary'
            ];
            control_listings_locate_template('loop/map-marker.php', $marker_args);
            $marker = ob_get_clean();            

            $mapArr = explode(',', $map);
            $address_points[] = [
                $mapArr[0],
                $mapArr[1],
                get_the_title(),
                'marker' => $marker,
                'content' => trim($content)
            ];
        }            
    }
    return $address_points;
}
endif;

if(!function_exists('control_listings_default_address_points')):
/**
 *
 * @return array
 */
function control_listings_default_address_points(){
    $default_points = [-37.82, 175.24];    
    $address_points = explode(',', control_listings_setting('map'));
    if(!empty($address_points[0]) && !empty($address_points[1])){
        $default_points = [$address_points[0],$address_points[1]];
    }
    
    return $default_points;
}
endif;

// Archive listing hooks
add_action('control_listing_loop_start', 'control_listing_content_filter', 1);
function control_listing_content_filter(){ 
    if(get_query_var('view') == 'map'){
        $args = control_listings_get_searchform_args();
        control_listings_locate_template('loop/filter-map.php', $args);
    }else{
        control_listings_locate_template('loop/filter.php');
    }  
    
}



function control_listing_map_template(){
    if(!control_listings_count_posts_published()) return;
    $display_map = false;
    if(is_search()){
        $display_map = control_listings_option('ctrl_listings_display_map_in_search');
    }elseif(is_tax()){
        $display_map = control_listings_option('ctrl_listings_display_map_in_taxonomy');
    }elseif(is_post_type_archive('ctrl_listings')){
        $display_map = control_listings_option('ctrl_listings_display_map_in_archive');
    }
    
    
    if(empty($display_map)) return;
    wp_localize_script( 'ctrl-listings-leaflet', 'addressPoints', control_listings_active_address_points() );
    wp_localize_script( 'ctrl-listings-leaflet', 'defaultaddressPoints', control_listings_default_address_points() );

    wp_enqueue_style('ctrl-listings-leaflet');
    wp_enqueue_script('ctrl-listings-leaflet');
    $args = [

    ];
    if(have_posts()){
        control_listings_locate_template('loop/map.php', $args);
    }
    
}

function control_listing_map_view_template(){
    if(!control_listings_count_posts_published()) return;
    wp_localize_script( 'ctrl-listings-leaflet', 'addressPoints', control_listings_active_address_points() );
    wp_localize_script( 'ctrl-listings-leaflet', 'defaultaddressPoints', control_listings_default_address_points() );

    wp_enqueue_style('ctrl-listings-leaflet');
    wp_enqueue_script('ctrl-listings-leaflet');
    $args = [
        'css_class' => 'h-100'
    ];
    control_listings_locate_template('loop/map.php', $args);
}

add_action('control_listings_result_count', 'control_listings_result_count');
function control_listings_result_count(){
    $args = array(
        'is_search'    => $GLOBALS['wp_query']->is_search(),
        'total'        => $GLOBALS['wp_query']->found_posts,
        'total_pages'  => $GLOBALS['wp_query']->max_num_pages,
        'per_page'     => $GLOBALS['wp_query']->get( 'posts_per_page' ),
        'current_page' => max( 1, $GLOBALS['wp_query']->get( 'paged', 1 ) ),
    );
    control_listings_locate_template('loop/result-count.php', $args);
}

add_action('control_listings_order_form', 'control_listings_order_form');
function control_listings_order_form(){
    $args = array(
        'is_search'    => $GLOBALS['wp_query']->is_search(),
        'total'        => $GLOBALS['wp_query']->found_posts,
        'total_pages'  => $GLOBALS['wp_query']->max_num_pages,
        'per_page'     => $GLOBALS['wp_query']->get( 'posts_per_page' ),
        'current_page' => max( 1, $GLOBALS['wp_query']->get( 'paged', 1 ) ),
        'switcher' => control_listings_option('ctrl_listings_display_view_switch', true)
    );
    control_listings_locate_template('loop/order-form.php', $args);
}

add_action('control_listing_loop_start', 'control_listing_loop_start', 10);
function control_listing_loop_start(){    
    $args = [
        'masonary' => true
    ];
    $column = control_listings_option('ctrl_listings_archive_column_class', 3);
    $column = empty($column)? 3 : $column;
    $GLOBALS['control_listings_column'] = (int)$column;
    $args['column_class'] = "row-cols-1 row-cols-lg-{$column}";
    control_listings_locate_template('loop/loop-start.php', $args);
}

add_action('control_listing_loop_end', 'control_listing_loop_end');
function control_listing_loop_end(){
    control_listings_locate_template('loop/loop-end.php');
    control_listings_locate_template('loop/pagination.php'); 
}

add_action('control_listing_loop_content', 'control_listing_loop_content');
function control_listing_loop_content($args){    
    if(get_query_var('view') == 'list'){
        control_listings_locate_template('loop/content-list.php');
    }else{
        control_listings_locate_template('loop/content-grid.php');
    }    
    
}


// Archive content template hooks
add_action('control_listing_loop_content_body', 'control_listing_loop_content_lising_meta');
function control_listing_loop_content_lising_meta(){ 
    $args = [
        'display_listing_meta' => true,
        'display_bookmark_status' => true,
        'display_ratings_status' => true,
        'display_ratings' => true,                
        'bookmark_status' => 'Login to Bookmark this listing',
        'bookmark_icon' => 'star',
    ]; 
    $args = apply_filters('control_listing_loop_content_body_args', $args);
    control_listings_locate_template('loop/title.php', $args);
    if( !empty($args['display_listing_meta']) ){
        control_listings_locate_template('loop/listing-meta.php', $args);
    }
    
}

add_action('control_listing_loop_content_start', 'control_listing_loop_content_lising_thumbnail');
function control_listing_loop_content_lising_thumbnail(){
    $args = [
        'thumbnail_size' => get_query_var('view') == 'list'? 'ctrl-listings-archive-list-image' :  'ctrl-listings-archive-image',
    ];  
    control_listings_locate_template('loop/thumbnail.php', $args);    
}

add_action('control_listing_loop_content_end', 'control_listing_loop_content_bookmarks');
function control_listing_loop_content_bookmarks(){
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

    control_listings_locate_template('loop/bookmarks.php', $args);
}

add_action('control_listing_loop_content_end', 'control_listing_loop_content_price', 5, 1);
function control_listing_loop_content_price($args){
    control_listings_locate_template('loop/price.php', $args);
}


add_action('control_listings_search_form_fields', 'control_listings_search_form_hidden_fields');
function control_listings_search_form_hidden_fields(){
        
    if(!empty(get_query_var('sort'))):
    ?>
    <input type="hidden" name="sort" value="<?php echo  esc_attr(get_query_var('sort')); ?>">
    <?php endif; ?>
    <?php
}

add_action('control_listings_order_form_fields', 'control_listings_order_form_hidden_fields');
function control_listings_order_form_hidden_fields(){
    $queries = control_listings_filter_query_vars();
    foreach ($queries as $query => $value) :
        if(in_array($query, ['sort', 'view'])) continue;
        $query_var = get_query_var($query);
        if(empty($query_var)) continue;

        ?>
        <div class="active-filter">
            <input type="checkbox" name="<?php echo esc_attr($query) ?>" class="btn-check"  value="<?php echo esc_attr(get_query_var($query)) ?>" id="orderFormSearch<?php echo esc_attr($query) ?>" checked autocomplete="off"  onchange="this.form.submit()">
            <label class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1" for="orderFormSearch<?php echo esc_attr($query) ?>"><span class="btn-close btn-close-white small"></span> <?php echo esc_attr($value.':'.get_query_var($query)) ?></label>
        </div>
        <?php
        
    endforeach;
    
}

function control_listings_get_searchform_args(){
    $min_ages = control_listings_meta_values('min_age');
    $min_age = !empty($min_ages)? min($min_ages) : 0;
    $max_ages = control_listings_meta_values('max_age');   
    $max_age = !empty($min_ages)? max($max_ages) : 0;   
    $age = explode('-', get_query_var('age'));

    $min_prices = control_listings_meta_values('min_price');
    $min_price = !empty($min_prices)? min($min_prices) : 0;
    $max_prices = control_listings_meta_values('max_price');   
    $max_price = !empty($max_prices)? max($max_prices) : 99;   
    $price = explode('-', get_query_var('price'));
    $args = [
        'min_age' => $min_age,
        'max_age' => $max_age,
        'min_age_active' => (!empty($age[0]) && is_numeric($age[0]))? $age[0] : $min_age,
        'max_age_active' => (!empty($age[1]) && is_numeric($age[1]))? $age[1] : $max_age,
        // price
        'min_price' => $min_price,
        'max_price' => $max_price,
        'min_price_active' => (!empty($price[0]) && is_numeric($price[0]))? $price[0] : $min_price,
        'max_price_active' => (!empty($price[1]) && is_numeric($price[1]))? $price[1] : $max_price,
        // Category
        'lcat_active' => array_filter(explode(',', control_listings_get_active_term('listing_cat')))
    ];

    return $args;
}

/**
 * @param string $taxonomy
 * 
 * @return string|boolean
 */
function control_listings_get_active_term($taxonomy = 'listing_cat'){
    $active_terms = false;
    if(!empty(get_query_var('lcat'))){
        $active_terms = get_query_var('lcat');
    }elseif( is_tax($taxonomy)){
        $active_terms = get_term( get_queried_object()->term_id, $taxonomy )->slug;
    }
    return $active_terms;
}

add_action( 'wp_footer', 'control_listings_load_modal' );
function control_listings_load_modal(){
    if(!control_listings_count_posts_published()) return;
    wp_enqueue_script('contorl-listings-searchform');
    control_listings_locate_template('social-share.php');
    control_listings_locate_template('modal.php');
    
    if(get_query_var('view') != 'map'){
    $args = control_listings_get_searchform_args();
    control_listings_locate_template('advanced-search.php', $args);
    }
}

function control_listings_add_listing_button($echo = true){
    $options = get_option('control_listings');
    if(empty($options['post_listing_page']) || FALSE === get_post_status( $options['post_listing_page'] )) return;
   
    $args =  [
        'button_text' => __('Add listing', 'control-listings'),
        'button_url' => control_listings_add_listing_url(),
    ];
    ob_start();
    control_listings_locate_template('elements/add-listing-button.php', $args);
    if($echo) echo wp_kses_post(ob_get_clean());
    else
    return ob_get_clean();

}

add_action('control_listing_loop_no_results', 'control_listing_loop_no_results');
function control_listing_loop_no_results(){
    
    if(get_query_var('view') == 'map'){
        $args = control_listings_get_searchform_args();
        control_listings_locate_template('loop/filter-map.php', $args);
        echo '<div class="px-20">';
    }
    control_listings_locate_template('loop/content-none.php');
    if(get_query_var('view') == 'map'){
        echo '</div>';
    }
    
}

add_action('control_listing_user_account_content', 'control_listing_user_account_content');
if ( ! function_exists( 'control_listing_user_account_content' ) ) {

	/**
	 * My Account content output.
	 */
	function control_listing_user_account_content() {
		global $wp;

		if ( ! empty( $wp->query_vars ) ) {
			foreach ( $wp->query_vars as $key => $value ) {
				// Ignore pagename param.
				if ( 'pagename' === $key ) {
					continue;
				}

				if ( has_action( 'control_listing_user_' . $key  ) ) {
					do_action( 'control_listing_user_' . $key , $value );
					return;
				}
			}
			do_action( 'control_listing_user_dashboard' , $value );
		}
		
	}
}

function control_listings_query_args_by_type($type, $atts = []){
    $query_args = wp_parse_args($atts, [
        'post_type' => 'ctrl_listings',
        'posts_per_page' => 6,
        'ignore_sticky_posts' => true
    ]);

    if($type == 'featured'){
        $query_args['post__in'] = get_option('sticky_posts');
    }
    if($type == 'popular'){
        $query_args['orderby'] = 'meta_value_num';
        $query_args['order'] = 'ASC';
        $query_args['meta_key'] = 'ctrl_listing_favorite_count';
    }
    
    return $query_args;
}