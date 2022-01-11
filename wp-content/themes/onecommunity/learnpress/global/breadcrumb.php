<?php
/**
 * Template for displaying archive courses breadcrumb.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/global/breadcrumb.php.
 *
 * @author  ThimPress
 * @package  Learnpress/Templates
 * @version  3.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();
?>

<?php

if ( ! empty( $breadcrumb ) ) { ?>

	<nav class="learn-press-breadcrumb" itemprop="breadcrumb">

	<?php echo "<span>" . esc_attr__('You are here:', 'onecommunity') . "</span> ";

	foreach ( $breadcrumb as $key => $crumb ) {

		if ( ! empty( $crumb[1] ) && sizeof( $breadcrumb ) !== $key + 1 ) {
			echo '<a href="' . esc_url( $crumb[1] ) . '">' . esc_html( $crumb[0] ) . '</a>';
		} else {
			echo esc_html( $crumb[0] );
		}


		if ( sizeof( $breadcrumb ) !== $key + 1 ) {
			echo '<span class="delimeter"> / </span>';
		}

	}

	echo "</nav>";
	
}
