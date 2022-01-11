<?php
/*
Template Name: Community Home
*/
?>

<?php get_header() ?>



<div class="breadcrumbs">

<?php
$home = home_url();
$body_classes = get_body_class();
if(in_array('learnpress-page', $body_classes))
{
	if ( learn_press_is_course_tag() ) {

		echo esc_attr_e('You are here:', 'onecommunity'); ?> <a href="<?php esc_url($home); ?>"><?php esc_attr_e('Home', 'onecommunity'); ?></a> / <?php

		$post = get_post( get_option('learn_press_courses_page_id') );
		echo "<a href='" . $home . '/' . $post->post_name . "'>" . $post->post_title . "</a>";
		echo " / ";
		global $wp;
		$url = home_url( $wp->request );
		$slug = get_option( "learn_press_course_tag_base" );
		$output = array_pop(explode($slug, $url));
		$output = str_replace("/", "", $output);
		echo '<span class="current">' . ucfirst($output) . '</span>';

	} elseif ( learn_press_is_course_category() ) {

		esc_attr_e('You are here:', 'onecommunity'); ?> <a href="<?php esc_url($home); ?>"><?php esc_attr_e('Home', 'onecommunity'); ?></a> / <?php

		$post = get_post( get_option('learn_press_courses_page_id') );
		echo "<a href='" . $home . '/' . $post->post_name . "'>" . $post->post_title . "</a>";
		echo " / ";
		global $wp;
		$url = home_url( $wp->request );
		$slug = get_option( "learn_press_course_category_base" );
		$output = explode($slug, $url);
		$output = array_pop($output);
		$output = str_replace("/", "", $output);
		echo '<span class="current">' . ucfirst($output) . '</span>';

	} else {
		 do_action( 'learn-press/breadcrumbs' );
	}

} else { ?>
	<?php esc_attr_e('You are here:', 'onecommunity'); ?> <a href="<?php esc_url($home); ?>"><?php esc_attr_e('Home', 'onecommunity'); ?></a> / <span class="current"><?php the_title(); ?></span>
<?php } ?>

</div>

<?php if(!in_array('learnpress-page', $body_classes)) { ?>
	    
	<?php
	}


	if(!in_array('learnpress-page', $body_classes)) {
	if ( has_post_thumbnail() ) { ?>
	
			<?php
			the_post_thumbnail('post-thumbnail-2');
			dd_the_post_thumbnail_caption();
	} else {
	echo '&nbsp;';
	}
	}
	?>

	    
<div id="pagebuilder-container">
		<?php
		the_content();
		?>

<!-- <div class="frontpage-row-2 frontpage-row">
	<h4>Member Locations</h4>
	<?php //echo do_shortcode('[gmapsprofiles]'); ?>
</div> -->

<div class="frontpage-row-2 frontpage-row">
	<?php echo adrotate_group('2'); ?>
</div>



<div class="frontpage-row-2 frontpage-row">
	<?php echo do_shortcode( "[onecommunity-bp-groups-listing number_of_groups='6' col='6']" ); ?>
</div>

  <div class="frontpage-row-4 frontpage-row">

  	<div class="frontpage-row-4-left">
	<h4><a href="/leaderboard">Members Rank</a></h4>

		<?php
		if ( shortcode_exists( 'onecommunity-gamipress-leaderboard' ) ) {
			echo do_shortcode( '[onecommunity-gamipress-leaderboard limit="5" name="points" layout="small" type="_gamipress_points_points"]' );
		}
		?>

  	</div>

  	<div class="frontpage-row-4-right">
	<h4 id="activity-menu-button">New Activity</h4>

	<?php echo do_shortcode( '[onecommunity-activity max="8" col="2"]' ); ?>
  </div>

  </div>
</div>

  <div class="frontpage-row-3 frontpage-row">


	<div class="frontpage-row-3-title">
		<h4 id="shortcode-posts-menu-button">Recent News</h4>
	</div>

	<?php echo do_shortcode( '[onecommunity-cat-posts cat_id="15,85,17,21,19,20,86,6,7,5,13"]' ); ?>


  </div>
	

<?php get_footer() ?>