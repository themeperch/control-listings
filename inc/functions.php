<?php
defined( 'ABSPATH' ) || exit;
require_once __DIR__ .'/functions-formatting.php';
require_once __DIR__ .'/functions-listings.php';
require_once __DIR__ .'/functions-listings-single.php';
require_once __DIR__ .'/comment-form.php';

if(!function_exists('control_listings_setting')):
/**
 * 
 * @param 	string	$setting_id		(required)
 * @param 	mixed	$default 		NULL
 * 
 * @return	mixed	
*/ 
function control_listings_setting($setting_id, $default=NULL){
	$output = $default;
	$options = get_option('control_listings');
	if( isset($options[$setting_id]) ){
		$output = $options[$setting_id];
	}
	return $output;
}
endif;

if(!function_exists('control_listings_option')):
/**
 * 
 * @param 	string	$option_id		(required)
 * @param 	mixed	$default 		NULL
 * 
 * @return	mixed	
*/ 
function control_listings_option($option_id, $default=NULL){
	$output = $default;
	$options = get_option('control_listings_options');
	if( isset($options[$option_id]) ){
		$output = $options[$option_id];
	}
	return $output;
}
endif;

if(!function_exists('control_listings_formated_content')):
/**
 * 
 * @param 	string		$content		(required)
 * @param 	string		$before			empty
 * @param 	string		$after			empty
 * @param 	boolean		$echo 			true
 * 
 * @return	string	
*/ 
function control_listings_formated_content( $content, $before = '', $after = '', $echo = true ) {

	$content = wp_kses_post($content);

	if ( strlen( $content ) == 0 ) {
		return;
	}

	$content = $before . $content . $after;

	if ( $echo ) {
		echo wp_kses_post($content);
	} else {
		return $content;
	}
}
endif;

if(!function_exists('control_listings_locate_template')):
/**
 * Retrieve the name of the highest priority template file that exists.
 *
 * Searches in the stylesheet_directory before TEMPLATEPATH and CTRL_LISTINGS_TEMPLATEPATH
 * so that themes which inherit from a parent theme can just overload one file.
 *
 * @param 	string|array 	$template_names Template file(s) to search for, in order.
 * @param 	array        	$args           Optional. Additional arguments passed to the template.
 *                                     		Default empty array.
 * @return 	string The template filename if one is located.
 */
function control_listings_locate_template( $template_name, $args = array() ) {
	$located = '';
    $templates_dir = apply_filters( 'control_listings/template_directory', '/control-listings/' );
	$supported_active_theme_dir = CTRL_LISTINGS_TEMPLATEPATH.wp_get_theme()->get('TextDomain').'/';
	
	if ( file_exists( CTRL_LISTINGS_TEMPLATEPATH . $template_name ) ) {
		$located = CTRL_LISTINGS_TEMPLATEPATH . $template_name;
	}

	$located = apply_filters('control_listings_locate_template', $located, $template_name);
	$located = apply_filters("control_listings/template/{$template_name}", $located, $template_name);
	
	if ( file_exists( get_stylesheet_directory() . $templates_dir . $template_name ) ) {
		$located = get_stylesheet_directory() . $templates_dir . $template_name;
	} elseif ( file_exists( get_template_directory() . $templates_dir . $template_name ) ) {
		$located = get_template_directory() . $templates_dir . $template_name;
	} elseif(file_exists( $supported_active_theme_dir . $template_name )){
		$located = $supported_active_theme_dir . $template_name;
	} 


	if ( '' !== $located ) {
		if(!is_array($args)) $args = (array)$args;
		extract($args);
		include( $located );
	}
}
endif;

if(!function_exists('control_listings_template')):
/**
 * Retrieve the name of the highest priority template file that exists.
 *
 * Searches in the STYLESHEETPATH before TEMPLATEPATH and CTRL_LISTINGS_TEMPLATEPATH
 * so that themes which inherit from a parent theme can just overload one file.
 *

 *
 * @param 	string|array $template_names 	Template file(s) to search for, in order.
 * @param 	bool         $load           	If true the template file will be loaded if it is found.
 * @param 	bool         $require_once   	Whether to require_once or require. Has no effect if `$load` is false.
 *                                     		Default true.
 * @param 	array        $args          	Optional. Additional arguments passed to the template.
 *                                     		Default empty array.
 * @return 	string 	The template filename if one is located.
 */
