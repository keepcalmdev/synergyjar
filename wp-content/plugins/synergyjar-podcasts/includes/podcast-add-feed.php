<?php

/**
 * Summary: Add podcast channel for new users before creating episodes. Add feed, taxonomy, import, and more
 * Description:
 *
 * @since 1.0
 * @package WordPress
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * AJAX Hook for add podcast channel/feed button
 */

function sj_add_feed_set()
{

	global $wp_rewrite;

	$options = array();

	if (isset($_POST['feed-nonce']) && wp_verify_nonce($_POST['feed-nonce'], 'add-feed')) {

		$settings = get_option('powerpress_general');
		$user_id = get_current_user_id();
		$key = isset($_POST['feed-name']) ? sanitize_title(wp_unslash($_POST['feed-name'])) : '';
		$options['value'] = isset($_POST['feed-name']) ? convert_chars(sanitize_text_field(wp_unslash($_POST['feed-name']))) : '';
		$options['title'] = isset($_POST['feed-name']) ? convert_chars(sanitize_text_field(wp_unslash($_POST['feed-name']))) : '';
		$options['description'] = isset($_POST['feed-description']) ? sanitize_textarea_field(wp_unslash($_POST['feed-description'])) : '';
		$options['itunes_image'] = isset($_POST['feed-art-path']) ? $_POST['feed-art-path'] : $settings['itunes_image'];
		$options['channelart'] = isset($_POST['feed-art-path']) ? $_POST['feed-art-path'] : '';
		$options['userid'] = $user_id;

		//echo $options['channelart'] . "\n";

		if (isset($settings['custom_feeds'][$key]) && empty($_POST['overwrite'])) {
			echo 'Feed already exists.';
			sj_add_custom_feed_option($user_id, $options);
			wp_die();

			//powerpress_page_message_add_error( sprintf(__('Feed slug "%s" already exists.'), $key) );
		} else if ($key == '') {
			echo 'Feed slug not valid.';
			wp_die();
			//powerpress_page_message_add_error(sprintf(__('Feed slug "%s" is not valid.', 'powerpress'), esc_html($_POST['feed_slug'])));
		} else if (in_array($key, $wp_rewrite->feeds) && !isset($settings['custom_feeds'][$key])) {  // If it is a system feed or feed created by something else.
			echo 'Feed slug is not available.';
			wp_die();
			//powerpress_page_message_add_error(sprintf(__('Feed slug "%s" is not available.', 'powerpress'), esc_html($key)));
		} else {
			$settings['custom_feeds'][$key] = $options['value'];
			powerpress_save_settings($settings, 'powerpress_general');
			sj_add_custom_feed_option($user_id, $options);
			add_feed($key, 'powerpress_do_podcast_feed'); // Before we flush the rewrite rules we need to add the new custom feed...
			echo 'Success';
			$wp_rewrite->flush_rules();
		};

		wp_die();
	}
};

/**
 * 
 * Create post for powerpress to insert podcast meta data. Do action to init powerpress functions.
 */
