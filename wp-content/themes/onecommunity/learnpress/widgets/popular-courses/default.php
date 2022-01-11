<?php
/**
 * Template for displaying content of Popular Courses widget.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/widgets/popular-courses/default.php.
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

if ( ! isset( $courses ) ) {
	esc_html_e( 'No courses', 'learnpress' );

	return;
}

global $wpdb;
global $post;
//widget instance
$instance = $this->instance;
$home = home_url("/");
$categories_slug = get_option( 'learn_press_course_category_base' );
?>

<div class="archive-course-widget-outer">

    <div class="widget-body">
		<?php foreach ( $courses as $course_id ) {
			if ( ! $course_id ) {
				continue;
			}
			$post = get_post( $course_id );
			setup_postdata( $post );
			$course = learn_press_get_course( $course_id ); ?>

            <div class="course-entry">

                <!-- course thumbnail -->
				<?php if ( ! empty( $instance['show_thumbnail'] ) && $image = $course->get_image( 'post-thumbnail' ) ) { ?>
                    <div class="course-cover">
                        <a href="<?php echo esc_url($course->get_permalink()); ?>">
                            <?php echo wp_kses( $image, array( 'img' => array( 'class' => array(), 'src' => array(), 'alt' => array(), 'srcset' => array(), 'sizes' => array(), 'width' => array(), 'height' => array() ) ) ); ?>
                        </a>
                    </div>
				<?php } ?>

                <div class="course-detail">

				<div class="course-detail-top">

                <?php onecommunity_course_category(); ?>

                    <!-- price -->
					<?php if ( ! empty( $instance['show_price'] ) ) { ?>
                        <div class="course-meta-field price"><?php echo esc_html( $course->get_price_html() ); ?></div>
					<?php } ?>

				</div><!-- ccourse-detail-top -->

                    <!-- course title -->
                    <a href="<?php echo get_the_permalink( $course->get_id() ) ?>">
                        <h4 class="course-title"><?php echo esc_html( $course->get_title() ); ?></h4>
                    </a>

                    <!-- course content -->
					<?php if ( ! empty( $instance['desc_length'] ) && ( $len = intval( $instance['desc_length'] ) ) > 0 ) { ?>
                        <div class="course-description">
							<?php echo esc_html( $course->get_content( 'raw', $len, __( '...', 'learnpress' ) ) ); ?></div>
					<?php } ?>

                    <div class="course-meta-data">

                        <!-- number students -->
						<?php if ( ! empty( $instance['show_enrolled_students'] ) ) { ?>
                            <div class="course-student-number course-meta-field">
								<?php echo esc_html( $course->get_students_html() ); ?>
                            </div>
						<?php } ?>

                        <!-- number lessons -->
						<?php if ( ! empty( $instance['show_lesson'] ) ) { ?>
                            <div class="course-lesson-number course-meta-field">
								<?php
								$lesson_count = $course->count_items( LP_LESSON_CPT );
								echo esc_html( $lesson_count ) > 1 ? sprintf( __( '%d lessons', 'learnpress' ), $lesson_count ) : sprintf( __( '%d lesson', 'learnpress' ), $lesson_count ); ?>
                            </div>
						<?php } ?>

                        <!-- instructor -->
						<?php if ( ! empty( $instance['show_teacher'] ) ) { ?>
                            <div class="course-meta-field instructor">
                            	<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author"><?php echo get_avatar( get_the_author_meta( 'user_email' ), 25 ); ?></a>
                            	<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author" class="name"><?php echo esc_attr( get_the_author_meta('first_name') ) . " " . esc_attr( get_the_author_meta('last_name') ); ?></a>
                            		
                            	</div>
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