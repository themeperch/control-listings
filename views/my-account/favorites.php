<h2><?php esc_html_e( 'Favorite Listings', 'control-listings' ); ?></h2>



<?php
if ( empty( $favorites ) ) {
	echo '<div colspan="4" class="mbfp-notice">' . __( 'You haven\'t added any posts yet', 'control-listings' ) . '</div>';
	return;
}
?>

<table class="ctrl-listings-favorite-posts">
	<colgroup>
		<col>
		<col>
		<col>
		<col class="mbfp-col-delete">
	</colgroup>
	<thead>
		<tr>
			<th><?php esc_html_e( 'Title', 'control-listings' ) ?></th>
			<th><?php esc_html_e( 'Date', 'control-listings' ) ?></th>
			<th><?php esc_html_e( 'Status', 'control-listings' ) ?></th>
			<th></th>
		</tr>
	</thead>

	<tbody>
		<?php foreach( $favorites as $post_id ) : ?>

			<tr data-id="<?php echo esc_attr( $post_id ) ?>">
				<td>
					<a href="<?php echo get_the_permalink( $post_id ) ?>">
						<?php echo esc_html( get_the_title( $post_id ) ) ?>
					</a>
				</td>
				<td>
					<?php echo esc_html( get_the_date( '', $post_id ) ) ?>
				</td>
				<td>
					<?php echo esc_html( get_post_status( $post_id ) ) ?>
				</td>
				<td>
					<button class="btn-close ctrl-listing-favorite-table-delete" data-id="<?php echo esc_attr( $post_id ) ?>" data-action="delete"></button>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>

</table>
