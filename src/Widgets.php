<?php
namespace ControlListings;
defined( 'ABSPATH' ) || exit;

final class Widgets{

    public function __construct() {    
        
        add_filter('widget_comments_args', [$this, 'widget_comments_args']);
        add_filter('comment_feed_where', [$this, 'comment_feed_where']);
        
        
	}

   
    function widget_comments_args( $args ) {
        $args['post_type'] = [
            'post'
        ];

        return $args;
    }

    function comment_feed_where( $where ) {
        return $where . " AND wp_posts.post_type NOT IN ( 'ctrl_listings' )";
    }
    
}