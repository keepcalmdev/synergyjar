<?php

/**
 *
 * Capture XMLHTTPRequest and upload audio file.
 *
 */

require_once $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php';

if (!function_exists('wp_handle_upload')) {
	require_once ABSPATH . 'wp-admin/includes/file.php';
}

if (!class_exists('getID3')) {
	require ABSPATH . 'wp-includes/ID3/getid3.php';
}

if (!function_exists('wp_add_id3_tag_data')) {
	require_once ABSPATH . '/wp-admin/includes/media.php';
}


if (isset($_FILES['audio_file']) && wp_verify_nonce($_POST['add-episode-nonce'], 'add-episode')) {

	$_FILES['audio_file']['name'] = sanitize_text_field($_POST['audio_file_name']);

	$upload_dir = wp_upload_dir();

	$upload_overrides = array(
		'test_form' => false,
		'name'      => sanitize_file_name($_POST['audio_file_name']),
	);

	$audiofile = wp_handle_upload($_FILES['audio_file'], $upload_overrides);

	if ($audiofile && !isset($audiofile['error'])) {
		echo esc_html($audiofile['url']);
	} else {

		echo esc_html($audiofile['error']);
	}

	exit();
}

if (isset($_FILES['audio_file']) && wp_verify_nonce($_POST['add-episode-nonce'], 'add-episode')) {

	$_FILES['audio_file']['name'] = sanitize_text_field($_POST['audio_file_name']);

	$upload_dir = wp_upload_dir();

	$upload_overrides = array(
		'test_form' => false,
		'name'      => sanitize_file_name($_POST['audio_file_name']),
	);

	$audiofile = wp_handle_upload($_FILES['audio_file'], $upload_overrides);

	if ($audiofile && !isset($audiofile['error'])) {
		echo esc_html($audiofile['url']);
	} else {

		echo esc_html($audiofile['error']);
	}

	exit();
}
