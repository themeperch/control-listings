<?php
namespace ControlListings;
defined( 'ABSPATH' ) || exit;
class Walker_Review extends \Walker_Comment {

	/**
	 * Outputs a comment in the HTML5 format.
	 *
	 * @see wp_list_comments()
	 *
	 * @param WP_Comment $comment Comment to display.
	 * @param int        $depth   Depth of the current comment.
	 * @param array      $args    An array of arguments.
	 */
	protected function html5_comment( $comment, $depth, $args ) {

		$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';

		$commenter          = wp_get_current_commenter();
		$show_pending_links = ! empty( $commenter['comment_author'] );

		if ( $commenter['comment_author_email'] ) {
			$moderation_note = __( 'Your comment is awaiting moderation.', 'control-listings' );
		} else {
			$moderation_note = __( 'Your comment is awaiting moderation. This is a preview; your comment will be visible after it has been approved.', 'control-listings' );
		}
		?>
		<<?php echo esc_attr($tag); ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $this->has_children ? 'parent' : '', $comment ); ?>>
			<article id="review-<?php comment_ID(); ?>" class="review-body comment-body d-grid gap-15" data-id="<?php comment_ID(); ?>">
				<footer class="review-meta comment-meta d-flex align-items-end gap-15">
					<div class="review-author comment-author vcard">
						<?php
						if ( 0 != $args['avatar_size'] ) {
							echo get_avatar( $comment, $args['avatar_size'] );
						}
						?>						
					</div><!-- .comment-author -->

					<div class="review-metadata comment-metadata d-grid">
                        <?php
						$comment_author = get_comment_author_link( $comment );

						if ( '0' == $comment->comment_approved && ! $show_pending_links ) {
							$comment_author = get_comment_author( $comment );
						}

						printf(	'<span class="reviewr-name">%1$s <span class="says">%2$s</span></span>',
							sprintf( '<b class="fn">%s</b>', esc_attr($comment_author ) ), esc_attr__('says:', 'control-listings')
						);
						?>
						<?php
						printf(
							'<a href="%s"><time datetime="%s">%s</time></a>',
							esc_url( get_comment_link( $comment, $args ) ),
							esc_attr(get_comment_time( 'c' )),
							sprintf(
								/* translators: 1: Comment date, 2: Comment time. */
								esc_attr_x( '%1$s at %2$s', 'Comments date time', 'control-listings' ),
								esc_attr(get_comment_date( '', $comment )),
								esc_attr(get_comment_time())
							)
						);
                        control_listings_get_comment_rating('rating', true);
						
						?>
                        
					</div><!-- .comment-metadata -->
                    

					<div class="ms-lg-auto d-flex gap-15">
                        <?php                  
                        control_listings_edit_review_link();                        
                        if ( '1' == $comment->comment_approved || $show_pending_links ) {
                            comment_reply_link(
                                array_merge(
                                    $args,
                                    array(
                                        'add_below' => 'div-comment',
                                        'depth'     => $depth,
                                        'max_depth' => $args['max_depth'],
                                        'before'    => '<div class="reply">',
                                        'after'     => '</div>',
                                    )
                                )
                            );
                        }
                        ?>
                    </div>
				</footer><!-- .comment-meta -->

				<div class="review-content comment-content d-grid gap-10 mb-30">
                    <?php if ( '0' == $comment->comment_approved ) : ?>
					    <em class="review-awaiting-moderation comment-awaiting-moderation"><?php echo esc_attr($moderation_note); ?></em>
					<?php endif; ?> 
					<div class="listing-review-text"><?php comment_text(); ?></div>     
					<div class="row row-cols-1 row-cols-lg-3 gy-10">
                        <?php 
                        foreach (control_listings_get_rating_fields() as $field) :
                            if( !$field['enable']) continue;
                            $name = $field['name'];
                            $rating = control_listings_get_comment_rating($name);
                            echo !empty($rating)? '<div class="col"><span class="text-uppercase">'.esc_attr($field['label']).'</span>'.wp_kses_post($rating).'</div>' : '';
                            
                        endforeach;    
                        ?>
                    </div>               
				</div><!-- .comment-content -->

				
			</article><!-- .comment-body -->
		<?php
	}
}