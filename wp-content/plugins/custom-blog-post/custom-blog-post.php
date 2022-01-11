<?php
/**
 * Plugin Name: Custom Blog Post
 * Plugin URI: https://www.redcircle.biz
 * Description: Add the ability to add custom form to sumbit posts from a page.
 * Version: 1.0
 * Author: Michael Burbage
 * Author URI: https://www.redcircle.biz
 *
 * @package WordPress
 **/

wp_register_style( 'customblogpost', '/wp-content/plugins/custom-blog-post/css/custom-blog-post.css', array(), true, $media = 'all' );

wp_enqueue_style( 'customblogpost', '/wp-content/plugins/custom-blog-post/css/custom-blog-post.css', array(), true, $media = 'all' );

add_shortcode( 'custom_blog_post', 'custom_blog_post' );

/**
 * Load Shortcode Function
 **/
function custom_blog_post() {
	if ( is_admin() ) {
		return;
	} else {
		custom_blog_post_if_submitted();
		?>
		<div id="postbox">
		<form id="new_post" name="new_post" method="post">
		<label for="title">Title</label><br />
		<input type="text" id="title" value="" tabindex="1" size="20" name="title" />
		<label for="content">Post Content</label><br />
		<?php
		$settings = array(
			'textarea_name' => 'wpeditor',
			'media_buttons' => true,
			'tinymce'       => array(
				'theme_advanced_buttons1' => 'formatselect,|,bold,italic,underline,|,bullist,blockquote,|,justifyleft,justifycenter,justifyright,justifyfull,|,link,unlink,|,spellchecker,wp_fullscreen,wp_adv',
			),
		);
		wp_editor( '', 'wpeditor', $settings );
		?>
		<br/>
		<?php
		wp_dropdown_categories( 'show_option_none=Category&tab_index=4&taxonomy=category' );
		?>
		<?php wp_nonce_field( 'wps-frontend-post' ); ?>
		<input type="submit" value="Publish" tabindex="6" id="submit" name="submit" />
		</form>
		</div>
		<?php
	}
}
/**
 *
 * Submit Blog Post
 */
function custom_blog_post_if_submitted() {

	if ( ! isset( $_POST['_wpnonce'] ) ) {
		return;
	} else {
		$nonce = sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) );
	}
	// Stop running function if form wasn't submitted.
	if ( ! isset( $_POST['title'] ) ) {
		return;
	}
	if ( ! isset( $_POST['wpeditor'] ) ) {
		return;
	}
	$title = sanitize_title( wp_unslash( $_POST['title'] ) );
	$body  = sanitize_textarea_field( wp_unslash( $_POST['wpeditor'] ) );

	// Check that the nonce was set and valid.
	if ( ! wp_verify_nonce( $nonce, 'wps-frontend-post' ) ) {
		echo 'Did not save because your form seemed to be invalid. Sorry';
		return;
	}
	// Do some minor form validation to make sure there is content.
	if ( strlen( $title ) < 3 ) {
		echo 'Please enter a title. Titles must be at least three characters long.';
		return;
	}
	if ( strlen( $body ) < 100 ) {
		echo 'Please enter content more than 100 characters in length';
		return;
	}
	$post_author = get_the_author_meta( 'ID' );
	// Add the content of the form to $post as an array.
	$post = array(
		'post_title'    => $title,
		'post_content'  => $body,
		'post_category' => array( 20 ),
		'post_status'   => 'publish',
		'post_type'     => 'post',
		'post_author'   => $post_author,
	);
	wp_insert_post( $post );
	echo 'Saved your post successfully! :)';
}