function sj_add_episode_set()
{

	global $wp_rewrite;

	if (isset($_POST['episode-nonce']) && wp_verify_nonce($_POST['episode-nonce'], 'add-episode')) {

		if (0 == $_POST['postID'] && $_COOKIE['synergyjarpodcastid'] == null) {
			
			$settings = get_option('powerpress_general');

			$user_id = get_current_user_id();
			//$key = isset($_POST['feed-name']) ? sanitize_title(wp_unslash($_POST['feed-name'])) : '';
			//$options['value'] = isset($_POST['feed-name']) ? convert_chars(sanitize_text_field(wp_unslash($_POST['feed-name']))) : '';
			//$post['post_title'] = isset($_POST['episode-name']) ? convert_chars(sanitize_text_field(wp_unslash($_POST['episode-name']))) : '';
			//$post['post_content'] = isset($_POST['episode-description']) ? sanitize_textarea_field(wp_unslash($_POST['episode-description'])) : '';
			//$options['itunes_image'] = isset($_POST['feed-art-path']) ? $_POST['feed-art-path'] : '';
			//$options['channelart'] = isset($_POST['feed-art-path']) ? $_POST['feed-art-path'] : '';
			//$options['userid'] = $user_id;

			$post = array(
				'post_title'   => isset($_POST['episode-name']) ? convert_chars(sanitize_text_field(wp_unslash($_POST['episode-name']))) : '',
				'post_content' => isset($_POST['episode-description']) ? sanitize_textarea_field(wp_unslash($_POST['episode-description'])) : '',
				'post_status'  => 'publish',
				'post_author'  => get_current_user_id(),
				'post_category' => array(39),
			);

			$post_id = wp_insert_post($post);

			// When Powerpress form array is set a edit post hook will handle the podcast submission. powerpressadmin.php function powerpress_edit_post.
			do_action('edit_post', $post_id, get_post($post_id));

			echo $post_id;

		} else {

			$settings = get_option('powerpress_general');

			$user_id = get_current_user_id();

			$post_id = $_COOKIE['synergyjarpodcastid'];
			//$key = isset($_POST['feed-name']) ? sanitize_title(wp_unslash($_POST['feed-name'])) : '';
			//$options['value'] = isset($_POST['feed-name']) ? convert_chars(sanitize_text_field(wp_unslash($_POST['feed-name']))) : '';
			//$post['post_title'] = isset($_POST['episode-name']) ? convert_chars(sanitize_text_field(wp_unslash($_POST['episode-name']))) : '';
			//$post['post_content'] = isset($_POST['episode-description']) ? sanitize_textarea_field(wp_unslash($_POST['episode-description'])) : '';
			//$options['itunes_image'] = isset($_POST['feed-art-path']) ? $_POST['feed-art-path'] : '';
			//$options['channelart'] = isset($_POST['feed-art-path']) ? $_POST['feed-art-path'] : '';
			//$options['userid'] = $user_id;

			$post = array(
				'ID'   => $post_id,
				'post_title'   => isset($_POST['episode-name']) ? convert_chars(sanitize_text_field(wp_unslash($_POST['episode-name']))) : '',
				'post_content' => isset($_POST['episode-description']) ? sanitize_textarea_field(wp_unslash($_POST['episode-description'])) : '',
				'post_status'  => 'publish',
				'post_author'  => get_current_user_id(),
				'post_category' => array(39),
			);

			$post_id = wp_update_post($post);

			do_action('edit_post', $post_id, get_post($post_id));

			echo $post_id;

			
		};

		if( true == $_POST['final'] ){
			
			setcookie("synergyjarpodcastid", null, time() - 3600, '/');
			
		};

		wp_die();
	}
};

/**
 * 
 * Create post for powerpress to insert podcast meta data.
 */


function sj_add_track_set()
{

	global $wp_rewrite;

	//setcookie('synergyjarpodcastid', null, time() - 3600, '/');

	//echo isset($_POST['episode-nonce']);
	

	if (isset($_POST['episode-nonce']) && wp_verify_nonce($_POST['episode-nonce'], 'add-episode')) {

		if (0 == $_POST['postID'] && ($_COOKIE['synergyjarpodcastid'] == null || $_COOKIE['synergyjarpodcastid'] == 0)) {
			
			$title = $_POST['episode-name'] != '' ? convert_chars( sanitize_text_field( wp_unslash( $_POST['episode-name'] ) ) ) : get_current_user_id();
			$description = $_POST['episode-description'] != '' ? sanitize_textarea_field( wp_unslash( $_POST['episode-description'] ) ) : get_current_user_id();

			$post = array(
				'post_title'    => $title,
				'post_content'  => $description,
				'post_status'   => 'draft',
				'post_author'   => get_current_user_id(),
				'post_category' => array(39),
			);

			$post_id = wp_insert_post($post);

			$tracks_array = array(
				'postID' => $post_id,
				'tracks' => array(
					$_POST['trackNumber'] => $_POST['trackUrl'],
				),
			);

			update_post_meta($post_id, 'tracks', $tracks_array);

			setcookie("synergyjarpodcastid", $post_id, strtotime('+30 days'), '/');

			//$add_track_array['postID'] = $post_id;

			//$add_track_array['tracks'][$_POST['trackNumber']] = $_POST['trackUrl'];

			$meta_data = get_post_meta($post_id, 'tracks');

			echo json_encode($meta_data[0]);

			wp_die();

		} else {

			// Get post ID from POST or get ID from cookie
			$post_id = $_COOKIE['synergyjarpodcastid'];

			$tracks_array = get_post_meta($post_id, 'tracks');

			$tracks_array[0]['tracks'][$_POST['trackNumber']] = $_POST['trackUrl'];

			// Add meta to post
			update_post_meta($post_id, 'tracks', $tracks_array[0]);

			//$add_track_array['tracks'][ $_POST['trackNumber'] ] = $_POST[ 'trackUrl' ];

			//$add_track_array['meta_data'] = get_post_meta($post_id);

			//echo wp_json_encode($post_id);

			$meta_data = get_post_meta($post_id, 'tracks');

			echo json_encode($meta_data[0]);

			// Remove server cookie for testing

			wp_die();
		}
	}
};

