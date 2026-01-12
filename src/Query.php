<?php
namespace ControlListings;
defined( 'ABSPATH' ) || exit;

final class Query{

    public function __construct() {    
        
        add_filter('query_vars', [$this, 'query_vars']);
        add_action( 'pre_get_posts', [$this, 'pre_get_posts'] );
        add_filter('the_posts', array($this, 'the_posts'), 1, 2);
        
	}

    public function query_vars($qvars){
        foreach (control_listings_filter_query_vars() as $query_var => $value) {
            if(empty($value)) continue;
            $qvars[] = esc_attr($query_var);
        }

        return $qvars;
    }

    

    function pre_get_posts( $query ) {
        
        
        if ( $query->is_post_type_archive( 'ctrl_listings' ) && $query->is_main_query() && ! is_admin() ) {
            $this->filter_query_view($query);
            $posts_per_page = control_listings_setting('posts_per_page', 12);
            // phpcs:ignore WordPress.Security.NonceVerification.Recommended
            if(isset($_GET['per_page']) & !empty($_GET['per_page'])){
                // phpcs:ignore WordPress.Security.NonceVerification.Recommended
                $posts_per_page = intval($_GET['per_page']);
            }
            $query->set( 'posts_per_page', $posts_per_page );
            
            $query->set( 'ignore_sticky_posts', false ); 
            
            
            foreach (control_listings_filter_query_vars() as $query_var => $value) { 
                if(empty(get_query_var($query_var))) continue;
                if(empty($value)) continue;

                $method = 'filter_query_'.$query_var;            
                if(method_exists($this, $method )){
                    $this->$method($query);                    
                }
                
            }            

            if(get_query_var('search') == 'listings'){
                $query->set( 'post_type', 'ctrl_listings' );
            }            
            
        }

        
    }

    /*
    * Check if sticky posts are allowed on this page
    */
    public function the_posts($posts, $wp_query){
        if($wp_query->query_vars['suppress_filters'] || ($wp_query->is_main_query() &&  is_admin())) {
            return $posts;
        }      

        // Retrieve the currently-queried object
        $queried_object = $wp_query->get_queried_object();

        // Show sticky posts on post type archive
        if( $queried_object instanceof \WP_Post_Type && $this->is_show_on_archive($queried_object->name) )
        {
            if ( $wp_query->is_post_type_archive($queried_object->name) ) {
                return $this->retrieve_sticky_posts($wp_query, $posts);
            }
        }

        // Show sticky posts on taxonomy page
        if( $queried_object instanceof \WP_Term && $this->is_show_on_taxonomy($queried_object->taxonomy) )
        {
            if ( $wp_query->is_category() || $wp_query->is_tax() || $wp_query->is_tag() || $wp_query->is_date() || $wp_query->is_author() ) {
                return $this->retrieve_sticky_posts($wp_query, $posts);
            }
        }

        return $posts;
    }

    /**
     * Change the retrieved posts from the custom post type, to put the sticky posts on the top
     * Filters the array of retrieved posts after they’ve been fetched and internally processed.
     *
     * Based on wp-includes/class-wp-query:2942
     *
     * @return array List of posts.
     */
    private function retrieve_sticky_posts($wp_query, $posts) {
        $page = 1;
        if ( empty($wp_query->query_vars['nopaging']) && !$wp_query->is_singular ){
            $page = absint($wp_query->query_vars['paged']);

            if (!$page) {
                $page = 1;
            }
        }

        // Put sticky posts at the top of the posts array
        $sticky_posts = get_option('sticky_posts');
        foreach ($sticky_posts as $key => $post_id) {
            if(!in_array(get_post_type($post_id), ['ctrl_listings']))
            unset($sticky_posts[$key]);
        }
        if ($page <= 1 && is_array($sticky_posts) && !empty($sticky_posts) && !$wp_query->query_vars['ignore_sticky_posts'] ){
            $num_posts = count($posts);
            $sticky_offset = 0;
            // Loop over posts and relocate stickies to the front.
            for ( $i = 0; $i < $num_posts; $i++ ){
                if ( in_array($posts[$i]->ID, $sticky_posts) ){
                    $sticky_post = $posts[$i];
                    // Remove sticky from current position
                    array_splice($posts, $i, 1);
                    // Move to front, after other stickies
                    array_splice($posts, $sticky_offset, 0, array($sticky_post));
                    // Increment the sticky offset. The next sticky will be placed at this offset.
                    $sticky_offset++;
                    // Remove post from sticky posts array
                    $offset = array_search($sticky_post->ID, $sticky_posts);
                    unset( $sticky_posts[$offset] );
                }
            }

            // If any posts have been excluded specifically, Ignore those that are sticky.
            if ( !empty($sticky_posts) && !empty($q['post__not_in']) ) {
                $sticky_posts = array_diff($sticky_posts, $q['post__not_in']);
            }

            // Fetch sticky posts that weren't in the query results
            if ( !empty($sticky_posts) )
            {
                // Prevent maximum function nesting level error
                remove_filter('the_posts', array($this, 'the_posts'), 1, 2);

                $stickies = get_posts( array(
                    'post__in'      => $sticky_posts,
                    'post_type'     => $wp_query->query_vars['post_type'],
                    'post_status'   => 'publish',
                    'nopaging'      => true
                ) );

                add_filter('the_posts', array($this, 'the_posts'), 1, 2);

                foreach ( $stickies as $sticky_post ) {
                    array_splice( $posts, $sticky_offset, 0, array( $sticky_post ) );
                    $sticky_offset++;
                }
            }
        }

        return $posts;
    }
    
