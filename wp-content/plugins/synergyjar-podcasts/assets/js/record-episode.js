


if (document.querySelector('.web-audio-record-record')) {
	// set up basic variables for app

	const upload = document.querySelector('#upload-episode');
	const recordReturn = document.querySelector('#record-episode');
	const saveRecording = document.querySelector('#add-episode-submit');
	const saveUpload = document.querySelector('#upload-episode-submit');
	const soundClips = document.querySelector('.sound-clips');
	const canvas = document.querySelector('.visualizer');
	const mainSection = document.querySelector('.main-controls');
	const recordSection = document.querySelector('.record-episode-wrapper');
	const uploadSection = document.querySelector('.upload-episode-wrapper');
	const userID = document.querySelector('#user-id');
	const episodeNonce = document.querySelector('#add-episode-nonce').value;


	let audioCtx;
	const canvasCtx = canvas.getContext("2d");




	//main block for doing the audio recording
	jQuery(function ($) {

		if (document.getElementById('add-feed-episode')) {

			$('#add-feed-episode').on('click', function () {

				$('.show-feed-info').removeClass('podcasts-fadein');
				$('.feed-info').removeClass('podcasts-fadein');
				$('.feed-episode').addClass('podcasts-fadein');

				if (navigator.mediaDevices.getUserMedia) {
					console.log('getUserMedia supported.');

					const constraints = { audio: true };
					let chunks = [];
					let duration = 0;

					let onSuccess = function (stream) {
						var options = { mimeType: "audio/ogg; codecs=vorbis" };
						const mediaRecorder = new MediaRecorder(stream);						

						visualize(stream);

						upload.onclick = function () {
							recordSection.style = 'display: none;';
							uploadSection.style = 'display: block;';
							upload.style = 'display: none;';
							saveRecording.style = 'display: none;';
							recordReturn.style = 'display: block;';
							saveRecording.style = 'display: none;';
							saveUpload.style = 'display: block;';
						};

						recordReturn.onclick = function () {
							recordSection.style = 'display: block;';
							uploadSection.style = 'display: none;';
							upload.style = 'display: block;';
							recordReturn.style = 'display: none;';
							saveRecording.style = 'display: block;';
							saveUpload.style = 'display: none;';

						};

						saveUpload.onclick = function () {
							const feedAudio = document.getElementById('upload_audio_file');
							trackUpload(feedAudio.files[0]);
						};

						mediaRecorder.onstop = function (e) {
							console.log("data available after MediaRecorder.stop() called.");

							//const clipName = prompt('Enter a name for your sound clip?', 'My unnamed clip');

							const clipContainer = document.createElement('article');
							const clipLabel = document.createElement('p');
							const audio = document.createElement('audio');
							const deleteButton = document.createElement('button');

							clipContainer.classList.add('clip');
							audio.setAttribute('controls', '');
							deleteButton.textContent = 'Delete';
							deleteButton.className = 'delete';

							// if (clipName === null) {
							// 	clipLabel.textContent = 'My unnamed clip';
							// } else {
							// 	clipLabel.textContent = clipName;
							// }

							clipContainer.appendChild(audio);
							clipContainer.appendChild(clipLabel);
							clipContainer.appendChild(deleteButton);
							soundClips.appendChild(clipContainer);

							audio.controls = true;
							const blob = new Blob(chunks, { 'type': 'audio/mpeg-3; codecs=opus' });
							chunks = [];
							const audioURL = window.URL.createObjectURL(blob);
							audio.src = audioURL;

							trackUpload(blob, recordingDuration());

							deleteButton.onclick = function (e) {
								let evtTgt = e.target;
								evtTgt.parentNode.parentNode.removeChild(evtTgt.parentNode);
							};

							// clipLabel.onclick = function () {
							// 	const existingName = clipLabel.textContent;
							// 	const newClipName = prompt('Enter a new name for your sound clip?');
							// 	if (newClipName === null) {
							// 		clipLabel.textContent = existingName;
							// 	} else {
							// 		clipLabel.textContent = newClipName;
							// 	}
							// };
						};

						mediaRecorder.ondataavailable = function (e) {
							chunks.push(e.data);
						};
					};

					let onError = function (err) {
						console.log('The following error occured: ' + err);
					};

					navigator.mediaDevices.getUserMedia(constraints).then(onSuccess, onError);

				} else {
					console.log('getUserMedia not supported on your browser!');
				}

				function visualize (stream) {
					if (!audioCtx) {
						audioCtx = new AudioContext();
					}

					const source = audioCtx.createMediaStreamSource(stream);

					const analyser = audioCtx.createAnalyser();
					analyser.fftSize = 2048;
					const bufferLength = analyser.frequencyBinCount;
					const dataArray = new Uint8Array(bufferLength);

					source.connect(analyser);
					//analyser.connect(audioCtx.destination);

					draw();

					function draw () {
						const WIDTH = canvas.width;
						const HEIGHT = canvas.height;

						requestAnimationFrame(draw);

						analyser.getByteTimeDomainData(dataArray);

						canvasCtx.fillStyle = 'rgb(200, 200, 200)';
						canvasCtx.fillRect(0, 0, WIDTH, HEIGHT);

						canvasCtx.lineWidth = 2;
						canvasCtx.strokeStyle = 'rgb(0, 0, 0)';

						canvasCtx.beginPath();

						let sliceWidth = WIDTH * 1.0 / bufferLength;
						let x = 0;


						for (let i = 0; i < bufferLength; i++) {

							let v = dataArray[i] / 128.0;
							let y = v * HEIGHT / 2;

							if (i === 0) {
								canvasCtx.moveTo(x, y);
							} else {
								canvasCtx.lineTo(x, y);
							}

							x += sliceWidth;
						}

						canvasCtx.lineTo(canvas.width, canvas.height / 2);
						canvasCtx.stroke();

					}
				}

				function startTimer () {
					duration = new Date();
				}

				function recordingDuration () {
					endDuration = new Date();
					return Math.floor((endDuration.getTime() - duration.getTime()) / 1000);
				}

				window.onresize = function () {
					canvas.width = mainSection.offsetWidth;
				};

				window.onresize();

			});
		}

		function showUpload () {

		}


		function trackUpload (file, duration) {

			const reader = new FileReader();
			const xhr = new XMLHttpRequest();
			const fd = new FormData();
			this.xhr = xhr;


			xhr.onload = function () {
				if (this.status >= 200 && this.status < 400) {
					addEpisodeSet(this.response, file, duration);
				} else {
					// Response error
					console.log('error: ' + this.response);
				}
			};
			xhr.onerror = function () {
				// Connection error
				console.log('Connection error');
			};

			xhr.open("POST", '/wp-content/plugins/synergyjar-podcasts/includes/podcast-save-audio.php', true);
			xhr.overrideMimeType('text/plain; charset=x-user-defined-binary');

			fd.append('audio_file', file);
			const currentTime = new Date();
			const fileName = file['name'] ? userID.value + '_' + file['name'] : userID.value + '_' + Date.now() + '.mp3';

			fd.append('audio_file_name', fileName);
			fd.append('add-episode-nonce', episodeNonce);

			xhr.send(fd);
		}

		function addEpisodeSet (url, file, duration) {

			const episodeName = document.querySelector('#episode-name').value;
			const episodeDesc = document.querySelector('#episode-description').value;
			const feedSlug = document.querySelector('#feed-slug').value;
			const feedItunesImage = document.querySelector('#itunes_image').value;
			const feedAuthor = document.querySelector('#feed-author').value;

			jQuery.ajax({
				url: ajaxurl,
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
							'duration': duration,
							'set_size': 1,
							'size': file['size']
						},
					},
					'episode-nonce': episodeNonce
				},
				success: function (response) {
					console.log('Success');
				},
				error: function (response) {
					console.log('error:' + response);
				}
			});

		}
		
	});

}