function control_listings_template( $template_names, $load = false, $require_once = true, $args = array() ) {
	$located = '';
    $templates_dir = apply_filters( 'control_listings/template_directory', '/control-listings/' );
	$supported_active_theme_dir = CTRL_LISTINGS_TEMPLATEPATH.wp_get_theme()->get('TextDomain').'/';
	foreach ( (array) $template_names as $template_name ) {
		if ( ! $template_name ) {
			continue;
		}

		if ( file_exists( CTRL_LISTINGS_TEMPLATEPATH . $template_name ) ) {
			$located = CTRL_LISTINGS_TEMPLATEPATH . $template_name;
		}

		$located = apply_filters('control_listings_template', $located, $template_name);		
		$located = apply_filters("control_listings/template/{$template_name}", $located, $template_name);

		if ( file_exists( get_stylesheet_directory() . $templates_dir . $template_name ) ) {
			$located = get_stylesheet_directory() . $templates_dir . $template_name;
		} elseif ( file_exists( get_template_directory() . $templates_dir . $template_name ) ) {
			$located = get_template_directory() . $templates_dir . $template_name;
		}elseif(file_exists( $supported_active_theme_dir . $template_name )){
			$located = $supported_active_theme_dir . $template_name;			
		}
	}

	if ( $load && '' !== $located ) {
		load_template( $located, $require_once, $args );
	}

	return $located;
}
endif;

if(!function_exists('control_listings_template_part')):
/**
 * Loads a template part into a template.
 *
 * Provides a simple mechanism for child themes to overload reusable sections of code
 * in the theme.
 *
 * Includes the named template part for a theme or if a name is specified then a
 * specialised part will be included. If the theme contains no {slug}.php file
 * then no template will be included.
 *
 * The template is included using require, not require_once, so you may include the
 * same template part multiple times.
 *
 * For the $name parameter, if the file is called "{slug}-special.php" then specify
 * "special".
 *
 * @param 	string 	$slug 	The slug name for the generic template.
 * @param 	string 	$name 	The name of the specialised template.
 * @param 	array  	$args 	Optional. Additional arguments passed to the template.
 *                     		Default empty array.
 * @return 	void|false 		Void on success, false if the template does not exist.
 */
function control_listings_template_part( $slug, $name = null, $args = array() ) {
	/**
	 * Fires before the specified template part file is loaded.
	 *
	 * The dynamic portion of the hook name, `$slug`, refers to the slug name
	 * for the generic template part.
	 *
	 * @param string      $slug The slug name for the generic template.
	 * @param string|null $name The name of the specialized template.
	 * @param array       $args Additional arguments passed to the template.
	 */
	do_action( "get_template_part_{$slug}", $slug, $name, $args );

	$templates = array();
	$name      = (string) $name;
	if ( '' !== $name ) {
		$templates[] = "{$slug}-{$name}.php";
	}

	$templates[] = "{$slug}.php";

	/**
	 * Fires before an attempt is made to locate and load a template part.
     *
	 * @param string   $slug      The slug name for the generic template.
	 * @param string   $name      The name of the specialized template.
	 * @param string[] $templates Array of template files to search for, in order.
	 * @param array    $args      Additional arguments passed to the template.
	 */
	do_action( 'get_template_part', $slug, $name, $templates, $args );
	
	if ( ! control_listings_template( $templates, true, false, $args ) ) {
		return false;
	}
}
endif;

if(!function_exists('control_listings_content')):
/**
 * 
 * @param 	string		$content		(required)
 * @param 	string		$before			empty
 * @param 	string		$after			empty
 * @param 	boolean		$echo			true
 * 
 * @return	string	
*/
function control_listings_content( $content, $before = '', $after = '', $echo = true ) {

	if ( strlen( $content ) == 0 ) {
		return;
	}
    $content = wp_kses_post( nl2br($content) );

	$content = $before . $content . $after;

	if ( $echo ) {
		echo wp_kses_post($content);
	} else {
		return $content;
	}
}
endif;

function control_listings_content_html($content){
	return apply_filters('control_listings_content_html', $content);
}

if(!function_exists('control_listings_css_class')):
/**
 * 
 * @param 	mixed		$class		(required) allow string or array variable
 * @param 	string		$before		(optional) default:empty
 * @param 	string		$after		empty
 * @param 	boolean		$echo		true
 * 
 * @return	string	
*/
function control_listings_css_class( $class, $before = '', $after = '', $echo = true ) {
	if(is_array($class)){
		$class = array_unique(array_filter($class));
		$class = implode('', $class);		
	}

	if ( strlen( $class ) == 0 ) {
		return;
	}
	
    $class = esc_attr( $class );

	$class = $before . $class . $after;

	if ( $echo ) {
		echo esc_attr( $class );
	} else {
		return $class;
	}
}
endif;

