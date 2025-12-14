( function( $ ) {
	'use strict';
   

	$( ".listing-range-bar" ).each(function(){		
		let rangeSliderBar = $(this),				
		rangeSliderInput = $(this).closest('.listing-range-slider').find('input'),
		rangeSliderMinTag = $(this).closest('.listing-range-slider').find('.min-value'),
		rangeSliderMinvalue = parseInt(rangeSliderMinTag.text()),
		rangeSliderMaxTag = $(this).closest('.listing-range-slider').find('.max-value'),
		rangeSliderMaxvalue = parseInt(rangeSliderMaxTag.text()),
		rangeSliderValue = [rangeSliderMinvalue, rangeSliderMaxvalue];
		
		$( rangeSliderBar ).slider({
			range: true,
			min: parseInt(rangeSliderMinTag.data('value')),
			max: parseInt(rangeSliderMaxTag.data('value')),
			values: rangeSliderValue,
			slide: function( event, ui ) {
					rangeSliderInput.val( ui.values[ 0 ] + "-" + ui.values[ 1 ] );
					rangeSliderMinTag.empty().text(ui.values[ 0 ]);
					rangeSliderMaxTag.empty().text(ui.values[ 1 ]);
			}
		});
		//rangeSliderInput.val( rangeSliderValue[0]+'-'+rangeSliderValue[1] );
	});

	$(document).on('change', '.listing-term', function(){
		let searchIDs = $(".listing-term:checkbox:checked").map(function(){
			return $(this).val();
		  }).get(); 
		$(this).closest('.checked-group').find('[type="hidden"]').val(searchIDs.join(','));  
	});
	
	// Advanced filter form search
	$(document).on('submit', '.listings-search-form', function(){
		
		$.post(CTRLListings.ajaxUrl, {
			'action' : 'ctrl_listing_search',
			'form_data' : $(this).serialize()
		}, function(response) {
			// Navigate to the Location.reload article by replacing this page
			window.location.replace(response.link);

		});
		return false;
	})

}( jQuery ) );
