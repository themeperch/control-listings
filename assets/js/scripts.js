( function( $ ) {
	'use strict';
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"], [data-title="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

	
	if($('#listingAdvancedSearch').length){
		let listingAdvancedSearch = document.getElementById('listingAdvancedSearch');
		listingAdvancedSearch.addEventListener('shown.bs.offcanvas', function () {
			let selector = document.getElementById("listingSearchInput");
			selector.focus();
			selector.setSelectionRange(selector.value.length, selector.value.length);
		});
	}

	
	

	const listingShareItems = document.querySelectorAll('.listing_social_share');
	for (let i = 0; i < listingShareItems.length; i += 1) {
		listingShareItems[i].addEventListener('click', function share(e) {
			return JSShare.go(this);
		});
	}

	$(document).on('click', '.ctrl-listing-share', function(){
		var data = {
			'action': 'ctrl_listing_share_post',
			'id': $(this).data('id')
		};
		let modal = $('#listingSocialShare');
		$.post(CTRLListings.ajaxUrl, data, function(response) {
			modal.find('.modal-title .post-title').empty().html(response.title);	
			for (let i = 0; i < listingShareItems.length; i += 1) {
				listingShareItems[i].setAttribute('data-title', response.title);
				listingShareItems[i].setAttribute('data-url', response.url);
			}		
		});
	})
	


	
	$(document).on('click', '.ctrl-listing-login-link', function(){
		let modalLink = $('[href="#controlListingsModal"]');
		let modal = $('#controlListingsModal');
		let title = $(this).data('title');
		modal.find('.modal-title').empty().html(title);
		return false;
	});


    $(document).on('click', '.ctrl-listing-bookmark-btn', function(){
        var data = {
			'action': 'ctrl_listing_bookmarks_form',
			'id': $(this).data('id')
		};

		let modalLink = $('[href="#controlListingsModal"]');
		let modal = $('#controlListingsModal');

		$.post(CTRLListings.ajaxUrl, data, function(response) {
			modal.find('.modal-title').empty().html(response.title);
			if(response.content != ''){
				modal.find('.modal-body').empty().html(response.content);
			}			
			modalLink.trigger('click');
		});
        return false;
    });

	$(document).on('submit', '.control-listings-bookmarks-form', function(){		
		var data = {
			'action': 'ctrl_listing_bookmarks_submit',
			'bookmark_post_id': $(this).find('[name="bookmark_post_id"]').val(),
			'submit_bookmark' : $(this).find('[type="submit"]').val(),
			'bookmark_notes' : $(this).find('[name="bookmark_notes"]').val(),
			'_wpnonce': $(this).find('[name="_wpnonce"]').val(),
		};
		$.post(CTRLListings.ajaxUrl, data, function(response) {
			if(response.success){
				$('.control-listings-bookmarks-form').addClass('has-bookmark');
				location.reload();
			}
		});
		return false;
	});

	$(document).on('click', '.remove-bookmark, .ctrl-listings-bookmark-action-delete', function(){
		this.data = new FormData();
		this.data.append( 'action', 'ctrl_listing_bookmarks_remove' );
		fetch( $(this).attr('href'), {
			method: "POST",
			credentials: 'same-origin',
			body: this.data,
		}).then((data) => {
			location.reload();
		  });
		return false;
	});


	// Edit review
	$(document).on('click', '.review-body .comment-edit-link', function(){
		$('#respond').addClass('edit-review');		
		let reviewText = $(this).closest('.review-body').find('.listing-review-text').text();;
		let reviewRatings = $(this).closest('.review-body').find('.type-rating');
		reviewRatings.each(function(){
			let name = $(this).data('type');
			let value = $(this).data('rating');
			$('.edit-review [name="'+name+'"][value="'+value+'"]').attr('checked', true);
		});
		$('.edit-review #reply-title').text(CTRLListings.titleUpdateReview);
		$('.edit-review #comment').val(reviewText);
		$('.edit-review #submit').val(CTRLListings.btnUpdateReview).addClass('btn-update-review');
		$('.edit-review #comment_post_ID').val($(this).closest('.review-body').data('id'));
		
		// scroll down
		document.getElementById('respond').scrollIntoView({
			behavior: 'smooth'
		});
		return false;
	});

	// Save edited review
	$(document).on('click', '.edit-review .btn-update-review', function(){
		let data = {
			'action': 'ctrl_listing_edit_review',
			'formdata': $(this).closest('form').serialize()
		}
		$.post(CTRLListings.ajaxUrl, data, function(response) {
			if(response){
				$('#respond').removeClass('edit-review');
				$('#respond form').trigger('reset');
				location.reload();
			}			
		});
		return false;
	});



}( jQuery ) );
