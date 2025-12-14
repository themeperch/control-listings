<?php
function control_listings_get_rating_fields(){
	return [
		[
			'name' => 'compass',
			'label' => 'Compass',
			'enable' => true
		],
		[
			'name' => 'libary',
			'label' => 'Libary',
			'enable' => true
		],
		[
			'name' => 'cost',
			'label' => 'Cost',
			'enable' => true
		],
		[
			'name' => 'teaching',
			'label' => 'Teaching',
			'enable' => true
		],
		[
			'name' => 'learning',
			'label' => 'Learning',
			'enable' => true
		]
	];
}

//Create the rating interface.
add_action( 'comment_form_logged_in_after', 'control_listings_comment_rating_field' );
add_action( 'comment_form_after_fields', 'control_listings_comment_rating_field' );
function control_listings_comment_rating_field () {
    if(get_post_type() != 'ctrl_listings') return;
	echo '<div class="row row-cols-1 row-cols-lg-3 gy-20">';
	foreach (control_listings_get_rating_fields() as $field) :
		if( !$field['enable']) continue;
		?>
		<div class="col">
			<label for="<?php echo esc_attr($field['name']) ?>"><?php echo esc_attr($field['label']) ?><span class="required">*</span></label>
			<fieldset class="comments-rating">
				<span class="rating-container">
					<?php for ( $i = 5; $i >= 1; $i-- ) : ?>
						<input type="radio" id="<?php echo esc_attr($field['name']) ?>-<?php echo esc_attr( $i ); ?>" name="<?php echo esc_attr($field['name']) ?>" value="<?php echo esc_attr( $i ); ?>" /><label for="<?php echo esc_attr($field['name']) ?>-<?php echo esc_attr( $i ); ?>"><?php echo esc_html( $i ); ?></label>
					<?php endfor; ?>
					<input type="radio" id="<?php echo esc_attr($field['name']) ?>-0" class="star-cb-clear" name="<?php echo esc_attr($field['name']) ?>" value="0" /><label for="<?php echo esc_attr($field['name']) ?>-0">0</label>
				</span>
			</fieldset>
		</div>	
		<?php
	endforeach;
	echo '</div>';
}

//Save the rating submitted by the user.
add_action( 'comment_post', 'control_listings_comment_save_rating' );
function control_listings_comment_save_rating( $comment_id ) {
	
	foreach (control_listings_get_rating_fields() as $field) :
		$name = $field['name'];
		if ( ( isset( $_POST[$name] ) ) && ( '' !== $_POST[$name] ) ){
			$rating = intval( $_POST[$name] );
			add_comment_meta( $comment_id, $name, $rating );
		}		
	endforeach;	
}

//Make the rating required.
add_filter( 'preprocess_comment', 'control_listings_comment_require_rating' );
function control_listings_comment_require_rating( $commentdata ) {
    if(get_post_type() != 'ctrl_listings') return $commentdata;
	foreach (control_listings_get_rating_fields() as $field) :
		if( !$field['enable']) continue;
		$name = $field['name'];
		if ( ! is_admin() && ( ! isset( $_POST[$name] ) || 0 === intval( $_POST[$name] ) ) )
		wp_die( __( 'Error: You did not add a rating. Hit the Back button on your Web browser and resubmit your review with a rating.', 'control-listings' ) );
	endforeach;	
	return $commentdata;
}

function control_listings_get_comment_rating($name="rating"){
	$stars = '';
	if ( $rating = get_comment_meta( get_comment_ID(), $name, true ) ) {
		$stars = '<div class="stars type-rating" data-type="'.$name.'" data-rating="'.$rating.'">';
		for ( $i = 1; $i <= $rating; $i++ ) {
			$stars .= '<span class="dashicons dashicons-star-filled"></span>';
		}
		for ( $i = $rating; $i < 5; $i++ ) {
			$stars .= '<span class="dashicons dashicons-star-empty"></span>';
		}
		$stars .= '</div>';
		
	} 

	return $stars;
}


//Get the average rating of a post.
function control_listings_get_average_ratings( $id ) {
	$comments = get_approved_comments( $id );

	if ( $comments ) {
		$i = 0;
		$total = 0;
		foreach( $comments as $comment ){
			$count = 0;
			$rate = 0;
			foreach (control_listings_get_rating_fields() as $field){
				if( !$field['enable']) continue;
				$name = $field['name'];
				$rate += (int) get_comment_meta( $comment->comment_ID, $name, true );
				$count++;
			}

			$rate = $rate / $count;
			if(empty($rate)) continue;
				
			
			if( isset( $rate ) && '' !== $rate ) {
				$i++;
				$total += $rate;
			}
		}

		if ( 0 === $i ) {
			return false;
		} else {
			return round( $total / $i, 1 );
		}
	} else {
		return false;
	}
}

