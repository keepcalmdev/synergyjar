<?php
/**
 * Template for displaying instructor of course within the loop.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/loop/course/instructor.php.
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

<span class="box-course-details-bottom-author">
	<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
		<?php echo get_avatar( get_the_author_meta( 'user_email' ), 25 ); ?>
	</a>
	<?php echo get_the_author(); echo " "; echo get_the_author_meta('last_name'); ?>
</span>
