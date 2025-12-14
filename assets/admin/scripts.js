( function( $ ) {
	'use strict';

    $(document).on('click', '.sticky-posts', function(){
		
		var data = {
			'action': 'ctrl_listing_sticky_posts',
			'post_id': $(this).data('id'),			
			'nonce': $(this).data('nonce')
		};
		$.post(CTRLListingsAdmin.ajaxUrl, data, function(response) {
			if(response.success){
				$('.control-listings-bookmarks-form').addClass('has-bookmark');
				location.reload();
			}
		});
		return false;
	});


    $(document).on('click', '[data-id="controlListingsAjax"]', function(){
        // We can also pass the url value separately from ajaxurl for front end AJAX implementations
        $.post(controlListingsAdmin.ajax, {
            'action': 'controlListingsAjax',
            'data' : $(this).data(),
            'nonce' : controlListingsAdmin.nonce
        }, function(response) {
            console.log('Got this from the server: ' + response);
        });
        
        return false;
    });

    
    document.addEventListener('DOMContentLoaded', function() {
        // Select the button with the class .controlListingsReset
        const resetButton = document.querySelector('.controlListingsReset');
        
        // Check if the button exists
        if (resetButton) {
            // Add a click event listener to the button
            resetButton.addEventListener('click', function() {
                // Display a confirmation dialog when the button is clicked
                const userConfirmed = confirm('Are you sure you want to reset?');
                
                // Check the user's response
                if (userConfirmed) {
                    resetButton.disabled = true;
                    // User clicked "OK"
                    $.post(controlListingsAdmin.ajax, {
                        'action': 'controlListingsAjax',
                        'data' : {
                            'action': 'resetSettings',
                            'option_name': resetButton.getAttribute('data-option_name')
                        },
                        'nonce' : controlListingsAdmin.nonce
                    }, function(response) {
                        if (response.error === 0) {
                            // Redirect to the URL specified in redirect_to
                            window.location.href = response.redirect_to;
                        }
                        resetButton.disabled = false;
                    });
                }
            });
        } 
    });
})(jQuery, window, document);