if(document.getElementById('add-feed-submit')){
	document.getElementById('add-feed-submit').addEventListener('click', e => {
		const feedArt = document.getElementById('itunes_image_file');	
		fileUpload(feedArt.files[0], feedArt.files[0]);
	});	
}

function fileUpload (img, file) {

	noticeModal(null, true, 'Uploading channel art.');

	const feedNonce = document.querySelector('#add-feed-nonce').value;

	const reader = new FileReader();
	const xhr = new XMLHttpRequest();
	const fd = new FormData();
	this.xhr = xhr;

	xhr.onload = function () {
		if (this.status >= 200 && this.status < 400) {
			addFeedSet(this.response);
		} else {
			// Response error
			console.log('error: ' + this.response);
		}
	};
	xhr.onerror = function () {
		// Connection error
		console.log('Connection error');
	};

	xhr.open("POST", '/wp-content/plugins/synergyjar-podcasts/includes/podcast-save-image.php', true);
	xhr.overrideMimeType('text/plain; charset=x-user-defined-binary');
	fd.append('itunes_image_file', file);
	fd.append('add-feed-nonce', feedNonce);
	xhr.send(fd);
}

function addFeedSet(url) {

	const feedName = document.querySelector('#feed-name').value;
	const feedDesc = document.querySelector('#feed-description').value;
	const feedNonce = document.querySelector('#add-feed-nonce').value;

	jQuery.ajax({
		url: ajaxurl,
		type: 'POST',
		data: {
			'action': 'sj_add_feed_set',
			'feed-name': feedName,
			'feed-description': feedDesc,
			'feed-nonce': feedNonce,
			'feed-art-path': url
		},
		success: function (response) {
			console.log(response);
			updateInformation();
			noticeModal(false);
			jQuery('.show-feed-info').addClass('podcasts-fadein');
			jQuery('.feed-set').removeClass('podcasts-fadein');
			//jQuery('.podcast-content').html('');
			//jQuery('.podcast-content').prepend(response);
		},
		error: function (response) {
			console.log('error:' + response);
		}
	});

}

function noticeModal (notice = true, spinner = false, text) {

	let modalDisplay = false;


	if (document.getElementById('podcast-modal-button')) {
		document.getElementById('podcast-modal-button').addEventListener('click', e => {
			if (modalDisplay == true) {
				document.getElementById('podcast-modal-wrapper').style.display = 'none';
				modalDisplay = false;
			}
		});
	}

	if (notice) {
		
		if (modalDisplay == false) {
			document.getElementById('podcast-modal-wrapper').style.display = 'block';
			modalDisplay = true;
		} else {
			document.getElementById('podcast-modal-wrapper').style.display = 'none';
			modalDisplay = false;
		}

		if (text) {
			document.querySelector('#podcast-modal-content').innerHTML = '';
			document.querySelector('#podcast-modal-content').insertAdjacentHTML('afterbegin', text);
			document.getElementById('podcast-modal-button').style.display = 'block';

		} else if (text == null) {
			//document.querySelector('.loader').style.display = 'block';
		}

		if (spinner) {
			document.querySelector('.loader').style.display = 'block';
			document.querySelector('#podcast-modal-content').style.top = '80%';
		} else {
			document.querySelector('.loader').style.display = 'none';
			document.querySelector('#podcast-modal-content').style.top = '50%';
		}
	}else{
		document.getElementById('podcast-modal-wrapper').style.display = 'none';
		modalDisplay = false;
	}

}

function updateInformation(){

	jQuery.ajax({
		url: ajaxurl,
		type: 'POST',
		dataType: 'JSON',
		data: {
			'action': 'sj_update_feed_information'
		},
		success: function (response) {
			jQuery('.feed-show').addClass('podcasts-fadein');
			document.querySelector('#feed-show-itunes-image').setAttribute('src', response['itunes_image']);
			document.querySelector('#feed-show-title').innerHTML = response['title'];
			document.querySelector('#feed-show-description').innerHTML = response['description'];

		},
		error: function (response) {
			console.log('error:' + response);
		}
	});
}