//Get the average rating of a post by type.
function control_listings_get_ratings_by_type( $id ) {
	$comments = get_approved_comments( $id );
	$ratings = control_listings_get_rating_fields();
	if ( $comments ) {
		foreach ($ratings as $key => $field){
			if( !$field['enable']) continue;
			$name = $field['name'];
			$rate = 0;

			$i = 0;
			$total = 0;
			foreach( $comments as $comment ){
				
				$rate = (int) get_comment_meta( $comment->comment_ID, $name, true );
				if(empty($rate)) continue;
					
				
				if( isset( $rate ) && '' !== $rate ) {
					$i++;
					$total += $rate;
				}
			}

			if ( 0 === $i ) {
				$type_ratings = false;
			} else {
				$type_ratings =  round( $total / $i, 1 );
			}

			$ratings[$key]['ratings'] = $i;
			$ratings[$key]['total'] = $total;
			$ratings[$key]['average'] = $type_ratings;
				
			
		}

		return $ratings;
	} else {
		return false;
	}
}

//Get the average rating of a post.
function control_listings_get_average_ratings_html( $id, $show_total = true ) {
	$rating = control_listings_get_average_ratings($id);

	$total = control_listings_get_total_ratings($id);
	if(!$rating) return;
	

	$total = $show_total? ' <span class="total-ratings text-muted">('.$total.')</span>' : '';

	$stars = control_listings_get_star_ratings_html($rating, $total);
	

	return $stars;

}

function control_listings_get_star_ratings_html($rating, $total = ''){
	return '<div class="star-rating d-flex gap-1 align-items-center" title="'.$rating.' out of 5.0">	
		<div class="back-stars">
			<i class="dashicons dashicons-star-empty" aria-hidden="true"></i>
			<i class="dashicons dashicons-star-empty" aria-hidden="true"></i>
			<i class="dashicons dashicons-star-empty" aria-hidden="true"></i>
			<i class="dashicons dashicons-star-empty" aria-hidden="true"></i>
			<i class="dashicons dashicons-star-empty" aria-hidden="true"></i>
			<div class="front-stars" style="width: '.($rating*20).'%">
				<i class="dashicons dashicons-star-filled" aria-hidden="true"></i>
				<i class="dashicons dashicons-star-filled" aria-hidden="true"></i>
				<i class="dashicons dashicons-star-filled" aria-hidden="true"></i>
				<i class="dashicons dashicons-star-filled" aria-hidden="true"></i>
				<i class="dashicons dashicons-star-filled" aria-hidden="true"></i>
			</div>
		</div>'.$total.'
	</div>';
}

function control_listings_get_total_ratings($id){
	$comments = get_approved_comments( $id );
	return count($comments);
}

function control_listings_edit_review_link(){
	$comment = get_comment();
	$edit_review = __( 'Edit', 'control-listings' );
	if ( current_user_can( 'edit_comment', $comment->comment_ID ) ) {
		edit_comment_link( $edit_review, ' <span class="edit-link">', '</span>' );
	}elseif(get_current_user_id() == $comment->user_id){
		printf('<span class="edit-link"><a href="#" class="comment-edit-link">%s</a></span>', $edit_review);
	}

	
}

add_action( 'wp_ajax_ctrl_listing_edit_review', 'control_listing_edit_review');
function control_listing_edit_review(){
	$params = array();
	parse_str($_POST['formdata'], $params);
	$commentarr = [
		'comment_ID' => $params['comment_post_ID'],
		'comment_content' => $params['comment'],
		'comment_date' => current_time( 'mysql' ),
		'comment_date_gmt' => current_time( 'mysql', true ),
	];
	$update = wp_update_comment( $commentarr );
	if($update && !is_wp_error($update)){
		foreach (control_listings_get_rating_fields() as $field){
			$name = $field['name'];
			if( !$field['enable'] || empty($params[$name])) continue;
			update_comment_meta($params['comment_post_ID'], $name, $params[$name]);			
		}
		wp_die(true);
	}
	wp_die(false);
}
