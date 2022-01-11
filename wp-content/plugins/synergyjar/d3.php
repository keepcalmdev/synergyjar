<?php

define( 'PLUGINPATH', plugin_dir_url( __FILE__ ) );

wp_register_script( 'd3-js', 'https://d3js.org/d3.v5.min.js', '', true, true );
wp_enqueue_script( 'd3-js', 'https://d3js.org/d3.v5.min.js', '', true, true );

wp_register_script( 'd3-topojson', 'https://d3js.org/topojson.v0.min.js', '', true, true );
wp_enqueue_script( 'd3-topojson', 'https://d3js.org/topojson.v0.min.js', '', true, true );

wp_register_style( 'd3-css', PLUGINPATH . 'css/d3map.css', '', true );
wp_enqueue_style( 'd3-css', PLUGINPATH . 'css/d3map.css', '', true );

wp_register_script( 'd3-map', PLUGINPATH . 'js/d3map.js', '', true, true );
wp_localize_script(
	'd3-map',
	'wpvars',
	array(
		'pluginpath' => esc_attr( PLUGINPATH ),
	)
);
wp_enqueue_script( 'd3-map', PLUGINPATH . 'js/d3map.js', '', true, true );

