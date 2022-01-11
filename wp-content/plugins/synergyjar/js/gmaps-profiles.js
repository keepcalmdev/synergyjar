document.getElementById("gmap-prev").addEventListener("mousedown", prevPage);
document.getElementById("gmap-next").addEventListener("mousedown", nextPage);

let pageNum = 1;
let perPage = 4;

let resultmap, geocoder, cccc;
let longlat = [];
let marker = "";
let markers = [];
let map = "";
let markerCluster = "";
let request = "";
let labels = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
let locations = [];

// Create a request variable and assign a new XMLHttpRequest object to it.
request = new XMLHttpRequest();
// Open a new connection, using the GET request on the URL endpoint
// Open a new connection, using the GET request on the URL endpoint
request.open(
	"GET",
	"/wp-json/buddypress/v1/members?per_page=" + perPage + "&page=1",
	true
);
request.onload = function () {
	var data = JSON.parse(this.response);
	initMap(data);
	totalMembers();
};
// Send request
request.send();

function totalMembers() {
	// Create a request variable and assign a new XMLHttpRequest object to it.
	request = new XMLHttpRequest();
	// Open a new connection, using the GET request on the URL endpoint
	// Open a new connection, using the GET request on the URL endpoint
	request.open("GET", "/wp-json/buddypress/v1/members", true);
	request.onload = function () {
		var data = JSON.parse(this.response);
		//console.log(data);
	};
	// Send request
	request.send();
}

function initMap(data) {
	locations = data;
	map = new google.maps.Map(document.getElementById("map"), {
		zoom: 6,
	});

	// Create an array of alphabetical characters used to label the markers.

	geocoder = new google.maps.Geocoder();
	markerCluster = new MarkerClusterer(map, markers, {
		imagePath: "/wp-content/plugins/synergyjar/images/m",
	});
	// Add some markers to the map.
	// Note: The code uses the JavaScript Array.prototype.map() method to
	// create an array of markers based on a given "locations" array.
	// The map() method here has nothing to do with the Google Maps API.

	let rows = "";
	let activeInfoWindow = "";
	let infoWindow = new google.maps.InfoWindow();
	let bounds = new google.maps.LatLngBounds();

	let geoCodeObject = locations.map(function (location, i) {
		//let userAddress = "https://maps.googleapis.com/maps/api/geocode/json?address=";
		let userAddress;
		userAddress += location.xprofile.groups[1].fields[5].value.raw;
		userAddress += "+";
		userAddress += location.xprofile.groups[1].fields[6].value.raw;
		userAddress += "+";
		userAddress += location.xprofile.groups[1].fields[7].value.raw;
		userAddress += "+";
		userAddress += location.xprofile.groups[1].fields[8].value.raw;
		//userAddress += "&key=AIzaSyD2mreDB3R3-z6qShyNe-3u6Nsk2OfjENU";

		userAddress = userAddress.replace(/ /g, "+");

		geocoder.geocode({ address: userAddress }, function (results, status) {
			if (status === "OK") {
				if (results[0]) {
					let marker = new google.maps.Marker({
						map: map,
						position: results[0].geometry.location,
						label: labels[i++ % labels.length],
					});
					markers.push(marker);
					markerCluster.addMarker(marker);
					let windowContent = '<div class="marker-window">';
					windowContent +=
						'<div class="marker-name"><a href="' +
						location.link +
						'">' +
						location.name +
						"</a></div>";
					windowContent +=
						'<div class="marker-street">' +
						location.xprofile.groups[1].fields[5].value.raw +
						"</div>";
					windowContent +=
						'<div class="marker-city">' +
						location.xprofile.groups[1].fields[6].value.raw +
						", </div>";
					windowContent +=
						'<div class="marker-state">' +
						location.xprofile.groups[1].fields[7].value.raw +
						" </div>";
					windowContent +=
						'<div class="marker-zip">' +
						location.xprofile.groups[1].fields[8].value.raw +
						" </div>";
					windowContent += "</div>";

					marker.addListener("click", function () {
						if (activeInfoWindow) {
							activeInfoWindow.close();
						}
						infoWindow.setContent(windowContent);
						infoWindow.open(map, marker);
						activeInfoWindow = infoWindow;
					});

					//infoWindow.open(map, marker);
				} else {
					console.log("No results found");
				}
			} else {
				console.log("Geocoder failed due to: " + status);
				console.log(userAddress);
			}

			bounds.extend(results[0].geometry.location);
			map.fitBounds(bounds);
		});
		let itemNum = (pageNum - 1) * perPage + (i + 1);
		rows +=
			'<a href="#" id="result-row" name="' +
			location.id +
			'" class="result-row list-group-item row">' +
			'<div class="result-label">' +
			itemNum +
			". </div>" +
			'<div class="result-name"><h4>' +
			location.xprofile.groups[1].fields[1].value.raw +
			"</h4></div>" +
			'<div class="result-address">' +
			location.xprofile.groups[1].fields[5].value.raw +
			"</div>" +
			'<div class="result-city">' +
			location.xprofile.groups[1].fields[6].value.raw +
			", " +
			location.xprofile.groups[1].fields[7].value.raw +
			" " +
			location.xprofile.groups[1].fields[8].value.raw +
			"</div>" +
			'<div class="result-link">View Profile</div>' +
			"</a>";
	});

	let resultsDiv = document.getElementById("results");
	resultsDiv.innerHTML = rows;

	let listResults = locations.map(function (location, i) {
		//console.log(location);
	});
}

