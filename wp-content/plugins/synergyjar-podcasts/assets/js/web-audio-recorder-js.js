jQuery(function ($) {

	let userID = '';
	let episodeNonce = '';
	const webRecord = document.querySelector('.web-audio-record-record');
	const webStop = document.querySelector('.web-audio-record-stop');
	const soundClips = document.querySelector('.sound-clips');

	let trackNumber = 0, postID = 0, todaysDate, msDate, newDate, episodeURL, episodeTracks;

	if (document.querySelector('.web-audio-record-record')) {

		if (document.getElementById('add-episode-submit')) {

			document.getElementById('add-episode-submit').addEventListener('click', e => {

				if (validateEpisodeFields()) {
					composeEpisode(episodeTracks);
				};

			});
		};

		if (document.getElementById('refresh-button')) {

			document.getElementById('refresh-button').addEventListener('click', e => {

				document.getElementById('refresh-tracks').style.display = 'none';

				document.querySelector('.sound-clips').innerHTML = '';

				loadPreviousTracks();

			});
		};


		userID = document.querySelector('#user-id');
		episodeNonce = document.querySelector('#add-episode-nonce').value;

		loadPreviousTracks();

		document.querySelector('.web-audio-record-record').addEventListener('click', e => {

			e.preventDefault();

			webRecord.style.background = "red";
			webStop.disabled = false;
			webRecord.disabled = true;

			navigator.mediaDevices.getUserMedia({ audio: true })
				.then(function (stream) {

					const audioContext = new AudioContext;

					var source = audioContext.createMediaStreamSource(stream);

					recorder = new WebAudioRecorder(source, {
						workerDir: plugin_data.PLUGINPATH_PODCAST + '/modules/web-audio-recorder-js/web-audio-recorder-js/lib/'    // must end with slash.
					});

					recorder.setEncoding('mp3');
					recorder.startRecording();

				});


		});

		document.querySelector('.web-audio-record-stop').addEventListener('click', e => {

			e.preventDefault();

			webRecord.style.background = "";
			webRecord.style.color = "";
			webStop.disabled = true;
			webRecord.disabled = false;

			recorder.finishRecording();

			recorder.onComplete = function (rec, blob) {
				//const clipName = prompt('Enter a name for your sound clip?', 'My unnamed clip');

				const clipContainer = document.createElement('article');
				const clipControls = document.createElement('div');
				const clipLabel = document.createElement('span');
				const audio = document.createElement('audio');
				const deleteButton = document.createElement('div');
				const editButton = document.createElement('div');
				const dragButton = document.createElement('div');
				const playButton = document.createElement('div');

				clipContainer.classList.add('clip');
				clipContainer.dataset.index = trackNumber;
				clipControls.classList.add('clip-controls');
				clipContainer.id = 'clip-container-' + trackNumber;
				clipContainer.setAttribute('draggable', true);
				clipContainer.ondrop = () => drop_handler(event);
				clipContainer.ondragover = () => dragover_handler(event);
				clipContainer.ondragstart = () => dragstart_handler(event);
				//clipContainer.ondragleave = () => dragleave_handler();
				//clipContainer.setAttribute('ondragover', function (){dragover_handler()});
				audio.classList.add('clip-' + trackNumber);
				//audio.setAttribute('controls', '');
				clipLabel.textContent = 'Clip ' + trackNumber;
				dragButton.insertAdjacentHTML('beforeend', '<i class="fas fa-bars"></i>');
				editButton.insertAdjacentHTML('beforeend', '<i class="far fa-edit"></i>');
				deleteButton.insertAdjacentHTML('beforeend', '<i class="far fa-trash-alt"></i>');
				playButton.insertAdjacentHTML('beforeend', '<i class="fas fa-play"></i>');
				dragButton.className = 'drag';
				editButton.className = 'edit';
				deleteButton.className = 'delete';
				playButton.className = 'play';
				clipLabel.className = 'label';
				playButton.setAttribute('data-audio', 'clip-' + trackNumber);

				// if (clipName === null) {
				// 	clipLabel.textContent = 'My unnamed clip';
				// } else {
				// 	clipLabel.textContent = clipName;
				// }

				//var myAudio = document.querySelector('my-audio');
				//var myControl = document.querySelector('.play');

				function switchState (dataClip) {
					//console.log(dataClip);
					if (audio.paused == true) {
						audio.play();
						//myControl.innerHTML = "pause";
					} else {
						audio.pause();
						//myControl.innerHTML = "play";
					}
				}

				playButton.addEventListener('click', function (e) {
					let dataClip = playButton.dataset.audio;
					switchState(dataClip);
				}, false);

				soundClips.appendChild(clipContainer);
				clipContainer.appendChild(clipControls);
				clipControls.appendChild(dragButton);
				clipControls.appendChild(audio);
				clipControls.appendChild(clipLabel);
				clipControls.appendChild(playButton);
				clipControls.appendChild(editButton);
				clipControls.appendChild(deleteButton);

				audio.controls = true;
				//const blob = new Blob(chunks, { 'type': 'audio/mpeg-3; codecs=opus' });
				//chunks = [];
				//const audioURL = window.URL.createObjectURL(blob);


				// use Blob
				const audioURL = window.URL.createObjectURL(blob);
				//audio.src = audioURL;

				deleteButton.onclick = function (e) {
					let evtTgt = e.target;
					//console.log(episodeTracks['tracks']);
					let articleIndex = evtTgt.parentNode.parentNode.parentNode.dataset.index;

					evtTgt.parentNode.parentNode.parentNode.parentNode.removeChild(evtTgt.parentNode.parentNode.parentNode);
					let episodeTracksArray = episodeTracks['tracks'];
					episodeTracksArray.splice(articleIndex, 1);

					updateEpisodeTracks();


				};

				trackUpload(blob);

				function trackUpload (file, duration = null) {

					const reader = new FileReader();
					const xhr = new XMLHttpRequest();
					const fd = new FormData();
					this.xhr = xhr;


					xhr.onload = function () {
						if (this.status >= 200 && this.status < 400) {

							// Track is created and a temp file created. Audio file is created and saved. Now we need to save tracks meta data in DB for later use. Initial track creates post on powerpress meta data.
							saveTrack(this.response);

							audio.src = this.response;

							//addEpisodeSet(this.response, file, duration);
						} else {
							// Response error
							console.log('error: ' + this.response);
						}
					};
					xhr.onerror = function () {
						// Connection error
						console.log('Connection error');
					};

					xhr.open("POST", plugin_data.PLUGINPATH_PODCAST + '/includes/podcast-save-audio.php', true);
					xhr.overrideMimeType('text/plain; charset=x-user-defined-binary');

					fd.append('audio_file', file);
					const currentTime = new Date();
					const fileName = file['name'] ? userID.value + '_' + file['name'] : userID.value + '_' + Date.now() + '.mp3';

					fd.append('audio_file_name', fileName);
					fd.append('add-episode-nonce', episodeNonce);

					xhr.send(fd);
				}

				//audio.src = trackURL;
				//}





				// Drag and Drop Clips

				// window.addEventListener('DOMContentLoaded', () => {
				// 	// Get the element by id
				// 	const element = document.getElementById('clip-container-' + trackNumber);
				// 	// Add the ondragstart event listener
				// 	element.addEventListener("dragstart", dragstart_handler);
				// });
			};
		});



	}

	function dragstart_handler (ev) {
		// Add the target element's id to the data transfer object
		ev.dataTransfer.setData("text/plain", ev.target.id);
		ev.dataTransfer.dropEffect = "move";
	}

	function dragover_handler (ev) {
		ev.preventDefault();
		// Copy data to duplicate
		//showDropPosition(ev.target.id);
		// Create empty droppable element
		//const data = ev.dataTransfer.getData("text/plain");
		let clipContainer = ev.target.closest('.clip');
		//console.log(ev.dataTransfer.getData("text/plain"));
		// if(clipContainer.id != data){
		clipContainer.style.backgroundColor = "#ddd";
		// }

		ev.dataTransfer.dropEffect = "move";
	}
	function dragenter_handler (ev) {
		ev.preventDefault();
		//showDropPosition(ev.target.dataset.index);
		ev.dataTransfer.dropEffect = "move";
	}
	function dragleave_handler (ev) {
		ev.preventDefault();
		let clipContainer = ev.target.closest('.clip');
		//console.log(ev.dataTransfer.getData("text/plain"));
		// if(clipContainer.id != data){
		clipContainer.style.backgroundColor = "";
		ev.dataTransfer.dropEffect = "move";
	}
	function drop_handler (ev) {
		ev.preventDefault();
		// Get the id of the target and add the moved element to the target's DOM
		const data = ev.dataTransfer.getData("text/plain");
		const htmlElement = document.getElementById(data);
		const targetClip = ev.target.closest('.clip');
		targetClip.style.backgroundColor = "";
		htmlElement.style.backgroundColor = "";
		targetClip.parentNode.insertBefore(htmlElement, targetClip);
		updateEpisodeTracks();


	}

	function composeEpisode (tracks) {
		
		noticeModal(true, true, 'Composing podcast sequence.');
		
		jQuery.ajax({
			url: plugin_data.ajaxurl,
			type: 'POST',
			data: {
				'action': 'sj_concat_tracks',
				'episode-nonce': episodeNonce
			},
			success: function (response) {

				console.log(response);

				addEpisodeSet(response, null, null, true);

			},
			error: function (response) {
				console.log('error: ' + response);
			}
		});
	}

	let checkFields = false;

	function validateEpisodeFields () {

		if (document.getElementById('episode-name').value == '' && checkFields == false) {
			noticeModal(true, false, '<p>Please enter a name for your episode.</p>');
			checkFields = false;
		} else if (document.getElementById('episode-name').value != '') {
			checkFields = true;
		}
		// checkFields = false
		if (document.getElementById('episode-description').value == '' && checkFields == true) {
			noticeModal(true, false, '<p>Please enter a description for your episode.</p>');
			checkFields = false;
		} else if (document.getElementById('episode-description').value != '') {
			checkFields = true;
		}

		return checkFields;
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

	// Re-orders the episode array into the current sequence
	function updateEpisodeTracks () {

		let episodeTracksPrevious = [...episodeTracks['tracks']];

		console.log(episodeTracksPrevious);

		let clipArray = document.querySelectorAll('.clip audio');

		clipArray.forEach(function (item, key) {
			let audioURL = item.src;
			episodeTracks['tracks'][key] = audioURL;

		});
		episodeTracksPrevious = '';
		//console.log(episodeTracks['tracks']);

		jQuery.ajax({
			url: plugin_data.ajaxurl,
			type: 'POST',
			dataType: 'json',
			data: {
				'action': 'sj_update_tracks',
				'tracks': episodeTracks['tracks'],
				'postID': postID,
				'episode-nonce': episodeNonce
			},
			success: function (response) {
				//postID = this.response['postID'];
				console.log(response);
			},
			error: function (response) {
				console.log('error: \n' + response['responseText']);
			}
		});
	}

	// On drag over duplicate clip content to new element
	function duplicateClip (id) {
		if (id !== '') {
			console.log(id);
			const htmlElement = document.getElementById(id);
			var tempDiv = document.createElement('div');
			tempDiv.style.backgroundColor = 'blue';
			tempDiv.style.height = '5px';
			tempDiv.style.marginTop = '5px';
			htmlElement.insertAdjacentElement('beforebegin', tempDiv);
		}

	}
	// Highlight where element will land
	function showDropPosition (id) {


	}



	function addEpisodeSet (url, file, duration, final = false) {

		const episodeName = document.querySelector('#episode-name').value;
		const episodeDesc = document.querySelector('#episode-description').value;
		const feedSlug = document.querySelector('#feed-slug').value;
		const feedItunesImage = document.querySelector('#itunes_image').value;
		const feedAuthor = document.querySelector('#feed-author').value;

		noticeModal(true, true,'Saving podcast.');

		jQuery.ajax({
			url: plugin_data.ajaxurl,
			type: 'POST',
			data: {
				'action': 'sj_add_episode_set',
				'episode-name': episodeName,
				'episode-description': episodeDesc,
				'Powerpress': {
					[feedSlug]: {
						'podcast': 1,
						'url': url,
						'hosting': 0,
						'episode_title': episodeName,
						'episode_no': 00,
						'summary': episodeDesc,
						'author': feedAuthor,
						'itunes_image': feedItunesImage,
						'image': feedItunesImage,
						'new_podcast': 1,
						'set_duration': 1,
						'duration': '',
						'set_size': 1,
						'size': ''
					},
				},
				'episode-nonce': episodeNonce,
				'final': final
			},
			success: function (response) {
				noticeModal(true, false, 'Podcast saved. Episode has been posted. Reloading podcasts...');
				location.reload();
				console.log(response);
			},
			error: function (response) {
				console.log('error:' + response);
			}
		});

	}

	function saveTrack (url) {

		const episodeName = document.querySelector('#episode-name').value;
		const episodeDesc = document.querySelector('#episode-description').value;
		const feedSlug = document.querySelector('#feed-slug').value;

		if (postID === 0) {
			todaysDate = new Date();
			msDate = todaysDate.setDate(todaysDate.getDate() + 30);
			newDate = new Date(msDate);
		}

		jQuery.ajax({
			url: plugin_data.ajaxurl,
			type: 'POST',
			dataType: 'json',
			data: {
				'action': 'sj_add_track_set',
				'episode-name': episodeName,
				'episode-description': episodeDesc,
				'episode-nonce': episodeNonce,
				'trackUrl': url,
				'trackNumber': trackNumber,
				'postID': postID,
			},
			success: function (response) {
				//postID = this.response['postID'];
				console.log(response);

				//console.log(response[0]['postID']);
				trackNumber = trackNumber + 1;

				// Save current recording to array
				episodeTracks = response;

				//return url;


				if (postID == 0) {
					// Save new draft post ID
					postID = response['postID'];
				}

			},
			error: function (response) {
				console.log('error: \n' + response['responseText']);
			}
		});

	};

	function loadPreviousTracks () {

		const episodeName = document.querySelector('#episode-name').value;
		const episodeDesc = document.querySelector('#episode-description').value;
		const feedSlug = document.querySelector('#feed-slug').value;

		jQuery.ajax({
			url: plugin_data.ajaxurl,
			type: 'POST',
			dataType: 'json',
			data: {
				'action': 'sj_load_previous_clips',
				'episode-nonce': episodeNonce
			},
			success: function (response) {
				if (response != null) {
					trackNumber = response['tracks'].length;
					episodeTracks = response;
					response['tracks'].forEach((item, index) => buildClip(item, index));
				}
			},
			error: function (response) {
				//console.log('response['responseText']');
			}
		});
	};

	function buildClip (clip, index) {

		const clipContainer = document.createElement('article');
		const clipControls = document.createElement('div');
		const clipLabel = document.createElement('span');
		const audio = document.createElement('audio');
		const deleteButton = document.createElement('div');
		const editButton = document.createElement('div');
		const dragButton = document.createElement('div');
		const playButton = document.createElement('div');

		clipContainer.classList.add('clip');
		clipContainer.dataset.index = index;

		clipControls.classList.add('clip-controls');
		clipContainer.id = 'clip-container-' + index;
		clipContainer.setAttribute('draggable', true);
		clipContainer.ondrop = () => drop_handler(event);
		clipContainer.ondragover = () => dragover_handler(event);
		clipContainer.ondragstart = () => dragstart_handler(event);
		clipContainer.ondragenter = () => dragenter_handler(event);
		clipContainer.ondragleave = () => dragleave_handler(event);
		//clipContainer.setAttribute('ondragover', function (){dragover_handler()});
		audio.classList.add('clip-' + index);
		//audio.setAttribute('controls', '');
		clipLabel.textContent = 'Clip ' + index;
		dragButton.insertAdjacentHTML('beforeend', '<i class="fas fa-bars"></i>');
		editButton.insertAdjacentHTML('beforeend', '<i class="far fa-edit"></i>');
		deleteButton.insertAdjacentHTML('beforeend', '<i class="far fa-trash-alt"></i>');
		playButton.insertAdjacentHTML('beforeend', '<i class="fas fa-play"></i>');
		dragButton.className = 'drag';
		editButton.className = 'edit';
		deleteButton.className = 'delete';
		playButton.className = 'play';
		clipLabel.className = 'label';
		playButton.setAttribute('data-audio', 'clip-' + index);

		// if (clipName === null) {
		// 	clipLabel.textContent = 'My unnamed clip';
		// } else {
		// 	clipLabel.textContent = clipName;
		// }

		//var myAudio = document.querySelector('my-audio');
		//var myControl = document.querySelector('.play');

		function switchState (dataClip) {
			//console.log(dataClip);
			if (audio.paused == true) {
				audio.play();
				//myControl.innerHTML = "pause";
			} else {
				audio.pause();
				//myControl.innerHTML = "play";
			}
		}





		playButton.addEventListener('click', function (e) {
			let dataClip = playButton.dataset.audio;
			switchState(dataClip);
		}, false);

		soundClips.appendChild(clipContainer);
		clipContainer.appendChild(clipControls);
		clipControls.appendChild(dragButton);
		clipControls.appendChild(audio);
		clipControls.appendChild(clipLabel);
		clipControls.appendChild(playButton);
		clipControls.appendChild(editButton);
		clipControls.appendChild(deleteButton);

		audio.controls = true;

		audio.src = clip;

		editButton.onclick = function (e) {
			document.getElementById('refresh-tracks').style.display = 'block';
			const clipPath = clip;
			window.open('/wp-content/plugins/synergyjar-podcasts/modules/audio-mass/src/?clippath=' + encodeURIComponent(clipPath) + '&tracknumber=' + index + '&nonce=' + episodeNonce);
		};

		deleteButton.onclick = function (e) {
			let evtTgt = e.target;
			//console.log(episodeTracks['tracks']);
			let articleIndex = evtTgt.parentNode.parentNode.parentNode.dataset.index;

			evtTgt.parentNode.parentNode.parentNode.parentNode.removeChild(evtTgt.parentNode.parentNode.parentNode);
			let episodeTracksArray = episodeTracks['tracks'];
			episodeTracksArray.splice(articleIndex, 1);

			updateEpisodeTracks();


		};
	}

});


