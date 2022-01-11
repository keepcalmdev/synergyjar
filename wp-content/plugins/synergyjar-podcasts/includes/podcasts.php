<?php
/**
 * 
 * 
 * 
 * 
 * */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

require 'controls/class_metaparts.php';

add_shortcode('synergyjar_podcasts', 'sj_podcast_list');

/**
 *
 * Function loads a list of podcasts and displays using imported template
 */
function sj_podcast_list() {
	// Query podcasts from PowerPress posts
	$get_meta_parts = new MetaParts();
	include 'templates/podcast-list.php';	
}

/**
 * 
 * 
 * Function controller for JS request to load more podcasts using load more button.
 */
function sj_podcast_1() {
	
	// Retrieve pagenation information
	$blog_posts_type = esc_html($_POST['blog_posts_type']);
	$page = esc_html($_POST['page']);
	$cat = esc_html($_POST['cat_id'] ? $_POST['cat_id'] : 39);
	$get_meta_parts = new MetaParts();
	if ($blog_posts_type == 1) {
		// Query post database for podcast category
		$temp = $wp_query;
		$wp_query = null;
		$wp_query = new WP_Query();
		$wp_query->query('posts_per_page=6' . '&paged=' . $page . '&category__in=' . $cat);
		// Loop through results and display items
		while ($wp_query->have_posts()) : $wp_query->the_post();
			$meta_parts = $get_meta_parts->get_channel_art(get_the_ID());
			$image_src = $meta_parts['itunes_image'] != null ? $meta_parts['itunes_image'] : $meta_parts['image'];
			include( 'templates/podcast.php' );

		endwhile; // end of loop

	}

	wp_reset_query();
	wp_die();
}

add_action('wp_ajax_nopriv_sj_podcast_1', 'sj_podcast_1');
add_action('wp_ajax_sj_podcast_1', 'sj_podcast_1');



?>