if(!function_exists('control_listings_button_html')):
/**
 * 
 * @param 	array		$button		(required)
 * @param 	string		$prefix		empty
 * @param 	boolean		$echo		true
 * 
 * @return	string	
*/
function control_listings_button_html($button, $prefix= '', $echo = true){
	$button = wp_parse_args( $button, [
		$prefix.'text' => 'Watch Video',
		$prefix.'url' => '',
		$prefix.'style' => '',
		$prefix.'data' => '',
		$prefix.'extra_class' => '',
		$prefix.'video' => ''
	] );

	if(empty($button[$prefix.'text']) || empty($button[$prefix.'url'])) return; 
	   
	$classes = array_filter([trim($button[$prefix.'style']), trim($button[$prefix.'extra_class'])]);   
	if(!empty($button[$prefix.'video']))  $classes[] = 'video-link';                               
	$content = sprintf(
		'<a class="btn %3$s" href="%2$s"%4$s>%1$s</a>', 
		esc_attr($button[$prefix.'text']), 
		esc_url( $button[$prefix.'url'] ), implode(' ',$classes), 
		!empty($button[$prefix.'data'])? ' '.$button[$prefix.'data'] : ''
	);
	
	if ( $echo ) {
		echo wp_kses_post($content);
	} else {
		return $content;
	}
}
endif;

if(!function_exists('is_control_listings_page')):
/**
 *  
 * @return	boolean	
*/
function is_control_listings_page(){
	if( is_archive('ctrl_listings') ){
		return true;
	}
	if( get_post_type() == 'ctrl_listings' ){
		return true;
	}

	if( is_user_logged_in() ){
		$options = get_option('control_listings');
		if( !empty($options['post_listing_page']) && is_page($options['post_listing_page'])) return true;
		if( !empty($options['my_account_page']) && is_page($options['my_account_page'])) return true;
	}
	
	return false;
}
endif;

