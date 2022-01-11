<?php
function onecommunity_activity($atts, $content = null)
{
	extract(shortcode_atts(array(
		"max" => '12',
		"col" => '3'
	), $atts));
	ob_start();
	$nonce = wp_create_nonce("onecommunity_activity");
?>

	<div id="tabs-activity" class="shortcode-activity col-<?php echo $col ?>">

		<ul class="tabs-activity-nav">
			<li class="nav-1 current" data-tab-type="1" data-tab-page="1" data-nonce="<?php echo $nonce ?>"><?php _e('Groups', 'onecommunity-shortcodes'); ?></li>
			<li class="nav-2" data-tab-type="2" data-tab-page="1" data-nonce="<?php echo $nonce ?>"><?php _e('Profiles', 'onecommunity-shortcodes'); ?></li>
			<li class="nav-3" data-tab-type="3" data-tab-page="1" data-nonce="<?php echo $nonce ?>"><?php _e('Friends', 'onecommunity-shortcodes'); ?></li>
			<li class="nav-4" data-tab-type="4" data-tab-page="1" data-nonce="<?php echo $nonce ?>"><?php _e('Forum topics', 'onecommunity-shortcodes'); ?></li>
			<li class="nav-5" data-tab-type="5" data-tab-page="1" data-nonce="<?php echo $nonce ?>"><?php _e('Forum posts', 'onecommunity-shortcodes'); ?></li>
			<li class="nav-6" data-tab-type="6" data-tab-page="1" data-nonce="<?php echo $nonce ?>"><?php _e('Blog comments', 'onecommunity-shortcodes'); ?></li>
		</ul>

		<div class="list-wrap">

			<div class="tab-content shortcode-activity-list">
				<ul class="tab-content-list">

					<?php

					echo '<script>console.log(' . json_encode($max) . ');</script>';

					if (bp_has_activities(bp_ajax_querystring('activity') . '&page=1&object=groups&per_page=' . $max . '')) :
						while (bp_activities()) : bp_the_activity();
							locate_template(array('buddypress/activity/entry-shortcode.php'), true, false);
						endwhile;
					endif; ?>

				</ul>

				<div class="clear"></div>

			</div>

		</div><!-- list-wrap -->
	</div><!-- shortcode-activity -->
	<?php
	$shortcode_content = ob_get_clean();
	return $shortcode_content;
}
add_shortcode("onecommunity-activity", "onecommunity_activity");

///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////