/**
 * 
 * 
 */

 function sj_update_track_set(){
	 

	if ($_COOKIE['synergyjarpodcastid'] != null && wp_verify_nonce($_POST['add-episode-nonce'], 'add-episode')) {

		// Get post ID from POST or get ID from cookie
		$post_id = $_COOKIE['synergyjarpodcastid'];

		$tracks_array = get_post_meta($post_id, 'tracks');

		$tracks_array[0]['tracks'][$_POST['trackNumber']] = $_POST['trackUrl'];

		// Add meta to post
		update_post_meta($post_id, 'tracks', $tracks_array[0]);

		//$add_track_array['tracks'][ $_POST['trackNumber'] ] = $_POST[ 'trackUrl' ];

		//$add_track_array['meta_data'] = get_post_meta($post_id);

		//echo wp_json_encode($post_id);

		$meta_data = get_post_meta($post_id, 'tracks');

		echo json_encode($meta_data[0]);

		// Remove server cookie for testing

		wp_die();
	}
 }

/**
 * Add custom feed option to database
 *
 * @param type $key feed slug.
 * @param type $desc feed description.
 *
 */
function sj_add_custom_feed_option($user_id, $feed)
{
	$option = get_option('powerpress_feed_' . $user_id);

	if (isset($feed) && null == $option) {
		add_option('powerpress_feed_' . $user_id);
		powerpress_save_settings($feed, 'powerpress_feed' . ($user_id ? '_' . $user_id : ''));
	} else {
		$settings = get_option('powerpress_feed_' . $user_id);
		foreach ($settings as $key => $value) {
			if ($settings[$key] !== $feed[$key] && '' !== $feed[$key]) {
				$settings[$key] = $feed[$key];
			}
		}
		powerpress_save_settings($settings, 'powerpress_feed' . ($user_id ? '_' . $user_id : ''));
	};
}

/**
 * 
 * Get new settings information and refresh channel information
 */
function sj_update_feed_information()
{
	$user_id = get_current_user_id();
	$settings = get_option('powerpress_feed_' . $user_id);
	echo json_encode($settings);
	wp_die();
}

/**
 * Save powerpress settings.
 */
function powerpress_save_settings_sj($settings_new = false, $field = 'powerpress_general')
{
	if ($field == 'powerpress_taxonomy_podcasting' || $field == 'powerpress_itunes_featured') { // No merging settings for these fields...
		update_option($field, $settings_new);
		return;
	}
}

/**
 * 
 * Load previous clips from post meta
 */
function sj_load_previous_clips()
{
	//echo json_encode($_COOKIE);
	if (isset($_POST['episode-nonce']) && wp_verify_nonce($_POST['episode-nonce'], 'add-episode')) {
		if ($_COOKIE['synergyjarpodcastid'] != null) {
			//setcookie("synergyjarpodcastid", null, time() - 3600, '/');
			$post_id = $_COOKIE['synergyjarpodcastid'];
			$meta_data = get_post_meta($post_id, 'tracks');
			echo json_encode($meta_data[0]);
		} else {
			echo 'No previous tracks found.';
		}

		wp_die();
	};
}

/**
 * 
 * Load previous clips from post meta
 */
