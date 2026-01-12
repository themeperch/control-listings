<?php
/**
 * The template for displaying reviews
 *
 * This is the template that displays the area of the page that contains both the current reviews
 * and the review form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password,
 * return early without loading the reviews.
 */
if ( post_password_required() ) {
	return;
}

$total_review_count = get_comments_number();
?>

<div id="comments" class="reviews-area comments-area accordion d-grid gap-30 <?php echo get_option( 'show_avatars' ) ? 'show-avatars' : ''; ?>">

	<?php
	if ( have_comments() ) :
		?>
		<h2 id="headingReviews" class="comments-title">
			<?php if ( '1' === $total_review_count ) : ?>
				<?php /* translators: %s: Post title. */ printf(esc_html__( '1 review on %s', 'control-listings' ), esc_attr(get_the_title())); ?>
			<?php else : ?>
				<?php
				printf(
					/* translators: 1: Number of reviews, 2: Post title. */
					esc_html( _nx( '%1$s review on %2$s', '%1$s reviews on %2$s', $total_review_count, 'Reviews title', 'control-listings' ) ),
					esc_html( number_format_i18n( $total_review_count ) ),
					esc_attr(get_the_title())
				);
				?>
			<?php endif; ?>
		</h2><!-- .comments-title -->
		<div id="listingReviews">		
			<ol class="listing-reviews comment-list list-unstyled">
				<?php
				wp_list_comments(
					array(
						'avatar_size' => 64,
						'style'       => 'ol',
						'short_ping'  => true,
						'max_depth' => 1,
						'walker' => new ControlListings\Walker_Review()
					)
				);
				?>
			</ol><!-- .comment-list -->

			<?php
			the_comments_pagination(
				array(
					'before_page_number' => esc_html__( 'Page', 'control-listings' ) . ' ',
					'mid_size'           => 0,
					'prev_text'          => sprintf(
						'%s <span class="nav-prev-text">%s</span>',
						is_rtl() ? control_listings_get_icon_svg( 'ui', 'arrow_right' ) : control_listings_get_icon_svg( 'ui', 'arrow_left' ),
						esc_html__( 'Older reviews', 'control-listings' )
					),
					'next_text'          => sprintf(
						'<span class="nav-next-text">%s</span> %s',
						esc_html__( 'Newer reviews', 'control-listings' ),
						is_rtl() ? control_listings_get_icon_svg( 'ui', 'arrow_left' ) : control_listings_get_icon_svg( 'ui', 'arrow_right' )
					),
				)
			);
			?>

			<?php if ( ! comments_open() ) : ?>
				<p class="no-comments"><?php esc_html_e( 'Reviews are closed.', 'control-listings' ); ?></p>
			<?php endif; ?>
		</div>	
	<?php endif; ?>
		

	<?php
	if(is_user_logged_in()):
		comment_form(
			array(
				'title_reply'        => esc_html__( 'Leave a review', 'control-listings' ),
				'title_reply_before' => '<h3 id="reply-title" class="comment-reply-title">',
				'title_reply_after'  => '</h3>',
				'label_submit'         => esc_html__( 'Post Review', 'control-listings' ),
				'class_container' => 'comment-respond card',
				'submit_field'         => '<p class="form-submit mb-0">%1$s %2$s</p>',
			)
		);	
	else:
		echo '<div class="alert alert-warning" role="alert">';
		/* translators: %s: Post title. */
		$modal_title = sprintf(esc_attr__('Review on %s', 'control-listings'), esc_attr(get_the_title()));
		/* translators: %s: Login link. */
		printf(esc_html__('Please %s to add/edit your review.', 'control-listings'), esc_url(control_listings_login_link($modal_title)));	
		echo '</div>';
	endif;
	?>

</div><!-- #comments -->
