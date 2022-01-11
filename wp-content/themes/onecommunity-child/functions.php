<?php

add_action('wp_enqueue_scripts', 'onecommunity_scripts_child', 100);
add_action('wp_enqueue_scripts', 'onecommunity_js_functions_child');
add_action('after_setup_theme', 'remove_admin_bar');

define( 'DAY_IN_SECONDS', 24 * HOUR_IN_SECONDS );

function onecommunity_js_functions_child()
{
	wp_enqueue_script('onecommunity-js-functions-child', get_stylesheet_directory_uri() . '/js/functions.js', array('jquery'), '', true);
	wp_localize_script('onecommunity-js-functions-child', 'GoogleGeocode', array(
		'geocode_key' => get_option('google_geocode_key')
	));
	wp_enqueue_script('synergyjar-jquery-ui', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js', '', '', true);

	wp_enqueue_script('synergyjar-js', get_stylesheet_directory_uri() . '/js/synergyjar.min.js', array('jquery'), '', true);
	wp_localize_script('synergyjar-js', 'GoogleGeocode', array(
		'geocode_key' => get_option('google_geocode_key')
	));



	wp_enqueue_script('onecommunity-script', get_template_directory_uri() . '/js/functions.js', true, null, 'in_footer');
}
function onecommunity_scripts_child()
{

	wp_deregister_style('onecommunity');

	// Theme stylesheet.
	wp_enqueue_style('onecommunity', get_template_directory_uri() . '/style.min.css');
	wp_enqueue_style(
		'onecommunity-child',
		get_stylesheet_directory_uri() . '/style.min.css',
		array('onecommunity'),
		wp_get_theme()->get('Version')
	);

	wp_dequeue_style('onecommunity-style', 100);
	wp_dequeue_style('responsive', 100);

	wp_register_style('responsive-child', get_stylesheet_directory_uri() . '/css/responsive.min.css', array());
	wp_enqueue_style('responsive-child');

	wp_register_style('onecommunity-animations-child', get_stylesheet_directory_uri() . '/css/animations.css', array());
	wp_enqueue_style('onecommunity-animations-child');

	wp_enqueue_script('masonry');

	// Load the html5 shiv.
	wp_enqueue_script('onecommunity-html5', get_template_directory_uri() . '/js/html5.js', array(), '3.7.3');
	wp_script_add_data('onecommunity-html5', 'conditional', 'lt IE 9');


	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}

	wp_enqueue_style('google-nunito', 'https://fonts.googleapis.com/css?family=Nunito&display=swap');


	wp_deregister_style('wp-ulike');

	wp_deregister_script('onecommunity-script');
	wp_dequeue_script('onecommunity-script', 100);
}

function remove_admin_bar()
{
	if (!current_user_can('administrator') && !is_admin()) {
		show_admin_bar(false);
	}
}

function add_option_field_to_general_admin_page()
{
	$option_name = 'google_geocode_key';

	register_setting('general', $option_name);

	add_settings_field(
		$option_name,
		'Google Geocode API Key',
		'geocode_key_setting_callback_function',
		'general',
		'default',
		array(
			'id' => $option_name,
			'option_name' => $option_name
		)
	);
}
add_action('admin_menu', 'add_option_field_to_general_admin_page');

function geocode_key_setting_callback_function($val)
{
	$id = $val['id'];
	$option_name = $val['option_name'];
?>
	<input type="text" name="<?php echo $option_name; ?>" id="<?php echo $id; ?>" value="<?php echo esc_attr(get_option($option_name)); ?>" class="regular-text" />
<?php
}

add_action('init', 'register_menus_child');

function register_menus_child()
{

	register_nav_menus(
		array(
			'header-menu-public-owner' => 'Header Public Owner',
			'header-menu-private-agency' => 'Header Private Agency'
		)
	);

	if (has_nav_menu('header-menu-public-owner') || has_nav_menu('header-menu-private-agency')) {

		class Child_Wrap_Child extends Walker_Nav_Menu
		{
			function start_lvl(&$output, $depth = 0, $args = array())
			{
				$indent = str_repeat("\t", $depth);
				$output .= "\n$indent<div class=\"nav-ul-container fadein\"><ul class=\"sub-menu\">\n";
			}
			function end_lvl(&$output, $depth = 0, $args = array())
			{
				$indent = str_repeat("\t", $depth);
				$output .= "$indent</ul></div>\n";
			}
		}
	}
}

add_filter('shortcode_atts_wpcf7', 'custom_shortcode_atts_wpcf7_filter', 10, 3);

function custom_shortcode_atts_wpcf7_filter($out, $pairs, $atts)
{
	$my_attr = 'agency-name';

	if (isset($atts[$my_attr])) {
		$out[$my_attr] = $atts[$my_attr];
	}

	return $out;
}

add_action('init', 'synergyjar_cookies', 10, 3);

function synergyjar_cookies()
{
	if ($_REQUEST['filter'] === 'subjectmatter' || $_REQUEST['filter'] === 'rateconsultant' || $_REQUEST['filter'] === 'ownertoowner' ) {
		if (!isset($_COOKIE[$_REQUEST['filter']])) {
			setcookie( $_REQUEST['filter'], 1, -3 * MONTH_IN_SECONDS, COOKIEPATH, COOKIE_DOMAIN );			
		}
	}
}

function youzer_modal($modal_content)
{
	if (!isset($_COOKIE[$_REQUEST['filter']])) {
		set_query_var('modal_content', $modal_content);
		get_template_part('template-parts/modal', 'index');
	}
}


function free_level_change_pmpro_level_cost_text($text, $level)
{
	if (pmpro_isLevelFree($level)) {
		return '';
	} else {
		return $text;
	}
}
add_filter('pmpro_level_cost_text', 'free_level_change_pmpro_level_cost_text', 10, 2);