if(!function_exists('control_listings_meta_values')):
/**
 * 
 * @param 	string		$key		(optional)
 * @param 	string		$type		ctrl_listings
 * @param 	string		$status		publish
 * 
 * @return	array	
*/
function control_listings_meta_values( $key = '', $type = 'ctrl_listings', $status = 'publish' ) {
    
    global $wpdb;
    
    if( empty( $key ) )
        return;
    
    $r = $wpdb->get_results( $wpdb->prepare( "
        SELECT pm.meta_value, pm.post_id FROM {$wpdb->postmeta} pm
        LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
        WHERE pm.meta_key = %s 
        AND p.post_status = %s 
        AND p.post_type = %s
    ", $key, $status, $type ), ARRAY_A );
    
    return array_column($r, 'meta_value', 'post_id');
}
endif;

if(!function_exists('control_listings_marker_icon_options')):
/**
 *  
 * @return	array	
*/
function control_listings_marker_icon_options(){
	return [
		'academics' => __('Academics', 'control-listings'),
		'afterschool' => __('After school care', 'control-listings'),
		'creative' => __('Creative arts', 'control-listings'),
		'dance' => __('Dance', 'control-listings'),
		'language' => __('Language', 'control-listings'),
		'literature' => __('Literature', 'control-listings'),
		'music' => __('Music', 'control-listings'),
		'travel' => __('Travel & Language', 'control-listings'),
		'performing' => __('Performing Arts', 'control-listings'),
		'outdoor' => __('Play outdoor', 'control-listings'),
		'religious' => __('Religious', 'control-listings'),
		'science-technology' => __('Science & Technology', 'control-listings'),
		'special-needs' => __('Special Needs', 'control-listings'),
		'sports' => __('Sports', 'control-listings'),
		'child' => __('Child care', 'control-listings'),
	];
}
endif;

if(!function_exists('control_listings_get_categories')):
/**
 * 
 * @param 	string		$separator		(optional)
 * @param 	string		$taxonomy		listing_cat
 * @param 	boolean		$echo			true
 * 
 * @return	string	
*/
function control_listings_get_categories($separator = ', ', $taxonomy = 'listing_cat', $echo = true){

	// Get the term IDs assigned to post.
	$post_terms = wp_get_object_terms( get_the_ID(), $taxonomy, array( 'fields' => 'ids' ) );

	if ( ! empty( $post_terms ) && ! is_wp_error( $post_terms ) ) {

		$term_ids = implode( ', ' , $post_terms );

		$terms = wp_list_categories( array(
			'title_li' => '',
			'style'    => 'none',
			'echo'     => false,
			'taxonomy' => $taxonomy,
			'include'  => $term_ids
		) );

		$terms = rtrim( trim( str_replace( '<br />',  $separator, $terms ) ), $separator );
		$terms = '<div class="d-flex flex-wrap gap-1">'.$terms.'</div>';
		
		// Display post categories.
		if($echo){
			echo wp_kses_post($terms);
		}else{
			return $terms;
		}		
	}
}
endif;

if(!function_exists('control_listings_ordering_options')):
/**
 * 
 * @param 	boolean		$single		false
 * 
 * @return	array	
*/
function control_listings_ordering_options($single = false){
    $args = array(
        'date'       => __( 'Sort by Date', 'control-listings' ),
        'atoz'      => __( 'Sort by Title (A-Z)', 'control-listings' ),
        'ztoa'      => __( 'Sort by Title (Z-A)', 'control-listings' ),
    );  
    if($single){
        return !empty($arg[$single])? $arg[$single] : NULL;
    }
    return $args;
}
endif;


if(!function_exists('control_listings_archive_page_url')):
/**
 *  
 * @return	string|false	
*/
function control_listings_archive_page_url($current_url = false){
	if($current_url && is_tax('listing_cat') && !empty(get_queried_object())){
		return get_term_link(get_queried_object()->term_id, 'listing_cat');
	}
	if($current_url && is_tax('listing_tag') && !empty(get_queried_object())){
		return get_term_link(get_queried_object()->term_id, 'listing_tag');
	}
	return get_post_type_archive_link('ctrl_listings');
}
endif;

if(!function_exists('control_listings_filter_query_vars')):
/**
 *  
 * @return	array	
*/
function control_listings_filter_query_vars(){
	return apply_filters('control_listings_filter_query_vars', [
		'terms' => __('Search', 'control-listings'),
		'sort' => __('Sort', 'control-listings'),            
		'lcat' => __('Category', 'control-listings'),
		'ltag' => __('Tag', 'control-listings'),
		'age' => __('Age', 'control-listings'),
		'price' =>__('Price', 'control-listings'),
		'view' =>__('View', 'control-listings'),
	]);
	
}
endif;

if(!function_exists('control_listings_login_link')):
/**
 * 
 * @param 	string		$title			(optional)
 * @param 	string		$link_text		login
 * @param 	string		$class			empty
 * 
 * @return	string	
*/
function control_listings_login_link($title, $link_text = 'login', $class = ''){
	$classes = [
		'ctrl-listing-login-link',
		$class
	];
	return '<a href="#controlListingsModal"  data-bs-toggle="modal" data-title="'.esc_attr($title).'" class="'.implode(' ', array_filter($classes)).'">'.$link_text.'</a>';
}
endif;


if ( ! function_exists( 'control_listings_the_posts_navigation' ) ) :
/**
 * Print the next and previous listings navigation.
 *
 * @return void
 */
function control_listings_the_posts_navigation() {
	the_posts_pagination(
		array(
			'before_page_number' => '',
			'mid_size'           => 2,
			'prev_text'          => sprintf(
				'%s <span class="nav-prev-text">%s</span>',
				control_listings_get_icon_svg( 'ui', 'prev', 10 ),
				wp_kses(
					__('Previous', 'control-listings'),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				)
			),
			'next_text'          => sprintf(
				'<span class="nav-next-text">%s</span> %s',
				wp_kses(
					__('Next', 'control-listings'),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				control_listings_get_icon_svg( 'ui', 'next', 10 )
			),
		)
	);
}
endif;

add_filter('navigation_markup_template', 'control_listings_navigation_markup_template');
if(!function_exists('control_listings_navigation_markup_template')):
/**
 * 
 * @param 	string	$template	(required)
 * 
 * @return	string	
*/
function control_listings_navigation_markup_template($template){
	if( 'ctrl_listings' === get_post_type() ){
		$template = '<nav class="navigation %1$s" aria-label="%4$s">
			<h2 class="screen-reader-text">%2$s</h2>
			<div class="nav-links numeric-pagination d-lg-flex gap-10 justify-content-lg-between">%3$s</div>
		</nav>';
	}
	
	return $template;
}
endif;

add_filter('get_the_archive_title', 'control_listings_post_type_archive_title');
add_filter('post_type_archive_title', 'control_listings_post_type_archive_title');
if(!function_exists('control_listings_post_type_archive_title')):
/**
 * 
 * @param 	string	$title	(required)
 * 
 * @return	string	
*/
function control_listings_post_type_archive_title($title){
	if( 'ctrl_listings' === get_post_type() ){
		$page_id = control_listings_setting( 'listing_archive_page' );
		$post_exists = (new WP_Query(['post_type' => 'any', 'p'=>$page_id]))->found_posts > 0;
		if($post_exists){
			$title = get_the_title($page_id);
		}
	}	
	return $title;
}
endif;

add_filter('get_the_archive_description', 'control_listings_post_type_archive_description');
if(!function_exists('control_listings_post_type_archive_description')):
/**
 * 
 * @param 	string	$title	(required)
 * 
 * @return	string	
*/
function control_listings_post_type_archive_description($description){
	if( 'ctrl_listings' === get_post_type() ){
		$page_id = control_listings_setting( 'listing_archive_page' );
		$post_exists = (new WP_Query(['post_type' => 'any', 'p'=>$page_id]))->found_posts > 0;
		if($post_exists){
			$subtitle = get_post_meta($page_id, 'subtitle', true);
			$description = !empty($subtitle)? $subtitle : $description;
		}
	}	
	return $description;
}
endif;

if(!function_exists('control_listings_get_listings_archive_slug')):
/**
 *  
 * @return	string	
*/
function control_listings_get_listings_archive_slug(){
	$slug = apply_filters('control_listings_get_listings_archive_slug', 'listings');	
		
	$page_id = control_listings_setting( 'listing_archive_page' );
	$post_exists = (new WP_Query(['post_type' => 'any', 'p'=>$page_id]))->found_posts > 0;
	if($post_exists){
		$post = get_post($page_id);	
		if(!empty($post->post_name)){
			$slug = $post->post_name;
		}	
		
	}
	
	return $slug;
}
endif;

if(!function_exists('control_listings_nav_menu_item_classes')):
/**
 * Fix active class in nav for shop page.
 *
 * @param 	array 	menu_items 	Menu items.
 * 
 * @return 	array
 */
function control_listings_nav_menu_item_classes( $menu_items ) {
	$archive_page      = control_listings_setting( 'listing_archive_page' );
	$page_for_posts = (int) get_option( 'page_for_posts' );

	if ( ! empty( $menu_items ) && is_array( $menu_items ) ) {
		foreach ( $menu_items as $key => $menu_item ) {
			$classes = (array) $menu_item->classes;
			$menu_id = (int) $menu_item->object_id;

			// Unset active class for blog page.
			if ( $page_for_posts === $menu_id ) {
				$menu_items[ $key ]->current = false;

				if ( in_array( 'current_page_parent', $classes, true ) ) {
					unset( $classes[ array_search( 'current_page_parent', $classes, true ) ] );
				}

				if ( in_array( 'current-menu-item', $classes, true ) ) {
					unset( $classes[ array_search( 'current-menu-item', $classes, true ) ] );
				}
			} elseif ( ($archive_page === $menu_id && 'page' === $menu_item->object) ) {
				// Set active state if this is the listings page link.
				if(get_post_type() == 'ctrl_listings'){
					$menu_items[ $key ]->current = true;
					$classes[]                   = 'current-menu-item';
					$classes[]                   = 'current_page_item';
				}
				

			} elseif ( is_singular( 'ctrl_listings' ) && $archive_page === $menu_id ) {
				// Set parent state if this is a listing page.
				$classes[] = 'current_page_parent';
			}

			$menu_items[ $key ]->classes = array_unique( $classes );
		}
	}

	return $menu_items;
}
endif;

add_filter( 'wp_nav_menu_objects', 'control_listings_nav_menu_item_classes', 2 );
if(!function_exists('control_listings_get_posts_options')):
/**
 * 
 * @param 	string	$key		(required)
 * @param 	string	$post_type	ctrl_listings
 * 
 * @return	array	
*/
function control_listings_get_posts_options($key = 'ID', $post_type = 'ctrl_listings'){
	$args = array(
		'numberposts' => -1,
		'post_type'   => $post_type
	  );
	  $options = [];
	  
	$all_posts = get_posts( $args );
	if(!empty($all_posts) && !is_wp_error($all_posts)){
		foreach ($all_posts as $value) {
			$post = (array)$value;
			$options[$post[$key]] = $post['post_title'];
		}
	}
	  
	return $options;  
}
endif;

if(!function_exists('control_listings_get_terms_options')):
/**
 * 
 * @param 	string	$key			(required)
 * @param 	string	$taxonomy		listing_tag
 * @param 	boolean	$hide_empty		true
 * 
 * @return	array	
*/
function control_listings_get_terms_options($key = 'term_id', $taxonomy = 'listing_tag', $hide_empty = true){
	$args = array(
		'hide_empty' => $hide_empty,
		'taxonomy'   => $taxonomy,
	  );
	  $options = [];
	  
	$terms = get_terms( $args );
	if(!empty($terms) && !is_wp_error($terms)){
		foreach ($terms as $value) {
			$term = (array)$value;
			$options[$term[$key]] = $term['name'];
		}
	}
	  
	return $options;  
}
endif;

if(!function_exists('control_listings_tags_by_post_id')):
/**
 * 
 * @param 	string	$post_id	null
 *  
 * @return	array	
*/
function control_listings_tags_by_post_id($post_id=NULL){
	$post_id = empty($post_id)? filter_input( INPUT_GET, 'listings_frontend_post_id', FILTER_SANITIZE_NUMBER_INT ) : $post_id;
	if(empty($post_id)) return;
	$terms = get_the_terms($post_id, 'listing_tag');
	$options = [];
	if(!empty($terms) && !is_wp_error($terms)){
		foreach ($terms as $value) {
			$term = (array)$value;
			$options[$term['term_id']] = $term['name'];
		}
	}
	return implode(', ', $options);
}
endif;

if(!function_exists('control_listings_add_listing_url')):
/**
 *   
 * @return	boolean	
*/
function control_listings_add_listing_url(){
	$page_id = control_listings_setting('post_listing_page');
	if($page_id) return get_permalink($page_id);
	return false;
}
endif;


if(!function_exists('control_listings_user_dashboard_url')):
/**
 *   
 * @return	boolean	
*/
function control_listings_user_dashboard_url(){
	$page_id = control_listings_setting('my_account_page');	
	if($page_id) return get_permalink($page_id);
	return false;
}
endif;


if(!function_exists('control_listings_logout_url')):
/**
 * Get logout endpoint.
 *
 * @param 	string $redirect Redirect URL.
 *
 * @return 	string
 */
function control_listings_logout_url( $redirect = '' ) {
	$redirect = $redirect ? $redirect : apply_filters( 'control_listings_logout_default_redirect_url', control_listings_get_page_permalink( 'my_account_page' ) );

	return wp_logout_url( $redirect );
}
endif;

if(!function_exists('control_listings_get_page_permalink')):
/**
 * Retrieve page permalink.
 *
 * @param 	string      	$page 		page slug.
 * @param 	string|bool 	$fallback 	Fallback URL if page is not set. Defaults to home URL.
 * 
 * @return 	string
 */
function control_listings_get_page_permalink( $page, $fallback = null ) {
	$page_id   = control_listings_setting( $page );
	$permalink = 0 < $page_id ? get_permalink( $page_id ) : '';

	if ( ! $permalink ) {
		$permalink = is_null( $fallback ) ? get_home_url() : $fallback;
	}

	return apply_filters( 'control_listings_get_' . $page . '_page_permalink', $permalink );
}
endif;

if(!function_exists('control_listing_get_account_end_points')):
/**
 * 
 * @return array
 */
function control_listing_get_account_end_points() {
	return array(
		'dashboard'          => control_listings_setting( 'dashboard_endpoint', 'dashboard' ),
		'profile'       => control_listings_setting( 'edit_profile_endpoint', 'profile' ),
		'favorites'    => control_listings_setting( 'favorites_endpoint', 'favorites' ),
		'bookmarked' => control_listings_setting( 'bookmarked_endpoint', 'bookmarked' ),
		'user-logout' => control_listings_setting( 'logout_endpoint', 'user-logout' ),
	);
}
endif;

if(!function_exists('control_listing_get_account_menu_items')):
/**
 * Get My Account menu items.
 *
 * @return array
 */
function control_listing_get_account_menu_items() {
	$endpoints = control_listing_get_account_end_points();

	$items = array(
		'dashboard'       => __( 'Dashboard', 'control-listings' ),
		'profile'          => __( 'Account details', 'control-listings' ),
		'favorites'       => __( 'Favorites', 'control-listings' ),
		'bookmarked'    => __( 'Bookmarked', 'control-listings' ),
		'user-logout' => __( 'Logout', 'control-listings' ),
	);

	// Remove missing endpoints.
	foreach ( $endpoints as $endpoint_id => $endpoint ) {
		if ( empty( $endpoint ) ) {
			unset( $items[ $endpoint_id ] );
		}
	}

	return apply_filters( 'control_listing_account_menu_items', $items, $endpoints );
}
endif;

if(!function_exists('control_listing_dashboard_menu_item_classes')):
/**
 * Get account menu item classes.
 *
 * @param 	string 	$endpoint Endpoint.
 * 
 * @return 	string
 */
function control_listing_dashboard_menu_item_classes( $endpoint ) {
	global $wp;

	$classes = array(
		'nav-link',
		'nav-link-' . $endpoint,
	);

	// Set current item class.
	$current = isset( $wp->query_vars[ $endpoint ] );
	if ( 'dashboard' === $endpoint && ( isset( $wp->query_vars['page'] ) || empty( $wp->query_vars ) ) ) {
		$current = true; // Dashboard is not an endpoint, so needs a custom check.
	} 

	if ( 'user-logout' == $endpoint ) {
		$classes[] = 'text-danger';
	} 

	if ( $current ) {
		$classes[] = 'active';
	}

	$classes = apply_filters( 'control_listing_account_menu_item_classes', $classes, $endpoint );

	return implode( ' ', array_map( 'sanitize_html_class', $classes ) );
}
endif;


if(!function_exists('control_listing_get_account_endpoint_url')):
/**
 * Get account endpoint URL.
 *
 * @param 	string 	$endpoint Endpoint.
 * 
 * @return 	string
 */
function control_listing_get_account_endpoint_url( $endpoint ) {
	if ( 'dashboard' === $endpoint ) {
		return control_listings_get_page_permalink( 'my_account_page' );
	}

	if ( 'user-logout' === $endpoint ) {
		return control_listings_logout_url();
	}

	return control_listings_get_endpoint_url( $endpoint, '', control_listings_get_page_permalink( 'my_account_page' ) );
}
endif;

if(!function_exists('control_listings_get_endpoint_url')):
/**
 * Get endpoint URL.
 *
 * Gets the URL for an endpoint, which varies depending on permalink settings.
 *
 * @param  string 	$endpoint  	Endpoint slug.
 * @param  string 	$value     	Query param value.
 * @param  string 	$permalink 	Permalink.
 *
 * @return string
 */
function control_listings_get_endpoint_url( $endpoint, $value = '', $permalink = '' ) {
	if ( ! $permalink ) {
		$permalink = get_permalink();
	}

	// Map endpoint to options.
	$query_vars = control_listing_get_account_end_points();
	$endpoint   = ! empty( $query_vars[ $endpoint ] ) ? $query_vars[ $endpoint ] : $endpoint;

	if ( get_option( 'permalink_structure' ) ) {
		if ( strstr( $permalink, '?' ) ) {
			$query_string = '?' . wp_parse_url( $permalink, PHP_URL_QUERY );
			$permalink    = current( explode( '?', $permalink ) );
		} else {
			$query_string = '';
		}
		$url = trailingslashit( $permalink );

		if ( $value ) {
			$url .= trailingslashit( $endpoint ) . user_trailingslashit( $value );
		} else {
			$url .= user_trailingslashit( $endpoint );
		}

		$url .= $query_string;
	} else {
		$url = add_query_arg( $endpoint, $value, $permalink );
	}

	return apply_filters( 'control_listings_get_endpoint_url', $url, $endpoint, $value, $permalink );
}
endif;

function control_listings_render_block_template($attributes, $is_preview = false, $post_id = null){
	// Fields data.
    if ( empty( $attributes['data'] ) ) {
        return;
    }	

	$template_file = 'elements/'.$attributes['name'].'.php'; 
	$located = control_listings_template($template_file);
	
	if($located){
		$atts = $attributes['data'];
		extract($atts);
		include $located;
		return;
	}else{
		if(is_user_logged_in()){
			esc_attr_e('template not found!!!', 'control-listings'); 
		}
		
	}	
	 
}


function control_listings_wp_query_field($args = array(), $group = true){	
	$default = array(
        'post_type' => 'ctrl_listings',
		'posts_per_page' => get_option( 'posts_per_page' ),
		'post__in' => array(),
		'post__not_in' => array(),
		'ignore_sticky_posts' => 1,
		'post_status' => 'publish',
		'order' => 'DESC',
		'orderby' => 'date',
	);
	$std = wp_parse_args( $args, $default);
	extract($std);	

    $group_fields = array(
        array (
            'id' => 'post_type',
            'type' => 'hidden',	
            'std'  => $post_type,
            'attributes' => ['value' => $post_type]
        ),															
        array (
            'id' => 'posts_per_page',
            'type' => 'number',
            'name' => __( 'Posts per page', 'control-listings' ),
            'desc' => __( ' (int) number of post to show per page. -1 to show all posts', 'control-listings' ),
            'min'  => -1,
            'step' => 1,
        ),
        array (
            'id' => 'post__in',
            'type' => 'post',
            'name' => __( 'Include specific posts', 'control-listings' ),
            'placeholder' => __( 'Select posts..', 'control-listings' ),
            'desc' => __( 'mulliple selection is allowed', 'control-listings' ),
            'field_type' => 'select_advanced',
            'ajax' => true,
            'multiple' => true,
            'query_args' => array(
                'post_type' => esc_attr($post_type),
                'posts_per_page' => -1
            )

        ),
        array (
            'id' => 'post__not_in',
            'type' => 'post',
            'name' => __( 'Exclude specific posts', 'control-listings' ),
            'placeholder' => __( 'Select posts..', 'control-listings' ),
            'desc' => __( 'mulliple selection is allowed', 'control-listings' ),
            'field_type' => 'select_advanced',
            'ajax' => true,
            'multiple' => true,
            'query_args' => array(
                'post_type' => esc_attr($post_type),
                'posts_per_page' => -1
            ),

        ),
        array (
            'id' => 'ignore_sticky_posts',
            'type' => 'switch',
            'name' => __( 'Ignore sticky posts', 'control-listings' ),
        ),	
        array(
            'id'       => 'post_status',
            'name'     => __( 'Post status', 'control-listings' ),
            'type'     => 'select',
            'options'  => array(
                'publish'      => 'Publish',
                'pending'    => 'Pending',
                'draft'    => 'Draft',
                'future'    => 'Future',
                'private'    => 'Private',
                'inherit'    => 'Inherit',
                'trash'    => 'Trash',
                'any'    => 'Any',					       
            ),
            'inline'   => true,
            'multiple' => false,
        ),				
        array(
            'id'       => 'order',
            'name'     => __( 'Order', 'control-listings' ),
            'type'     => 'select',
            'options'  => array(
                'ASC'      => 'ASC',
                'DESC'    => 'DESC',
                
            ),
            'inline'   => true,
            'multiple' => false,
        ),
        array(
            'id'       => 'orderby',
            'name'     => __( 'Order by', 'control-listings' ),
            'type'     => 'select',
            'options'  => array(
                'none'      => 'none',
                'ID'    => 'ID',
                'author'    => 'Author',
                'title'    => 'Title',
                'name'    => 'Same',
                'date'    => 'Date',
                'modified'    => 'Modified date',
                'rand'    => 'Random',
                'comment_count'    => 'Comments',					       
            ),
            'inline'   => true,
            'multiple' => false,
        ),					
    );

    if(!$group){
        // setup default value
        foreach ($group_fields as $key => $value) {
            if(empty($std[$value['id']])) continue;
            $value['std'] = $std[$value['id']];
            $group_fields[$key] = $value;
        }
        return $group_fields;
    }
	
	$field = array(
        'id' => 'query_args',
        'type' => 'group',
        'clone' => false,
        'default_state' => 'collapsed',
        'collapsible' => true,
        'save_state' => false,
        'group_title' => 'Query: per_page: {posts_per_page} post_type: {post_type}',	
        'std' => $std,		
        'fields' => $group_fields,
    );

    return $field;
}

/**
 * Get size information for all currently-registered image sizes.
 *
 * @global $_wp_additional_image_sizes
 * @uses   get_intermediate_image_sizes()
 * @return array $sizes Data for all currently-registered image sizes.
 */
function control_listings_get_image_sizes() {
	global $_wp_additional_image_sizes;
	
	$sizes = array();
	
	foreach ( get_intermediate_image_sizes() as $_size ) {
		if ( in_array( $_size, array(
			'thumbnail',
			'medium',
			'medium_large',
			'large' 
		) ) ) {
			$sizes[ $_size ][ 'width' ]  = get_option( "{$_size}_size_w" );
			$sizes[ $_size ][ 'height' ] = get_option( "{$_size}_size_h" );
			$sizes[ $_size ][ 'crop' ]   = (bool) get_option( "{$_size}_crop" );
		} //in_array( $_size, array( 'thumbnail', 'medium', 'medium_large', 'large' ) )
		elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
			$sizes[ $_size ] = array(
				 'width' => $_wp_additional_image_sizes[ $_size ][ 'width' ],
				'height' => $_wp_additional_image_sizes[ $_size ][ 'height' ],
				'crop' => $_wp_additional_image_sizes[ $_size ][ 'crop' ] 
			);
		} //isset( $_wp_additional_image_sizes[ $_size ] )
	} //get_intermediate_image_sizes() as $_size
	
	return $sizes;
}

function control_listings_get_image_sizes_options() {
  $sizes = control_listings_get_image_sizes();

  $arr = array();
  foreach ($sizes as $key => $value) {
     $arr[$key] = ucfirst(trim(str_replace(['-', '_', 'ctrl'], ' ', $key)));
  }
  
  return $arr;
}

function control_listings_count_posts_published($post_type = 'ctrl_listings'){	 
	return wp_count_posts($post_type)->publish;
}

function control_listings_get_map_marker_icon($size = 24){
	$icon = control_listings_get_icon_svg('ui', 'child', $size);
	$terms = (array)get_the_terms( get_the_ID(), 'listing_cat' );
	if( !empty($terms) && !is_wp_error($terms) ){
		$term = reset($terms);
		$term_icon_id = rwmb_meta( 'icon', ['object_type' => 'term'], $term->term_id );
		$term_icon = control_listings_get_icon_svg('marker', $term_icon_id, $size );
		$icon = !empty($term_icon)? $term_icon : $icon;
	}
	
	return $icon;
}

/**
 * Undocumented function
 *
 * @param mixed $attachment_id
 * @return string
 */
function control_listings_get_attachment_url($attachment_id){
	if(is_array($attachment_id)){
		$attachment_id = reset($attachment_id);
	}
	return  wp_get_attachment_url($attachment_id);
}

if ( ! function_exists( 'mb_get_block_field' ) ) {
	function mb_get_block_field( $field_id, $args = [] ) {
		$block_name          = MBBlocks\ActiveBlock::get_block_name();
		$args['object_type'] = 'block';
		return rwmb_get_value( $field_id, $args, $block_name );
	}
}

if ( ! function_exists( 'mb_the_block_field' ) ) {
	function mb_the_block_field( $field_id, $args = [], $echo = true ) {
		$block_name          = MBBlocks\ActiveBlock::get_block_name();
		$args['object_type'] = 'block';
		return rwmb_the_value( $field_id, $args, $block_name, $echo );
	}
}

function check_is_inactive_control_listings_pro($echo = false, $output = ''){
	
	if(!defined('CTRL_LISTINGS_PRO_VER')):
		$output =  __('Pro version required.', 'control-listings');
		
		if( $echo ){
			echo sprintf(
				'<div class="alert alert-warning" role="alert">%s</div>',
				wp_kses_post($output)
			);
		}
		return '<div class="alert alert-warning" role="alert">
		'.$output.'</div>';
	endif;
}