<?php
/**
 * Form for adding and removing a bookmark.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $wp;

$bookmarked_class = $is_bookmarked ? 'has-bookmark' : '';
$bookmarked_text = $is_bookmarked ? esc_attr__( 'Update Bookmark', 'control-listings' ) : esc_attr__( 'Add Bookmark', 'control-listings' );
?>
<form method="post" action="<?php echo defined( 'DOING_AJAX' ) ? '' : esc_url( remove_query_arg( array( 'page', 'paged' ), add_query_arg( $wp->query_string, '', home_url( $wp->request ) ) ) ); ?>" class="control-listings-form control-listings-bookmarks-form <?php echo esc_attr($bookmarked_class) ?>">
	<div class="remove-bookmark-wrapper"><a class="remove-bookmark" href="<?php echo esc_url( wp_nonce_url( add_query_arg( 'remove_bookmark', absint( $post->ID ), get_permalink() ), 'remove_bookmark' ) ); ?>"><?php esc_attr_e( 'Remove Bookmark', 'control-listings' ); ?></a></div>
	
	<div class="bookmark-details">
		<p><label for="bookmark_notes"><?php esc_attr_e( 'Notes:', 'control-listings' ); ?></label><textarea name="bookmark_notes" id="bookmark_notes" cols="25" rows="3"><?php echo esc_textarea( $note ); ?></textarea></p>
		<p>
			<?php wp_nonce_field( 'update_bookmark' ); ?>
			<input type="hidden" name="bookmark_post_id" value="<?php echo absint( $post->ID ); ?>" />
			<input type="submit" class="submit-bookmark-button" name="submit_bookmark" value="<?php echo esc_attr($bookmarked_text) ?>" />
			<span class="spinner" style="background-image: url(<?php echo esc_url( includes_url( 'images/spinner.gif' ) ); ?>);"></span>
		</p>
	</div>
</form>