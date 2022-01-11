<?php
/**
 * Template for displaying course content within the loop.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/content-single-course.php
 *
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 3.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

if ( post_password_required() ) {
	echo get_the_password_form();

	return;
}

/**
 * @since 3.0.0
 */
do_action( 'learn-press/before-main-content' );

do_action( 'learn-press/before-single-course' );

?>
<div id="learn-press-course" class="course-summary">


<?php
	if ( has_post_thumbnail() ) { ?>
		<div class="thumbnail">
			<?php
			the_post_thumbnail('post-thumbnail-vertical');
			dd_the_post_thumbnail_caption(); ?>
		</div>
		<?php } else {
		// no thumbnail
	}
?>

<div class="lp-single-details">

	<h2><?php the_title(); ?></h2>

	<p class="excerpt"><?php echo get_the_excerpt(); ?></p>

<?php 

$course = learn_press_get_course();

do_action( 'learn-press/lp-single-details-begin' );

echo "<ul>";

do_action( 'learn-press/lp-single-details-list-begin' );

echo "<li>" . esc_attr__('Lessons', 'onecommunity') . ": <span>";
$lessons = $course->get_curriculum_items( 'lp_lesson' ) ? count( $course->get_curriculum_items( 'lp_lesson' ) ) : 0;
echo wp_kses_post($lessons).'</span></li>';

///////////////////////////////////////////////////////////////////////////////////////////

echo "<li>" . esc_attr__('Quizzes', 'onecommunity') . ": <span>";
$quizzes = $course->get_curriculum_items( 'lp_quiz' ) ? count( $course->get_curriculum_items( 'lp_quiz' ) ) : 0;
echo wp_kses_post($quizzes) . '</span></li>';

///////////////////////////////////////////////////////////////////////////////////////////

echo "<li>" . esc_attr__('Duration', 'onecommunity') . ": <span>";
onecommunity_course_duration();
echo "</span></li>";

///////////////////////////////////////////////////////////////////////////////////////////

echo "<li>" . esc_attr__('Passing condition', 'onecommunity') . ": <span>" . $course->get_passing_condition(true) . "</span></li>";

///////////////////////////////////////////////////////////////////////////////////////////

echo "<li>" . esc_attr__('Max students', 'onecommunity') . ": <span>" . $course->get_data( 'max_students' ) . "</span></li>";

//    $sale_price = $course->has_sale_price();
//    if ($sale_price == true) {
//    	echo "sale price";
//    } else {
//    	echo "no sale price";
//    }

do_action( 'learn-press/lp-single-details-list-end' );

echo "</ul>";

do_action( 'learn-press/lp-single-details-end' );

echo '<div class="tags">' . $course->get_tags() . '</div>';
?>
</div><!-- .lp-single-details -->


<div class="clear"></div>


	<?php
	/**
	 * @since 3.0.0
	 *
	 * @see learn_press_single_course_summary()
	 */
	do_action( 'learn-press/single-course-summary' );
	?>
</div>
<?php

/**
 * @since 3.0.0
 */
do_action( 'learn-press/after-main-content' );

do_action( 'learn-press/after-single-course' );
