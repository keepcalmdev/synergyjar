var width = 1095;
var height = 500;

var projection = d3.geoAlbersUsa()
.translate([width / 2, height / 2]) // translate to center of screen
.scale([1000]);
//var projection = d3.geoEqualEarth().rotate([90, 0, 0]);
var path = d3.geoPath().projection(projection);

const zoom = d3.zoom().scaleExtent([1, 8]).on("zoom", zoomed);

var svg = d3.select("#d3map").append("svg").attr("class", "d3map");
var usstates = wpvars.pluginpath + "js/us-states.json";
var cities = wpvars.pluginpath + "js/population.json";

//svg.call(zoom);

Promise.all([d3.json(usstates), d3.json(cities)]).then(function (data) {
	//d3.json(url, function(data){
		
	var world = data[0];
	var places = data[1]; 

	svg
		.append("path")
		.attr("d", path(world))
		.attr("fill", "lightgray")
		.attr("stroke", "white");

	svg
		.selectAll("circle")
		.data(places.features)
		.enter()
		.append("circle")
		.attr("r", function (d) {
			return 2;
		})
		.attr("cx", function (d) {
			return projection([d.geometry.x, d.geometry.y])[0];
		})
		.attr("cy", function (d) {
			return projection([d.geometry.x, d.geometry.y])[1];
		})
		.attr("fill", "darkgreen")
		.attr("opacity", 0.2);

	// window.setTimeout(function () {
	// 	svg
	// 		.selectAll("circle")
	// 		.transition()
	// 		.duration(5000)
	// 		.attr("r", function (d) {
	// 			return d.properties.pop_min / 1000000;
	// 		});
	// }, 5000);
});

function zoomed() {
	svg
		.selectAll("path") // To prevent stroke width from scaling
		.attr("transform", d3.event.transform);
	svg
		.selectAll("circle") // To prevent stroke width from scaling
		.attr("transform", d3.event.transform);
}