    /*
    * Check if sticky posts are allowed to show on archive page
    */
    private function is_show_on_archive($post_type){
        if(in_array($post_type, ['ctrl_listings'])) {
            return true;
        }

        return false;
    }

    /*
    * Check if sticky posts are allowed to show on taxonomy page
    */
    private function is_show_on_taxonomy($taxonomy){
        if(in_array($taxonomy, ['listing_cat'])) {
            return true;
        }

        return false;
    }

   

    private function filter_query_sort($query){
        switch (get_query_var('sort')) {
            case 'date':
                $query->set( 'orderby', 'date' );
                break;
            case 'atoz':
                $query->set( 'orderby', 'title' );
                $query->set( 'order', 'ASC' );
                break; 
            case 'ztoa':
                $query->set( 'orderby', 'title' );
                $query->set( 'order', 'DESC' );
                break;        
            
            default:
                break;
        }
    }

    private function filter_query_view($query){
        // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.MissingUnslash 
        $view = isset($_COOKIE['ctrl_listings_view'])? sanitize_title($_COOKIE['ctrl_listings_view'])  : control_listings_option('ctrl_listings_view', 'grid');
        
        if( in_array(get_query_var('view'), ['grid', 'list', 'map']) ){
            $view = get_query_var('view');          
            setcookie('ctrl_listings_view', get_query_var('view', $view));   
        }

        if( empty(control_listings_option('control_listings_display_view_switch', true)) ){
            $query->set( 'view', apply_filters('control_listings_archive_view_std', 'grid') );
        }
        
        $query->set( 'view', $view );
         
    }

    private function filter_query_terms($query){
        
        $squery = apply_filters( 'control_listings_get_search_query', get_query_var( 'terms' ) );
        if(!empty($squery)){
            $squery = sanitize_text_field($squery);
            $squery = preg_replace( '/[^a-zA-Z0-9\s]/', '', $squery );
        }
        
        $query->set( 'terms',  $squery);   
        $query->set( 's',  $squery);   
        $query->set( 'ignore_sticky_posts', true ); 
        
        
    }

    private function filter_query_lcat($query){
        $tax_query = (array)$query->get('tax_query');
        $tax_query[] = [
            'taxonomy' => 'listing_cat',
            'field'    => 'slug',
            'terms'    => explode(',', get_query_var('lcat'))
        ];
        $query->set('tax_query',$tax_query);   
        $query->set( 'ignore_sticky_posts', true );
    }

    private function filter_query_ltag($query){
        $tax_query = (array)$query->get('tax_query');
        $tax_query[] = [
            'taxonomy' => 'listing_tag',
            'field'    => 'slug',
            'terms'    => explode(',', get_query_var('ltag'))
        ];
        $query->set('tax_query',$tax_query);   
        $query->set( 'ignore_sticky_posts', true );
    }

    private function filter_query_age($query){
        $age = explode('-', get_query_var('age'));   
        $min = (!empty($age[0]) && is_numeric($age[0]))? $age[0] : false;
        $max = (!empty($age[1]) && is_numeric($age[1]))? $age[1] : false;

        $meta_query = (array)$query->get('meta_query');
        $new_meta_query = [
            'relation' => 'AND'
        ];
        if($min){
            
            $new_meta_query[] = array(
                'key'     => 'min_age',
                'value'   => $min,
                'compare' => '>=',
                'type' => 'NUMERIC'
            ); 
        }

        if($max){
            $new_meta_query[] = array(
                'key'     => 'max_age',
                'value'   => $max,
                'compare' => '<=',
                'type' => 'NUMERIC'
            ); 
        }

        $meta_query[] =  $new_meta_query;
           

        // Set the meta query to the complete, altered query
        $query->set('meta_query',$meta_query);
        $query->set( 'ignore_sticky_posts', true );
        
    }

    private function filter_query_price($query){
        $price = explode('-', get_query_var('price'));   
        $min = (!empty($age[0]) && is_numeric($price[0]))? $price[0] : false;
        $max = (!empty($age[1]) && is_numeric($price[1]))? $price[1] : false;

        $meta_query = (array)$query->get('meta_query');
        $new_meta_query = [
            'relation' => 'AND'
        ];
        if($min){
            
            $new_meta_query[] = array(
                'key'     => 'min_price',
                'value'   => $min,
                'compare' => '>=',
                'type' => 'NUMERIC'
            ); 
        }

        if($max){
            $new_meta_query[] = array(
                'key'     => 'max_price',
                'value'   => $max,
                'compare' => '<=',
                'type' => 'NUMERIC'
            ); 
        }

        $meta_query[] = $new_meta_query;
           

        // Set the meta query to the complete, altered query
        $query->set('meta_query',$meta_query);
        $query->set( 'ignore_sticky_posts', true );
        
    }
    
}