function sj_concat_tracks()
{
	if (isset($_POST['episode-nonce']) && wp_verify_nonce($_POST['episode-nonce'], 'add-episode')) {

		if ($_COOKIE['synergyjarpodcastid'] != null) {
			
			$post_id = $_COOKIE['synergyjarpodcastid'];

			$tracks_array = get_post_meta($post_id, 'tracks');

			$user_id = get_current_user_id();

			$upload_dir = wp_upload_dir();

			$file_name = $user_id . '_' . time() .'.mp3';

			$output_name = $upload_dir['path'] . '/' . $file_name;

			$tracks_string = implode( "|", $tracks_array[0]['tracks'] );

			//echo $concat_paths[0];
			$output = shell_exec('ffmpeg -protocol_whitelist concat,file,http,https,tcp,tls -i "concat:' . $tracks_string . '" -c copy ' . $output_name . ' 2>&1');

			if( isset( $output_name ) ) {

				echo $upload_dir['url'] . '/' . $file_name;				

			}
	
		}

		wp_die();
	};
}

/**
 * 
 * Save track sequence to post on drag and drop
 */
function sj_update_tracks(){

	if ($_COOKIE['synergyjarpodcastid'] != null && wp_verify_nonce($_POST['episode-nonce'], 'add-episode')) {

		// Get post ID from POST or get ID from cookie
		$post_id = $_COOKIE['synergyjarpodcastid'];

		$tracks_array = $_POST[ 'tracks' ];

		//echo json_encode($tracks_array);

		// Add meta to post
		update_post_meta($post_id, 'tracks', $tracks_array);

		//$add_track_array['tracks'][ $_POST['trackNumber'] ] = $_POST[ 'trackUrl' ];

		//$add_track_array['meta_data'] = get_post_meta($post_id);

		//echo wp_json_encode($post_id);

		$meta_data = get_post_meta($post_id, 'tracks');

		echo json_encode($meta_data[0]);

		// Remove server cookie for testing

		wp_die();
	}
}

/**
 * Load add feed form after selecting Record
 */
add_action('wp_ajax_nopriv_sj_load_previous_clips', 'sj_load_previous_clips', 10, 1);
add_action('wp_ajax_sj_load_previous_clips', 'sj_load_previous_clips', 10, 1);

/**
 * Load add feed form after selecting Record
 */
add_action('wp_ajax_nopriv_sj_add_feed_form', 'sj_add_feed_form', 10, 1);
add_action('wp_ajax_sj_add_feed_form', 'sj_add_feed_form', 10, 1);

/**
 * Submit podcast feed to powerpress settings
 */
add_action('wp_ajax_nopriv_sj_add_feed_set', 'sj_add_feed_set', 10, 1);
add_action('wp_ajax_sj_add_feed_set', 'sj_add_feed_set', 10, 1);

/**
 * Submit channel image
 */
add_action('wp_ajax_nopriv_sj_add_feed_image', 'sj_add_feed_image', 10, 1);
add_action('wp_ajax_sj_add_feed_image', 'sj_add_feed_image', 10, 1);

/**
 * Update channel information
 */
add_action('wp_ajax_nopriv_sj_update_feed_information', 'sj_update_feed_information', 10, 1);
add_action('wp_ajax_sj_update_feed_information', 'sj_update_feed_information', 10, 1);

/**
 * Submit Episode information
 */
add_action('wp_ajax_nopriv_sj_add_episode_set', 'sj_add_episode_set', 10, 1);
add_action('wp_ajax_sj_add_episode_set', 'sj_add_episode_set', 10, 1);

/**
 * Submit Track information
 */
add_action('wp_ajax_nopriv_sj_add_track_set', 'sj_add_track_set', 10, 1);
add_action('wp_ajax_sj_add_track_set', 'sj_add_track_set', 10, 1);

/**
 * Update Track after editing with Audiomass
 */
add_action('wp_ajax_nopriv_sj_update_track_set', 'sj_update_track_set', 10, 1);
add_action('wp_ajax_sj_update_track_set', 'sj_update_track_set', 10, 1);

/**
 * Combine all track into a new MP3 file.
 */
add_action('wp_ajax_nopriv_sj_concat_tracks', 'sj_concat_tracks', 10, 1);
add_action('wp_ajax_sj_concat_tracks', 'sj_concat_tracks', 10, 1);

/**
 * Save track sequence to post on drag and drop.
 */
add_action('wp_ajax_nopriv_sj_update_tracks', 'sj_update_tracks', 10, 1);
add_action('wp_ajax_sj_update_tracks', 'sj_update_tracks', 10, 1);
