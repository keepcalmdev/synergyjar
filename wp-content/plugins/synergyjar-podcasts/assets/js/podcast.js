/*************************************************************************************************************/

/************************************* AJAX BLOG PODCASTS LOADING *****************************************************/

if (document.getElementById("load-more-podcasts-1")) {

	window.addEventListener("DOMContentLoaded", function (event) {
		"use strict";

		document.querySelectorAll('body.page-template-podcast-1 #object-nav ul li, body.page-template-podcast-2 #object-nav ul li, body.home.blog #object-nav ul li').forEach(function (el) {
			el.addEventListener('click', function () {

				var button = document.querySelector('body.page-template-podcast-1 #object-nav ul li.current, body.page-template-podcast-2 #object-nav ul li.current, body.home.blog #object-nav ul li.current');
				var more = document.getElementById('load-more-podcasts-1');
				button.classList.remove('current');
				this.classList.add('current', 'dd-loading');

				var blog_posts_type = this.getAttribute('data-posts-type');
				var page = this.getAttribute('data-tab-page');
				var nonce = this.getAttribute('data-nonce');

				// Update attributes of load more button
				more.setAttribute("data-posts-type", blog_posts_type);
				more.setAttribute("data-tab-page", page);

				var request = new XMLHttpRequest();
				request.open('POST', ajaxurl, true);
				request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
				request.onload = function () {
					if (this.status >= 200 && this.status < 400) {

						var button = document.getElementById('load-more-podcasts-1');
						var el = document.querySelector('ul.podcast-1');
						el.innerHTML = '';
						var content = this.response;
						var content = content.replace(/class="podcast-wrapper/gi, 'class="podcast-wrapper fadein');
						var count = content.match(/class="podcast-wrapper fadein/g).length;

						if (count < 6) {
							more.classList.add('no-more');
						}

						el.insertAdjacentHTML('afterbegin', content);
						button.classList.remove('dd-loading');

						// Masonry load
						imagesLoaded(document.querySelector('.podcast-1'), function (instance) {
							var elem = document.querySelector('.podcast-1');
							var msnry = new Masonry(elem, {
								// options
								itemSelector: 'li.box-podcast-entry',
								isAnimated: true,
								animationOptions: {
									duration: 1,
									easing: 'linear',
									queue: false
								}
							});
						});



					} else {
						// Response error
						console.log('Response error');
					}
				};
				request.onerror = function () {
					// Connection error
					console.log('Connection error');
				};
				request.send('action=sj_podcast_1&blog_posts_type=' + blog_posts_type + '&page=' + page + '&nonce=' + nonce + '');

			});
		});


		document.getElementById('load-more-podcasts-1').addEventListener('click', function () {

			this.classList.add('dd-loading');
			var blog_posts_type = this.getAttribute('data-posts-type');
			var page = this.getAttribute('data-tab-page');
			var nonce = this.getAttribute('data-nonce');
			var category = this.getAttribute('data-category') ? this.getAttribute('data-category') : 39;
			var page_next = Number(page) + 1;
			
			var button = document.getElementById('load-more-podcasts-1');
			button.setAttribute('data-tab-page', page_next);

			var request = new XMLHttpRequest();
			request.open('POST', ajaxurl, true);
			request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
			request.onload = function () {
				if (this.status >= 200 && this.status < 400) {

					var button = document.getElementById('load-more-podcasts-1');
					var el = document.querySelector('ul.podcast-1');
					var content = this.response;
					var content = content.replace(/class="podcast-wrapper/gi, 'class="podcast-wrapper fadein');
					var count = content.match(/class="podcast-wrapper fadein/g).length;

					if (count < 6) {
						button.classList.add('no-more');
					}

					el.insertAdjacentHTML('beforeend', content);

					
					// Masonry load
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

				} else {
					// Response error
					console.log('error');
				}
			};
			request.onerror = function () {
				// Connection error
				console.log('Connection error');
			};
			request.send('action=sj_podcast_1&blog_posts_type=' + blog_posts_type + '&page=' + page_next + '&nonce=' + nonce + '&cat_id=' + category);


		});

	});

}

