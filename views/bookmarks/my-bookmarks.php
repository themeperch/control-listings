<?php
/**
 * Lists a users bookmarks.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div id="control-listings-bookmarks">
	<table class="table ctrl-listings-bookmarks">
		<thead>
			<tr>
				<th><?php _e( 'Bookmark', 'control-listings' ); ?></th>
				<th><?php _e( 'Notes', 'control-listings' ); ?></th>
				<th><?php _e( 'Actions', 'control-listings' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ( $bookmarks as $bookmark ) : ?>
				<tr>
					<td>
						<a href="<?php the_permalink( $bookmark->post_id ); ?>">
							<?php the_post_thumbnail('thumbnail'); ?>
							<?php echo get_the_title( $bookmark->post_id ); ?>
						</a>						
					</td>
					<td>
						<?php echo wpautop( wp_kses_post( $bookmark->bookmark_note ) ); ?>
					</td>
					<td>
						<ul class="ctrl-listings-bookmark-actions list-unstyled">
							<?php
								$actions = apply_filters( 'control_listings_bookmark_actions', array(
									'delete' => array(
										'label' => __( 'Delete', 'control-listings' ),
										'url'   =>  wp_nonce_url( add_query_arg( 'remove_bookmark', $bookmark->post_id, admin_url( 'admin-ajax.php' ) ), 'remove_bookmark' )
									)
								), $bookmark );

								foreach ( $actions as $action => $value ) {
									echo '<li><a href="' . esc_url( $value['url'] ) . '" class="ctrl-listings-bookmark-action-' . $action . '">' . $value['label'] . '</a></li>';
								}
							?>
						</ul>
					</td>
				</tr>
			<?php endforeach; ?>
								
			<?php if(empty($bookmarks)): ?>
			<tr class="no-bookmarks-notice">
				<td colspan="3" ><?php _e( 'You currently have no bookmarks', 'control-listings' ); ?></td>
			</tr>
			<?php endif; ?>
		</tbody>
	</table>
	<?php control_listings_locate_template( 'bookmarks/pagination.php', array( 'max_num_pages' => $max_num_pages ) ); ?>
</div>
