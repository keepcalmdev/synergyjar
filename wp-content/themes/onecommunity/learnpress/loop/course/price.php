<?php
/**
 * Template for displaying price of course within the loop.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/loop/course/price.php.
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

<div class="course-price">

	<?php if ( $price_html = $course->get_price_html() ) { ?>

	    <span class="price"><?php echo esc_html( $price_html ); ?></span>

		<?php if ( $course->get_origin_price() != $course->get_price() ) { ?>

			<?php $origin_price_html = $course->get_origin_price_html(); ?>

            <span class="origin-price"><?php echo esc_html( $origin_price_html ); ?></span>

		<?php } ?>

	<?php } ?>

</div>