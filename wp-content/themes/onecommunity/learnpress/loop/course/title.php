<?php
/**
 * Template for displaying title of course within the loop.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/loop/course/title.php.
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

<div class="box-course-details">

	<div class="box-course-details-top">

		<?php do_action( 'learn-press/courses-loop-item-details-top-category' ); ?>

		<span class="box-course-price">
		<?php 
		do_action( 'learn-press/courses-loop-item-details-top-price' );
		?>
		</span>

	</div>

<h2><a href="<?php the_permalink(); ?>" class="course-permalink"><?php the_title(); ?></a></h2>