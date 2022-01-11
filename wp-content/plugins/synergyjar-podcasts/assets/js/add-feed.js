
jQuery(function ($) {

	$('.record-button').on('click', function () {

		// Remove podcast list

		$('.podcast-content ul').addClass('podcasts-fadeout');
		$('.podcast-list').addClass('podcasts-fadeout');
		$('.load-more-container').addClass('podcasts-fadeout');

		$('.show-feed-info').addClass('podcasts-fadein');

	});

	$('#add-feed-edit').on('click', function () {
		$('.show-feed-info').removeClass('podcasts-fadein');
		$('.feed-set').addClass('podcasts-fadein');
		//$('.show-feed').addClass('hidden');
	});

	


});