function onecommunity_activity_load()
{
	$tab_activity_type = esc_html($_POST['tab_activity_type']);
	$tab_activity_page = esc_html($_POST['tab_activity_page']);
	$nonce = wp_create_nonce("onecommunity_activity");
	$nonce = esc_html($_POST['nonce']);

	if (!wp_verify_nonce($_REQUEST['nonce'], "onecommunity_activity")) {
		exit("Illegal request");
	}

	if ($tab_activity_type == 1) {

		if (bp_has_activities(bp_ajax_querystring('activity') . '&per_page=8&page=' . $tab_activity_page . '&object=groups')) :
			while (bp_activities()) : bp_the_activity();
				locate_template(array('buddypress/activity/entry-shortcode.php'), true, false);
			endwhile;
		endif;
	} elseif ($tab_activity_type == 2) {

		if (bp_has_activities(bp_ajax_querystring('activity') . '&per_page=8&page=' . $tab_activity_page . '&object=profile')) :
			while (bp_activities()) : bp_the_activity();
				locate_template(array('buddypress/activity/entry-shortcode.php'), true, false);
			endwhile;
		endif;
	} elseif ($tab_activity_type == 3) {


		if (is_user_logged_in()) {

			$friends = friends_get_friend_user_ids(bp_loggedin_user_id());
			$friends_ids = implode(',', (array) $friends);
			$friends_ids =  $friends_ids;

			if (bp_has_activities(bp_ajax_querystring('activity') . '&per_page=8&page=' . $tab_activity_page . '&user_id=' . $friends_ids)) :
				while (bp_activities()) : bp_the_activity();
					locate_template(array('buddypress/activity/entry-shortcode.php'), true, false);
				endwhile;
			endif;
		} else {
			echo "<span class='shortcode-activity-info'>";
			echo  __('You must login first to see activity of your friends.', 'onecommunity-shortcodes');
			echo "</span>";
		}
	} elseif ($tab_activity_type == 4) {

		if (bp_has_activities(bp_ajax_querystring('activity') . '&per_page=8&page=' . $tab_activity_page . '&action=new_forum_topic')) :
			while (bp_activities()) : bp_the_activity();
				locate_template(array('buddypress/activity/entry-shortcode.php'), true, false);
			endwhile;
		endif;
	} elseif ($tab_activity_type == 5) {

		if (bp_has_activities(bp_ajax_querystring('activity') . 'per_page=8&page=' . $tab_activity_page . '&action=new_forum_post')) :
			while (bp_activities()) : bp_the_activity();
				locate_template(array('buddypress/activity/entry-shortcode.php'), true, false);
			endwhile;
		endif;
	} elseif ($tab_activity_type == 6) {

		if (bp_has_activities(bp_ajax_querystring('activity') . '&per_page=8&page=' . $tab_activity_page . '&action=new_blog_comment')) :
			while (bp_activities()) : bp_the_activity();
				locate_template(array('buddypress/activity/entry-shortcode.php'), true, false);
			endwhile;
		endif;
	}

	wp_die();
}
add_action('wp_ajax_nopriv_onecommunity_activity_load', 'onecommunity_activity_load');
add_action('wp_ajax_onecommunity_activity_load', 'onecommunity_activity_load');

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function onecommunity_bp_groups_listing($atts, $content = null)
{
	extract(shortcode_atts(array(
		"number_of_groups" => '8',
		"col" => '4'
	), $atts));

	if (function_exists('bp_is_active')) {
		ob_start();
		$nonce = wp_create_nonce("onecommunity_bp_groups_listing");
	?>


		<div class="shortcode-bp-groups-tabs-container col-<?php echo $col; ?>">

			<h4><?php _e('Community Groups', 'onecommunity-shortcodes'); ?></h4>

			<div class="object-nav-container">
				<div id="object-nav">
					<ul class="tabs-nav">
						<li class="nav-four" data-tab="newest" data-tab-per-page="<?php echo $number_of_groups; ?>" data-tab-page="1" data-nonce="<?php echo $nonce; ?>"><?php _e('Newest', 'onecommunity-shortcodes'); ?></li>
						<li class="nav-three" data-tab="alphabetical" data-tab-per-page="<?php echo $number_of_groups; ?>" data-tab-page="1" data-nonce="<?php echo $nonce; ?>"><?php _e('Alphabetical', 'onecommunity-shortcodes'); ?></li>
						<li class="nav-two" data-tab="active" data-tab-per-page="<?php echo $number_of_groups; ?>" data-tab-page="1" data-nonce="<?php echo $nonce; ?>"><?php _e('Active', 'onecommunity-shortcodes'); ?></li>
						<li class="nav-one current" data-tab="popular" data-tab-per-page="<?php echo $number_of_groups; ?>" data-tab-page="1" data-nonce="<?php echo $nonce; ?>"><?php _e('Popular', 'onecommunity-shortcodes'); ?></li>
					</ul>
				</div>
			</div>

			<div class="clear"></div>

			<div class="list-wrap">

				<!-- GROUPS LOOP -->
				<?php if (bp_has_groups('type=popular&page=1&per_page=' . $number_of_groups . '')) : ?>

					<ul>
						<?php while (bp_groups()) : bp_the_group(); ?>
							<li <?php bp_group_class(); ?>>
								<div class="group-box">
									<div class="group-box-image-container">
										<a class="group-box-image" href="<?php bp_group_permalink() ?>"><?php bp_group_avatar('type=full') ?></a>
									</div>
									<div class="group-box-bottom">
										<h6 class="group-box-title"><a href="<?php bp_group_permalink() ?>"><?php $grouptitle = bp_get_group_name();
																											$getlength = strlen($grouptitle);
																											$thelength = 20;
																											echo mb_substr($grouptitle, 0, $thelength, 'UTF-8');
																											if ($getlength > $thelength) echo "..."; ?></a></h6>
										<div class="group-box-details">

											<span class="activity">
												<?php _e('Active', 'onecommunity-shortcodes'); ?>
												<?php
												$print = bp_get_group_last_active(0, array('relative' => true));
												$print = str_replace("ago", "", $print);
												$printArray = explode(",", $print);
												$print = $printArray[0];
												echo $print;
												?> <?php _e('ago', 'onecommunity-shortcodes') ?></span>

											<span class="group-box-details-members"><?php bp_group_member_count(); ?></span>
										</div>
									</div>
									<!--group-box-bottom-->
								</div>
								<!--group-box ends-->
							</li>
						<?php endwhile; ?>
					</ul>

					<div class="clear"></div>

					<div class="load-more-groups" data-tab="popular" data-tab-per-page="<?php echo $number_of_groups; ?>" data-tab-page="1" data-nonce="<?php echo $nonce; ?>"><span><?php _e('Load More', 'onecommunity-shortcodes'); ?></span></div>

					<?php do_action('bp_after_groups_loop') ?>

				<?php else : ?>
					<div id="message" class="info" style="width:50%">
						<p><?php _e('There were no groups found.', 'buddypress') ?></p>
					</div>

					<style type="text/css">
						.load-more-groups {
							display: none;
						}
					</style>

				<?php endif; ?>
				<!-- GROUPS LOOP END -->

			</div> <!-- List Wrap -->
		</div> <!-- shortcode-bp-groups-tabs-container -->

		<?php do_action('onecommunity_after_groups_tabs') ?>

		<div class="clear"></div>
	<?php } else {
		echo "Buddypress plugin is inactive";
	}

	$shortcode_content = ob_get_clean();
	return $shortcode_content;
}

