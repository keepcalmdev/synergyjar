<?php
/**
 * Template for displaying course content within the loop.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/content-course.php
 *
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 3.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

$user = LP_Global::user();
?>

<li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php

    // @since 3.0.0
    do_action( 'learn-press/before-courses-loop-item' );
    ?>

		<?php

        // @since 3.0.0
        do_action( 'learn-press/courses-loop-item-title' );
        ?>

	<?php

    // @since 3.0.0
	do_action( 'learn-press/after-courses-loop-item' );

    ?>

    <p class="excerpt"><?php echo get_the_excerpt(); ?></p>

    </div><!-- .box-course-details end -->

</li>