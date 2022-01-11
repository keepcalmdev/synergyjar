jQuery(function ($) {
	$('.podcast-filters-list').on('click', function (el) {

		// Remove podcast list
		//$('.podcast-content ul').addClass('podcasts-fadeout');

		var id = $(el.target).attr('id');
		// Load podcast add-feed template

		//this.classList.add('dd-loading');
		var blog_posts_type = this.getAttribute('data-posts-type');
		var page = this.getAttribute('data-tab-page');
		var nonce = this.getAttribute('data-nonce');
		var category = this.getAttribute('data-category') ? this.getAttribute('data-category') : 39;
		var page_next = Number(page) + 1;

		var button = document.getElementById('load-more-podcasts-1');
		button.setAttribute('data-tab-page', page_next);

		$.ajax({
			url: ajaxurl,
			type: 'POST',
			data: {
				'action': 'sj_podcast_1',
				'cat_id': id,
				'blog_posts_type': 1
			},
			success: function (response) {

				//$('.podcast-content').html('');
				//$('.podcast-content').prepend(response);

				var button = document.getElementById('load-more-podcasts-1');
				var el = document.querySelector('ul.podcast-1');
				el.innerHTML = '';
				var content = response;
				var content = content.replace(/class="podcast-wrapper/gi, 'class="podcast-wrapper fadein');
				var count = content.match(/class="podcast-wrapper fadein/g).length;

				if (count < 6) {
					button.classList.add('no-more');
				}

				el.insertAdjacentHTML('afterbegin', content);
				button.setAttribute('data-category', id);
				button.classList.remove('dd-loading');

				//Masonry load
				// imagesLoaded(document.querySelector('.podcast-1'), function (instance) {
				// 	var elem = document.querySelector('.podcast-1');
				// 	var msnry = new Masonry(elem, {
				// 		// options
				// 		itemSelector: 'li.box-podcast-entry',
				// 		isAnimated: true,
				// 		animationOptions: {
				// 			duration: 1,
				// 			easing: 'linear',
				// 			queue: false
				// 		}
				// 	});
				// });
				button.classList.remove('dd-loading');
			},
			error: function (response) {
				console.log('error');
			}
		});
	});
});