add_shortcode("onecommunity-bp-groups-listing", "onecommunity_bp_groups_listing");




function onecommunity_bp_groups_listing_load()
{

	$groups_type = esc_html($_POST['groups_type']);
	$per_page = esc_html($_POST['per_page']);
	$page = esc_html($_POST['page']);
	$nonce = esc_html($_POST['nonce']);

	if (!wp_verify_nonce($_REQUEST['nonce'], "onecommunity_bp_groups_listing")) {
		exit("Illegal request");
	}

	if (bp_has_groups('type=' . $groups_type . '&page=' . $page . '&per_page=' . $per_page . '')) : ?>

		<?php while (bp_groups()) : bp_the_group(); ?>
			<li <?php bp_group_class(); ?>>
				<div class="group-box">
					<div class="group-box-image-container">
						<a class="group-box-image" href="<?php bp_group_permalink() ?>"><?php bp_group_avatar('type=full') ?></a>
					</div>
					<div class="group-box-bottom">
						<h6 class="group-box-title"><a href="<?php bp_group_permalink() ?>"><?php $grouptitle = bp_get_group_name();
																							$getlength = strlen($grouptitle);
																							$thelength = 20;
																							echo mb_substr($grouptitle, 0, $thelength, 'UTF-8');
																							if ($getlength > $thelength) echo "..."; ?></a></h6>
						<div class="group-box-details">
							<div class="group-box-details">
								<span class="activity">
									<?php _e('Active', 'onecommunity-shortcodes'); ?>
									<?php
									$print = bp_get_group_last_active(0, array('relative' => true));
									$print = str_replace("ago", "", $print);
									$printArray = explode(",", $print);
									$print = $printArray[0];
									echo $print;
									?> <?php _e('ago', 'onecommunity-shortcodes') ?>
								</span>
								<span class="group-box-details-members"><?php bp_group_member_count(); ?></span></div>
						</div>
					</div>
					<!--group-box ends-->
			</li>
		<?php endwhile; ?>

		<?php do_action('bp_after_groups_loop') ?>

	<?php else : ?>
		<div id="message" class="info" style="width:50%">
			<p><?php _e('There were no groups found.', 'buddypress') ?></p>
		</div>
		<style type="text/css">
			.load-more-groups {
				display: none;
			}
		</style>
	<?php endif;

	wp_die();
}
add_action('wp_ajax_nopriv_onecommunity_bp_groups_listing_load', 'onecommunity_bp_groups_listing_load');
add_action('wp_ajax_onecommunity_bp_groups_listing_load', 'onecommunity_bp_groups_listing_load');

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function onecommunity_sidenav($atts, $content = null)
{
	extract(shortcode_atts(array(), $atts));
	ob_start();
	$nonce = wp_create_nonce("onecommunity_sidenav");
	$time_start = microtime(true);
	?>

	<div id="sidenav-members">

		<a id="sidenav-button" href="javascript: void(0)"></a>

		<a id="sidenav-drop-down-menu" href="javascript: void(0)"></a>


		<?php if (is_user_logged_in()) : ?>

			<div class="clear"></div>

			<div class="sidenav-members-tabs">


				<ul id="sidenav-members-nav">
					<li data-tab="active" data-nonce="<?php echo $nonce ?>" class="tab-active current"><?php _e('Active', 'onecommunity-shortcodes'); ?></li>
					<li data-tab="active_friends" data-nonce="<?php echo $nonce ?>" class="tab-active-friends"><?php _e('Friends', 'onecommunity-shortcodes'); ?></li>
					<li data-tab="newest" data-nonce="<?php echo $nonce ?>" class="tab-newest"><?php _e('New', 'onecommunity-shortcodes'); ?></li>
					<li data-tab="online" data-nonce="<?php echo $nonce ?>" class="tab-online"><?php _e('Online', 'onecommunity-shortcodes'); ?></li>
				</ul>

				<div class="tab-members-content">
					<div class="tab-members-content-wrap fadein">
						<?php if (bp_has_members('type=active&max=14&user_id=' . bp_loggedin_user_id())) : ?>
							<?php while (bp_members()) : bp_the_member(); ?>
								<a href="<?php bp_member_permalink() ?>" title="<?php bp_member_name(); ?>" class="sidenav-member">
									<?php bp_member_avatar('type=thumb&width=60&height=60') ?>
									<span class="sidenav-member-online"></span>
									<span class="sidenav-member-name"><?php bp_member_name(); ?></span>
									<span class="sidenav-member-activity"><?php bp_member_last_active(); ?></span>
								</a>
							<?php endwhile; ?>
						<?php endif; ?>
					</div>
				</div>

			</div><!-- sidenav-members-tabs -->

		<?php
			echo '<!-- Sidenav execution time (seconds): ' . (microtime(true) - $time_start) . ' -->';
		else : ?>

			<div class="clear"></div>

			<div class="sidenav-members-tabs">

				<ul id="sidenav-members-nav">
					<li data-tab="active" data-nonce="<?php echo $nonce ?>" class="tab-active current"><?php _e('Active', 'onecommunity-shortcodes'); ?></li>
					<li data-tab="newest" data-nonce="<?php echo $nonce ?>" class="tab-newest"><?php _e('New', 'onecommunity-shortcodes'); ?></li>
					<li data-tab="online" data-nonce="<?php echo $nonce ?>" class="tab-online"><?php _e('Online', 'onecommunity-shortcodes'); ?></li>
				</ul>

				<div class="tab-members-content">
					<div class="tab-members-content-wrap fadein">
						<?php
						if (bp_has_members('type=active&max=14')) :
							while (bp_members()) : bp_the_member(); ?>
								<a href="<?php bp_member_permalink() ?>" title="<?php bp_member_name(); ?>" class="sidenav-member">
									<?php bp_member_avatar('type=thumb&width=60&height=60') ?>
									<span class="sidenav-member-online"></span>
									<span class="sidenav-member-name"><?php bp_member_name(); ?></span>
									<span class="sidenav-member-activity"><?php bp_member_last_active(); ?></span>
								</a>
						<?php endwhile;
						endif; ?>
					</div>
				</div>
			</div><!-- sidenav-members-tabs -->

		<?php endif; ?>

		<div class="sidenav-members-bottom">

			<?php if (get_theme_mod('onecommunity_sidenav_featured_member_enable', true) == true) {

				if (shortcode_exists('onecommunity-gamipress-leaderboard')) {
					echo '<div class="best-user">';
					echo do_shortcode('[onecommunity-gamipress-leaderboard limit="1" name="points" layout="sidenav" type="_gamipress_points_points"]');
					echo '</div>';
				}
			} ?>

			<?php if (get_theme_mod('onecommunity_dark_mode_enable', true) == true) { ?>

				<div id="dark-mode-container">
					<span id="dark-mode"><svg height="448pt" viewBox="-12 0 448 448.04455" width="448pt" xmlns="http://www.w3.org/2000/svg">
							<path d="m224.023438 448.03125c85.714843.902344 164.011718-48.488281 200.117187-126.230469-22.722656 9.914063-47.332031 14.769531-72.117187 14.230469-97.15625-.109375-175.890626-78.84375-176-176 .972656-65.71875 37.234374-125.832031 94.910156-157.351562-15.554688-1.980469-31.230469-2.867188-46.910156-2.648438-123.714844 0-224.0000005 100.289062-224.0000005 224 0 123.714844 100.2851565 224 224.0000005 224zm0 0" /></svg></span>
				</div>

			<?php } ?>

		</div><!-- sidenav-members-bottom -->

	</div><!-- sidenav-members -->

	<?php
	echo '<!-- Execution time (seconds): ' . (microtime(true) - $time_start) . ' -->';
	$shortcode_content = ob_get_clean();
	return $shortcode_content;
}
add_shortcode("onecommunity-sidenav", "onecommunity_sidenav");




