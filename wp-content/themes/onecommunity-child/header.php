<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php if (is_singular() && pings_open(get_queried_object())) : ?>
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
	<?php endif; ?>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php
	if (get_theme_mod('onecommunity_preloader_enable', true) === true) {
		echo '<div id="loader-wrapper"></div>';
	}
	?>
	<header id="main">

		<div class="header-top">
			<div class="header-wrapper">
				<div class="logo">
					<?php
					if (get_theme_mod('onecommunity_dark_mode_enable', true) == true) {
						if (get_theme_mod('custom_logo')) { ?>
							<?php the_custom_logo(); ?>
							<a href='<?php echo esc_url(home_url('/')); ?>' class='dark' title='<?php echo esc_attr(get_bloginfo('name', 'display')); ?>' rel='home'><img src="<?php echo get_theme_mod('onecommunity_dark_mode_logo') ?>"></a>
						<?php } else { ?>
							<a href="<?php echo home_url(); ?>" class='light' title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>"><img src="<?php echo esc_attr(get_bloginfo('template_directory', 'display')); ?>/img/logo.png" alt="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" /></a>
							<a href="<?php echo home_url(); ?>" class='dark' title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>"><img src="<?php echo esc_attr(get_bloginfo('template_directory', 'display')); ?>/img/logo-dark-mode.png" alt="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" /></a>
						<?php }
					} else {
						if (get_theme_mod('custom_logo')) { ?>
							<?php the_custom_logo(); ?>
						<?php } else { ?>
							<a href="<?php echo home_url(); ?>" class='light' title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>"><img src="<?php echo esc_attr(get_bloginfo('template_directory', 'display')); ?>/img/logo.png" alt="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" /></a>
					<?php }
					}
					?>
				</div>

				<div id="header-top-right" class="header-top-right">
					<div class="header-menu-toggle"></div>
					<?php
					if (is_user_logged_in() && function_exists('bp_is_active')) {
						get_template_part('template-parts/header-user', 'panel');
						//get_template_part('template-parts/header', 'notifications');
						if (bp_is_active('messages')) {
							//get_template_part('template-parts/header', 'messages');
						}
					}
					?>

					<?php if (!is_user_logged_in()) { ?>


						<!-- <a href="<?php //echo home_url(); 
										?>/membership-account/membership-levels/"
					class="header-top-signin unmobile tada">
					<?php //esc_attr_e('Register', 'onecommunity'); 
					?>
				</a>
				<a href="<?php //echo home_url(); 
							?>/membership-account/membership-levels/"
					class="header-top-signin mobile tada">
					<?php //esc_attr_e('R', 'onecommunity'); 
					?>
				</a>

				-->
						<?php if (is_front_page() || is_page_template(array('frontpage-2.php', 'frontpage-page-builder.php'))) { ?>
							<a class="header-top-login unmobile header-top-login-jump login-popup-action" href="/wp-login.php"><img src="<?php echo get_stylesheet_directory_uri() . '/img/user.svg' ?>" class="user-avatar" /></a>
							<!-- <a
					class="header-top-login mobile header-top-login-jump login-popup-action"><?php //esc_attr_e('L', 'onecommunity'); 
																								?></a> -->
						<?php } else { ?>
							<a class="header-top-login unmobile header-top-login-jump login-popup-action" href="/wp-login.php"><img src="<?php echo get_stylesheet_directory_uri() . '/img/user.svg' ?>" class="user-avatar" /></a>
							<!-- <a
					class="header-top-login unmobile login-popup-action"><?php //esc_attr_e('Login', 'onecommunity'); 
																			?></a>
				<a class="header-top-login mobile login-popup-action"><?php //esc_attr_e('L', 'onecommunity'); 
																		?></a> -->
						<?php } ?>

					<?php } ?>


				</div>
			</div>

			<!-- header-top-right -->
			<?php if (has_nav_menu('header-menu') || has_nav_menu('header-menu-public-owner') || has_nav_menu('header-menu-private-agency')) {
				if (!is_front_page() && is_user_logged_in()) {
					$youzer_class = '';
				} else {
					$youzer_class = '';
				}
			?>
				<div id="header-menu-container" class="<?php echo $youzer_class ?>">
					<?php

					global $current_user;

					// Get the current user ID and their level ID for the PMPro Approvals meta.
					$user_id = $current_user->ID;
					$level = pmpro_getMembershipLevelForUser($user_id);
					$level_id = $level->id;

					//get the user meta.
					$approval_status = get_user_meta($user_id, 'pmpro_approval_' . $level_id, true);

					//check the user meta.
					if ( $approval_status['status'] !== 'pending' ) {
						//show content here, assume they are approved or don't require approval if the user doesn't have pending or denied. 
						if (pmpro_hasMembershipLevel('1')) {
							wp_nav_menu(
								array(
									'menu' => '27',
									'theme_location' => 'header-menu-private-agency',
									'container' => false,
									'menu_class' => 'header-menu',
									'echo' => true,
									'link_before' => '',
									'link_after' => '',
									'walker' => new Child_Wrap(),
									'depth' => 0,
								)
							);
						}
						if (pmpro_hasMembershipLevel('2')) {
							wp_nav_menu(
								array(
									'menu' => '28',
									'theme_location' => 'header-menu-public-owner',
									'container' => false,
									'menu_class' => 'header-menu',
									'echo' => true,
									'link_before' => '',
									'link_after' => '',
									'walker' => new Child_Wrap(),
									'depth' => 0,
								)
							);
						}
						
					} elseif ( $approval_status['status'] === 'pending' ){
						
						//show a restricted message for users.
						wp_nav_menu(
							array(
								'menu' => '28',
								'theme_location' => 'header-menu-public-owner',
								'container' => false,
								'menu_class' => 'header-menu',
								'echo' => true,
								'link_before' => '',
								'link_after' => '',
								'walker' => new Child_Wrap(),
								'depth' => 0,
							)
						);
					}

					if (!is_user_logged_in()) {

						wp_nav_menu(
							array(
								'menu' => '1',
								'theme_location' => 'header-menu',
								'container' => false,
								'menu_class' => 'header-menu',
								'echo' => true,
								'link_before' => '',
								'link_after' => '',
								'walker' => new Child_Wrap(),
								'depth' => 0,
							)
						);
					}
					?>
				</div><!-- header-mini-menu-container -->

			<?php } ?>
			<!-- header-top -->
		</div>


	</header>

	

	<div class="container">