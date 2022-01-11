<?php
/**
 * Summary: Podcast result filters for sidebar.
 * Description:
 *
 * @since 1.0
 * @package WordPress
 */

require 'controls/class_category_walker.php';

if ( ! defined( 'ABSPATH' ) ){
	exit; // Exit if accessed directly.
};

add_shortcode( 'podcast_filters', 'load_podcast_filters' );

/**
 *
 * Get child categories of podcast for sidebar filters
 */
function load_podcast_filters() {
	$categories = wp_list_categories( 
		array(
			'title_li'   => '',
			'feed_type'  => '',
			'orderby'    => 'name',
			'show_count' => true,
			'child_of'   => 39,
			'walker'     => new Category_Walker_Custom()
		)
	);

	echo esc_html( $categories );
};


add_filter( 'wp_list_categories', 'add_slug_css_list_categories', 10, 2 );

/**
 * Add unique identifier to list of categories so event listener can track click.
 *
 * @param type var $output Description.
 * @param type var $args Description.
 */
function add_slug_css_list_categories( $output, $args ) {

	$output = strip_tags( $output, '<li>' );

	return $output;
};

add_filter( 'category_css_class', 'add_category_slug_as_class', 10, 4 );

/**
 * Add category slug as css class to podcast sidebar filter
 *
 * @param type var $css_classes Description.
 * @param type var $category Description.
 */
function add_category_slug_as_class( $css_classes, $category ) {
	$css_classes[] = 'podcast-filters-list podcast-cat-' . $category->cat_ID;
	return $css_classes;
}
