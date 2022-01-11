<?php



if (function_exists('powerpress_content')) {

	require 'includes/podcasts.php';
	require 'includes/podcast-add-feed.php';
	require 'includes/podcast-filters.php';


	define('PLUGINPATH_PODCAST', plugin_dir_url(__FILE__));

	add_action('plugins_loaded', 'sj_podcasts_load', 10, 0);

	function sj_podcasts_load()
	{
		//add_shortcode( 'synergyjar_podcasts', 'sj_podcast_list' );

		wp_register_script('sj-podcasts-js', PLUGINPATH_PODCAST . 'assets/js/podcast.js', '', '1.0', true);
		wp_enqueue_script('sj-podcasts-js');

		wp_register_script('sj-record-js', PLUGINPATH_PODCAST . 'assets/js/add-feed.js', '', '1.0', true);
		wp_enqueue_script('sj-record-js');
		wp_localize_script('sj-record-js', 'ajaxurl', admin_url('admin-ajax.php'));

		wp_register_script('sj-filters-js', PLUGINPATH_PODCAST . 'assets/js/categories.js', '', '1.0', true);
		wp_enqueue_script('sj-filters-js');

		wp_register_script('sj-set-feed-js', PLUGINPATH_PODCAST . 'assets/js/set-feed.js', '', '1.0', true);
		wp_enqueue_script('sj-set-feed-js');
		wp_localize_script('sj-set-feed-js', 'ajaxurl', admin_url('admin-ajax.php'));

		wp_register_script('sj-record-episode-js', PLUGINPATH_PODCAST . 'assets/js/record-episode.js', '', '1.0', true);
		wp_enqueue_script('sj-record-episode-js');
		wp_localize_script('sj-record-episode-js', 'ajaxurl', admin_url('admin-ajax.php'));

		wp_enqueue_style('sj_podcasts_style', PLUGINPATH_PODCAST . 'assets/css/podcasts.min.css', true);

		wp_enqueue_script('sj-module-web-audio-recorder-js', PLUGINPATH_PODCAST . 'modules/web-audio-recorder-js/web-audio-recorder-js/lib/WebAudioRecorder.js', '', '1.0', true);

		wp_enqueue_script('sj-web-audio-recorder-js', PLUGINPATH_PODCAST . 'assets/js/web-audio-recorder-js.js', '', '1.0', true);
		wp_localize_script(
			'sj-web-audio-recorder-js',
			'plugin_data',
			array(
				'ajaxurl'            => admin_url('admin-ajax.php'),
				'PLUGINPATH_PODCAST' => PLUGINPATH_PODCAST,
			)
		);
	}
} else {

	function general_admin_notice()
	{
		echo '<div class="notice notice-warning is-dismissible">
				 <p>Please install and activate Powerpress</p>
			 </div>';
	}
	add_action('admin_notices', 'general_admin_notice');

	wp_die('Error: Please install and activate PowerPress plugin.');
}
