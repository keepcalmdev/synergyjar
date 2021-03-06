<?php
/**
 * Template for displaying content of Featured Courses widget.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/widgets/featured-courses/default.php.
 *
 * @author   ThimPress
 * @category Widgets
 * @package  Learnpress/Templates
 * @version  3.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

if ( ! isset( $courses ) ) {
	esc_html_e( 'No courses', 'learnpress' );

	return;
}

global $post;
//widget instance
$instance = $this->instance;
?>

<div class="archive-course-widget-outer">

    <div class="widget-body">
		<?php foreach ( $courses as $course_id ) {

			$post = get_post( $course_id );
			setup_postdata( $post );
			$course = learn_press_get_course( $course_id );

			?>

            <div class="course-entry">

                <!-- course thumbnail -->
                <?php if ( ! empty( $instance['show_thumbnail'] ) && $image = $course->get_image( 'medium' ) ) { ?>
                    <div class="course-cover">
                        <a href="<?php echo esc_url($course->get_permalink()); ?>">
                            <?php echo wp_kses( $image, array( 'img' => array( 'class' => array(), 'src' => array(), 'alt' => array(), 'srcset' => array(), 'sizes' => array(), 'width' => array(), 'height' => array() ) ) ); ?>
                        </a>
                    </div>
                <?php } ?>

                <div class="course-detail">
                    <!-- course title -->
                    <a href="<?php echo get_the_permalink( $course->get_id() ) ?>">
                        <h6 class="course-title"><?php echo wp_kses_post( $course->get_title() ); ?></h6>
                    </a>

                    <!-- course content -->
                    <?php if ( ! empty( $instance['desc_length'] ) && ( $len = intval( $instance['desc_length'] ) ) > 0 ) { ?>
                        <div class="course-description">
                            <?php echo wp_kses_post( $course->get_content( 'raw', $len, __( '...', 'learnpress' ) ) ); ?>
                        </div>
                    <?php } ?>

                    <div class="course-meta-data">
                        <!-- price -->
                        <?php if ( ! empty( $instance['show_price'] ) ) { ?>
                            <div class="course-meta-field"><?php echo wp_kses_post( $course->get_price_html() ); ?></div>
                        <?php } ?>

                        <!-- number students -->
                        <?php if ( ! empty( $instance['show_enrolled_students'] ) ) { ?>
                            <div class="course-student-number course-meta-field">
                                <?php echo wp_kses_post( $course->get_students_html() ); ?>
                            </div>
                        <?php } ?>

                        <!-- number lessons -->
                        <?php if ( ! empty( $instance['show_lesson'] ) ) { ?>
                            <div class="course-lesson-number course-meta-field">
                                <?php
                                $lesson_count = $course->count_items( LP_LESSON_CPT );
                                echo wp_kses_post( $lesson_count ) > 1 ? sprintf( __( '%d lessons', 'learnpress' ), $lesson_count ) : sprintf( __( '%d lesson', 'learnpress' ), $lesson_count ); ?>
                            </div>
                        <?php } ?>

                        <!-- instructor -->
                        <?php if ( ! empty( $instance['show_teacher'] ) ) { ?>
                            <div class="course-meta-field"><?php echo wp_kses( $course->get_instructor_html(), array( 'a' => array( 'class' => array(), 'href' => array(), 'title' => array(), 'rel' => array() ) ) ); ?></div>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <div class="clear"></div>

		<?php } ?>

    </div>

	<?php wp_reset_postdata();?>

    <div class="widget-footer">
		<?php if ( ! empty( $instance['bottom_link_text'] ) && ( $page_id = learn_press_get_page_link( 'courses' ) ) ) {
			$text = $instance['bottom_link_text'] ? $instance['bottom_link_text'] : get_the_title( $page_id );
			?>
            <a class="pull-right" href="<?php echo esc_url( learn_press_get_page_link( 'courses' ) ); ?>">
				<?php echo wp_kses_post( $text ); ?>
            </a>
		<?php } ?>
    </div>
</div>