function onecommunity_sidenav_load()
{
	$members_loop_type = esc_html($_POST['members_loop_type']);
	$nonce = wp_create_nonce("onecommunity_sidenav");
	$nonce = esc_html($_POST['nonce']);

	if (!wp_verify_nonce($_REQUEST['nonce'], "onecommunity_sidenav")) {
		exit("Illegal request");
	}

	if ($members_loop_type == 'active') {

		if (bp_has_members('type=active&max=12')) :
			while (bp_members()) : bp_the_member(); ?>
				<a href="<?php bp_member_permalink() ?>" title="<?php bp_member_name(); ?>" class="sidenav-member">
					<?php bp_member_avatar('type=thumb&width=60&height=60') ?>
					<span class="sidenav-member-online"></span>
					<span class="sidenav-member-name"><?php bp_member_name(); ?></span>
					<span class="sidenav-member-activity"><?php bp_member_last_active(); ?></span>
				</a>
			<?php endwhile;
		endif;
	} elseif ($members_loop_type == 'newest') {

		if (bp_has_members('type=newest&max=12')) :
			while (bp_members()) : bp_the_member(); ?>
				<a href="<?php bp_member_permalink() ?>" title="<?php bp_member_name(); ?>" class="sidenav-member">
					<?php bp_member_avatar('type=thumb&width=60&height=60') ?>
					<span class="sidenav-member-online"></span>
					<span class="sidenav-member-name"><?php bp_member_name(); ?></span>
					<span class="sidenav-member-activity"><?php bp_member_last_active(); ?></span>
				</a>
			<?php endwhile;
		endif;
	} elseif ($members_loop_type == 'online') {

		if (bp_has_members('type=online&max=12')) :
			while (bp_members()) : bp_the_member(); ?>
				<a href="<?php bp_member_permalink() ?>" title="<?php bp_member_name(); ?>" class="sidenav-member">
					<?php bp_member_avatar('type=thumb&width=60&height=60') ?>
					<span class="sidenav-member-online"></span>
					<span class="sidenav-member-name"><?php bp_member_name(); ?></span>
					<span class="sidenav-member-activity"><?php bp_member_last_active(); ?></span>
				</a>
			<?php endwhile;
		endif;
	} elseif ($members_loop_type == 'active_friends') {

		if (bp_has_members('type=active&per_page=12&user_id=' . bp_loggedin_user_id())) :
			while (bp_members()) : bp_the_member(); ?>
				<a href="<?php bp_member_permalink() ?>" title="<?php bp_member_name(); ?>" class="sidenav-member">
					<?php bp_member_avatar('type=thumb&width=60&height=60') ?>
					<span class="sidenav-member-online"></span>
					<span class="sidenav-member-name"><?php bp_member_name(); ?></span>
					<span class="sidenav-member-activity"><?php bp_member_last_active(); ?></span>
				</a>
<?php endwhile;
		endif;
	}

	wp_die();
}
add_action('wp_ajax_nopriv_onecommunity_sidenav_load', 'onecommunity_sidenav_load');
add_action('wp_ajax_onecommunity_sidenav_load', 'onecommunity_sidenav_load');
