
jQuery(function ($) {
	$('.record-button').on('click', function(){

		// Remove podcast list
		$('.podcast-content ul').addClass('podcasts-fadeout');
		

		// Load podcast add-feed template


		$.ajax({
			url: ajaxurl,
			type: 'POST',
			data: {
				'action':'sj_add_feed',
			},
			success: function( response ) {
				$('.podcast-content').html('');
				$('.podcast-content').prepend(response);
			},
			error: function(response) {
				console.log('error');
			}
		});
	});
});