function handleLocationError(browserHasGeolocation, infoWindow, pos) {
	infoWindow.setPosition(pos);
	infoWindow.setContent(
		browserHasGeolocation
			? "Error: The Geolocation service failed."
			: "Error: Your browser doesn't support geolocation."
	);
	infoWindow.open(resultmap);
}

function prevPage() {
	if (pageNum != 0) {
		// Create a request variable and assign a new XMLHttpRequest object to it.
		pageNum = pageNum - 1;
		// Open a new connection, using the GET request on the URL endpoint
		// Open a new connection, using the GET request on the URL endpoint
		//console.log(pageNum);
		request.open(
			"GET",
			"/wp-json/buddypress/v1/members?per_page=" + perPage + "&page=" + pageNum,
			true
		);
		request.onload = function () {
			var data = JSON.parse(this.response);
			refreshMap(data);
		};
		// Send request
		request.send();
	}
}

function nextPage() {
	// Create a request variable and assign a new XMLHttpRequest object to it.
	pageNum = new Number(pageNum + 1);
	// Open a new connection, using the GET request on the URL endpoint
	// Open a new connection, using the GET request on the URL endpoint
	//console.log(pageNum);
	request.open(
		"GET",
		"/wp-json/buddypress/v1/members?per_page=" + perPage + "&page=" + pageNum,
		true
	);
	request.onload = function () {
		var data = JSON.parse(this.response);
		refreshMap(data);
	};
	// Send request
	request.send();
}

function setMapOnAll(val) {
	for (var i = 0; i < markers.length; i++) {
		markers[i].setMap(val);
	}
}

function refreshMap(data) {
	setMapOnAll(null);
	markerCluster.clearMarkers();

	locations = [];
	locations = data;

	// Create an array of alphabetical characters used to label the markers.
	geocoder = new google.maps.Geocoder();
	//markerCluster.setMap(null);

	// Add some markers to the map.
	// Note: The code uses the JavaScript Array.prototype.map() method to
	// create an array of markers based on a given "locations" array.
	// The map() method here has nothing to do with the Google Maps API.

	let rows = "";
	let activeInfoWindow = "";
	let infoWindow = new google.maps.InfoWindow();
	let bounds = new google.maps.LatLngBounds();

	let geoCodeObject = locations.map(function (location, i) {
		let userAddress =
			"https://maps.googleapis.com/maps/api/geocode/json?address=";
		userAddress += location.xprofile.groups[1].fields[5].value.raw;
		userAddress += "+";
		userAddress += location.xprofile.groups[1].fields[6].value.raw;
		userAddress += "+";
		userAddress += location.xprofile.groups[1].fields[7].value.raw;
		userAddress += "+";
		userAddress += location.xprofile.groups[1].fields[8].value.raw;
		userAddress += "&key=AIzaSyD2mreDB3R3-z6qShyNe-3u6Nsk2OfjENU";

		userAddress = userAddress.replace(/ /g, "+");

		geocoder.geocode({ address: userAddress }, function (results, status) {
			if (status === "OK") {
				if (results[0]) {
					let marker = new google.maps.Marker({
						map: map,
						position: results[0].geometry.location,
						label: labels[i++ % labels.length],
					});
					markers.push(marker);
					markerCluster.addMarker(marker);
					let windowContent = '<div class="marker-window">';
					windowContent +=
						'<div class="marker-name"><a href="' +
						location.link +
						'">' +
						location.name +
						"</a></div>";
					windowContent +=
						'<div class="marker-street">' +
						location.xprofile.groups[1].fields[5].value.raw +
						"</div>";
					windowContent +=
						'<div class="marker-city">' +
						location.xprofile.groups[1].fields[6].value.raw +
						", </div>";
					windowContent +=
						'<div class="marker-state">' +
						location.xprofile.groups[1].fields[7].value.raw +
						" </div>";
					windowContent +=
						'<div class="marker-zip">' +
						location.xprofile.groups[1].fields[8].value.raw +
						" </div>";
					windowContent += "</div>";
					marker.addListener("click", function () {
						if (activeInfoWindow) {
							activeInfoWindow.close();
						}
						infoWindow.setContent(windowContent);
						infoWindow.open(map, marker);
						activeInfoWindow = infoWindow;
					});
					//infoWindow.open(map, marker);
				} else {
					window.alert("No results found");
				}
			} else {
				window.alert("Geocoder failed due to: " + status);
			}

			bounds.extend(results[0].geometry.location);
			map.fitBounds(bounds);
		});
		let itemNum = (pageNum - 1) * perPage + (i + 1);
		rows +=
			'<a href="#" id="result-row" name="' +
			location.id +
			'" class="result-row list-group-item row">' +
			'<div class="result-label">' +
			itemNum +
			". </div>" +
			'<div class="result-name"><h2>' +
			location.xprofile.groups[1].fields[1].value.raw +
			"</h2></div>" +
			'<div class="result-address">' +
			location.xprofile.groups[1].fields[5].value.raw +
			"</div>" +
			'<div class="result-city">' +
			location.xprofile.groups[1].fields[6].value.raw +
			", " +
			location.xprofile.groups[1].fields[7].value.raw +
			" " +
			location.xprofile.groups[1].fields[8].value.raw +
			"</div>" +
			'<div class="result-link">View Profile</div>' +
			"</a>";
	});

	let resultsDiv = document.getElementById("results");
	resultsDiv.innerHTML = rows;

	let listResults = locations.map(function (location, i) {
		//console.log(location);
	});
}

function geoCodeAddress(locationss) {}
