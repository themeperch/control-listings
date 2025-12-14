<?php
namespace ControlListings;

class AdminColumn {
	private $post_types = ['ctrl_listings'];
	public function __construct () {
		add_filter('display_post_states', [$this, 'display_post_states'], 10, 2);

		foreach ( $this->post_types as $type ) {
			add_filter( "manage_{$type}_posts_columns", [ $this, 'register_admin_column' ] );
			add_action( "manage_{$type}_posts_custom_column", [ $this, 'customize_admin_column' ], 10, 2 );
		}
	}

	public function display_post_states($post_states, $post){
		
		if($post->post_type == 'ctrl_listings' && !empty($post_states['sticky'])) {
			unset($post_states['sticky']);
		}
		return $post_states;
	}

	public function register_admin_column( $columns ) {
		if(get_query_var('post_status') === 'trash') {
			return $columns;
		}
		$new_columns = [];
		foreach ($columns as $key => $value) {
			$new_columns[$key] = $value;
			if($key == 'comments'){
				$new_columns['favorites'] = SVG_Icons::get_svg('ui', 'love-fill', 16) ;
			}
			if($key == 'cb'){
				$new_columns['sticky_post'] = '<span class="dashicons dashicons-sticky"></span>';
			}
		}
		return $new_columns;
	}
	public function customize_admin_column( $column_key, $post_id ) {
		if( 'favorites' === $column_key ) {
			echo Favorite::get_count( $post_id );
		}

		if( 'sticky_post' === $column_key ) {
			$hyperlink_class = 'sticky-posts';
			$hyperlink_style = '';
			$icon_class = 'dashicons-star-empty';			
			
			if(is_sticky($post_id))
			{
				$hyperlink_class .= ' active';
				$icon_class = 'dashicons-star-filled';
				
			}

			printf('<a id="%s" title="%s" class="%s" %s href="javascript:void(0);" data-id="%d" data-nonce="%s"><span class="dashicons %s"></span></a>',
				'stiky-post-'.$post_id,
				is_sticky($post_id)? __('Featured listing', 'control-listings') : __('Click to make listing featured', 'control-listings'),
				$hyperlink_class,
				$hyperlink_style,
				$post_id,
				wp_create_nonce('sticky-post-nonce'),
				$icon_class
			);

			
			
		}
	}

}
