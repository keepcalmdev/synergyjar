jQuery(function ($) {
	// Handler for .ready() called
	var header_toggled = false;
	var footer_toggled = false;

	if (document.querySelector(".user-top-menu-container")) {
		window.addEventListener("DOMContentLoaded", function (event) {
			"use strict";
			document
				.getElementById("user-top-menu-expander")
				.addEventListener("click", function () {
					let el = document.querySelectorAll(".user-top-menu-container");
					el[0].classList.toggle("show");
					el[0].classList.toggle("fadeInFast");
					jQuery('#header-menu-container').toggle('drop', { direction: 'up' });
					header_toggled = false;
				});
		});
	}

	$(".header-menu-toggle").click(function () {
		if (!header_toggled) {
			$('#header-menu-container').show('slide', {
				direction: 'up',
			});
			if ($(".user-top-menu-container").hasClass("show")) {
				let el = document.querySelectorAll(".user-top-menu-container");
				el[0].classList.toggle("show");
				el[0].classList.toggle("fadeInFast");
			}
			// $( '.container' ).animate({
			// 	top: "+=50",
			// }, 400, function(){

			// });
			//$('#header-menu-container').css('display','inline-block');
			header_toggled = true;
			//$('#header-menu-container').toggle();
		} else {
			//$('#header-menu-container').css('display','none');
			$("#header-menu-container").hide("drop", { direction: "up" }, 400);
			// $( '.container' ).animate({
			// 	top: 0,
			// }, 400, function(){

			// });
			header_toggled = false;
		}
	});
	$(".menu-item-694").click(function () {
		console.log('Here');
		if (!footer_toggled) {
			$(".mini-footer-menu li:nth-last-child(-n+7)").css("display", "inline");
			$(".menu-item-694").css("display", "none");

			footer_toggled = true;
			//$('#header-menu-container').toggle();
		} else {
			//$('#header-menu-container').css('display','none');
			//$( '.mini-footer-menu li:nth-last-child(-n+7)' ).hide( "drop", {direction: 'up'}, 400 );
			//footer_toggled = false;
		}
	});

	if (document.querySelector("#yz-whats-new-post-in")) {
		var shareGroups = new Array(41,24,33,26,39,22,18,21,35,27,20,34,42,25,32,23,36,37,28,38,19,29,31,30,43);
		for(let group of shareGroups){
			$('#whats-new-post-in-box .list div[data-value='+group+']').hide();
		}
		// window.addEventListener("DOMContentLoaded", function (event) {
		// 	"use strict";
		// 	document
		// 		.getElementById("user-top-menu-expander")
		// 		.addEventListener("click", function () {
		// 			let el = document.querySelectorAll(".user-top-menu-container");
		// 			el[0].classList.toggle("show");
		// 			el[0].classList.toggle("fadeInFast");
		// 			jQuery('#header-menu-container').toggle('drop', { direction: 'up' });
		// 			header_toggled = false;
		// 		});
		// });
	}
});
