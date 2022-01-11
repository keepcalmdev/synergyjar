<?php
define('PLUGINPATH', plugin_dir_url( __FILE__ ));

if ( is_admin() ) {
	//require_once WPCF7_PLUGIN_DIR . '/admin/admin.php';
} else {
    require_once SYNERGYJAR_DIR . '/includes/locations.php';
	require_once SYNERGYJAR_DIR . '/includes/maps.php';
	require_once SYNERGYJAR_DIR . '/includes/content.php';
	require_once SYNERGYJAR_DIR . '/includes/loop-filters.php';
}

add_action( 'plugins_loaded', 'synergyjar', 10, 0 );
add_action( 'synergyjar-membmap', 'members_map', 10, 0 );

function synergyjar(){
	
    add_shortcode('gmapsprofiles', 'gmapsprofiles');
    add_shortcode('copprofiles', 'copprofiles');
	add_shortcode('content', 'content');
	add_shortcode('powerpress_settings_imageurl','powerpress_get_image');
	add_shortcode('synergyjar_login','synergyjar_login');

	wp_register_script( 'content-js', PLUGINPATH . 'js/content.js', '', '1.0', true );
	wp_enqueue_script( 'content-js', PLUGINPATH . 'js/content.js', '', '1.0', true );

	wp_enqueue_style('font-awesome-pro', PLUGINPATH . 'css/all.min.css', true );
	wp_enqueue_style('font-awesome-pro', PLUGINPATH . 'css/light.min.css', true );

}

function synergyjar_login(){
	return wp_login_form();
}
function members_map(){
	echo do_shortcode('[gmapsprofiles]'); 
}
function powerpress_get_image(){

	if ( is_feed() ) {
		return '';
	}
	
	// Only works on pages...
	if ( !is_singular() ) {
		if( empty($attr['archive']) )
			return '';
	}

	/*
	extract( shortcode_atts( array(
		'channel'=>'', // Used for PowerPress Podcast Channels
		'slug' => '', // Used for PowerPress (alt for 'channel')
		'feed' => '', // Used for PowerPress (alt for 'channel')
		'post_type' => 'post', // Used for PowerPress 
		'category'=>'', // Used for PowerPress (specify category ID, name or slug)
		'term_taxonomy_id'=>'', // Used for PowerPress (specify term taxonomy ID)
		//'term_id'=>'', // Used for PowerPress (specify term ID, name or slug)
		//'taxonomy'=>'', // Used for PowerPress (specify taxonomy name)
		
		'title'	=> '', // Display custom title of show/program
		'subtitle'=>'', // Subtitle for podcast (optional)
		'feed_url'=>'', // provide subscribe widget for specific RSS feed
		'itunes_url'=>'', // provide subscribe widget for specific iTunes subscribe URL
		'image_url'=>'', // provide subscribe widget for specific iTunes subscribe URL
		'heading'=>'', // heading label for podcast
		
		'itunes_subtitle'=>'', // Set to 'true' to include the iTunes subtitle in subscribe widget
		
		// Appearance attributes
		'itunes_button'=>'', // Set to 'true' to use only the iTunes button
		'itunes_banner'=>'', // Set to 'true' to use only the iTunes banner
		'style'=>'' // Set to 'true' to use only the iTunes banner
	), $attr, 'powerpresssubscribe' ) );
	//return print_r($attr, true);
	*/
	
	/**/
	if( !is_array($attr) ) // Convert to an array to avoid php notice messages
	{
		$attr = array();
	}
	
	if( empty($attr['slug']) && !empty($attr['feed']) )
		$attr['slug'] = $attr['feed'];
	else if( empty($attr['slug']) && !empty($attr['channel']) )
		$attr['slug'] = $attr['channel'];
	else if( empty($attr['slug']) )
		$attr['slug'] = 'podcast';
	
	// Set empty args to prevent warnings
	if( !isset($attr['term_taxonomy_id']) )
		$attr['term_taxonomy_id'] = '';
	if( !isset($attr['category_id']) )
		$attr['category_id'] = '';
	if( !isset($attr['post_type']) )
		$attr['post_type'] = '';

	$subscribe_type = '';
	$category_id = '';
		
	if(!empty($attr['category']) )
	{
		$CategoryObj = false;
		if( preg_match('/^[0-9]*$/', $attr['category']) ) // If it is a numeric ID, lets try finding it by ID first...
			$CategoryObj = get_term_by('id', $attr['category'], 'category');
		if( empty($CategoryObj) )
			$CategoryObj = get_term_by('name', $attr['category'], 'category');
		if( empty($CategoryObj) )
			$CategoryObj = get_term_by('slug', $attr['category'], 'category');
		if( !empty($CategoryObj) )
		{
			$category_id = $CategoryObj->term_id;
		}
	}
	

	
	if( !empty($attr['category']) )
		$subscribe_type = 'category';
	else if( !empty($attr['term_taxonomy_id']) )
		$subscribe_type = 'ttid';
	else if( !empty($attr['post_type']) )
		$subscribe_type = 'post_type';
	else if( empty($attr['post_type']) && !empty($attr['slug']) && $attr['slug'] != 'podcast' )
		$subscribe_type = 'channel';
	
	$Settings = array();
	if( !empty($attr['feed_url']) )
	{
		$Settings['feed_url'] = $attr['feed_url'];
	}
	else
	{
		$Settings = powerpresssubscribe_get_settings(  array('feed'=>$attr['slug'], 'taxonomy_term_id'=>$attr['term_taxonomy_id'], 'cat_id'=>$category_id, 'post_type'=>$attr['post_type'], 'subscribe_type'=>$subscribe_type), false );
	}
	echo '<img src="' . $Settings['image_url'] . '" />';
}
