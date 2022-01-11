<?php
/**
 * Template for displaying thumbnail of course within the loop.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/loop/course/thumbnail.php.
 *
 * @author  ThimPress
 * @package  Learnpress/Templates
 * @version  3.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

$course = LP_Global::course();
?>

<div class="course-thumbnail">

<a href="<?php the_permalink(); ?>" class="course-permalink">
	<?php echo wp_kses( $course->get_image( 'post-thumbnail' ), array( 'img' => array( 'class' => array(), 'src' => array(), 'alt' => array(), 'srcset' => array(), 'sizes' => array(), 'width' => array(), 'height' => array() ) ) ); ?>
</a>

</div>
