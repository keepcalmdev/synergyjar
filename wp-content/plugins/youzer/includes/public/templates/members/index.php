<?php

/**
 * BuddyPress - Members
 *
 */
/**
 * Fires at the top of the members directory template file.
 *
 * @since 1.5.0
 */
do_action('bp_before_directory_members_page'); ?>
<div id="youzer">

	<div id="<?php echo apply_filters('yz_members_template_id', 'yz-bp'); ?>" class="youzer <?php echo yz_members_directory_class() ?>">

		<main class="yz-page-main-content">

			<div id="yz-members-directory">

				<?php

				do_shortcode('[bps_directory]');

			

				/**
				 * Fires before the display of the members.
				 *
				 * @since 1.1.0
				 */
				do_action('bp_before_directory_members'); ?>

				<?php

				/**
				 * Fires before the display of the members content.
				 *
				 * @since 1.1.0
				 */
				do_action('bp_before_directory_members_content'); ?>

				<?php
				/**
				 * Fires before the display of the members list tabs.
				 *
				 * @since 1.8.0
				 */
				do_action('bp_before_directory_members_tabs'); ?>

				<?php if (yz_display_md_filter_bar()) : ?>

					<div class="yz-mobile-nav">
						<div id="directory-show-menu" class="yz-mobile-nav-item">
							<div class="yz-mobile-nav-container"><i class="fas fa-bars"></i><a><?php _e('Menu', 'youzer'); ?></a></div>
						</div>
						<div id="directory-show-search" class="yz-mobile-nav-item">
							<div class="yz-mobile-nav-container"><i class="fas fa-search"></i><a><?php _e('Search', 'youzer'); ?></a></div>
						</div>
						<div id="directory-show-filter" class="yz-mobile-nav-item">
							<div class="yz-mobile-nav-container"><i class="fas fa-sliders-h"></i><a><?php _e('Filter', 'youzer'); ?></a></div>
						</div>
					</div>

					

					<div class="yz-directory-filter">
						<div class="item-list-tabs" aria-label="<?php esc_attr_e('Members directory main navigation', 'youzer'); ?>" role="navigation">
							<ul>
								<li class="selected" id="members-all"><a href="<?php bp_members_directory_permalink(); ?>"><?php printf(__('All Members %s', 'youzer'), '<span>' . bp_get_total_member_count() . '</span>'); ?></a>
								</li>

								<?php if (is_user_logged_in() && bp_is_active('friends') && bp_get_total_friend_count(bp_loggedin_user_id())) : ?>
									<li id="members-personal"><a href="<?php echo esc_url(bp_loggedin_user_domain() . bp_get_friends_slug() . '/my-friends/'); ?>"><?php printf(__('My Friends %s', 'youzer'), '<span>' . bp_get_total_friend_count(bp_loggedin_user_id()) . '</span>'); ?></a>
									</li>
								<?php endif; ?>

								<?php

								/**
								 * Fires inside the members directory member types.
								 *
								 * @since 1.2.0
								 */
								do_action('bp_members_directory_member_types'); ?>

							</ul>
						</div><!-- .item-list-tabs -->

						<div class="item-list-tabs" id="subnav" aria-label="<?php esc_attr_e('Members directory secondary navigation', 'youzer'); ?>" role="navigation">
							<ul>
								<?php

								/**
								 * Fires inside the members directory member sub-types.
								 *
								 * @since 1.5.0
								 */
								do_action('bp_members_directory_member_sub_types'); ?>

								<li id="members-order-select" class="last filter">
									<label for="members-order-by"><?php _e('Order By:', 'youzer'); ?></label>
									<select id="members-order-by">
										<option value="active"><?php _e('Last Active', 'youzer'); ?></option>
										<option value="newest"><?php _e('Newest Registered', 'youzer'); ?></option>

										<?php if (bp_is_active('xprofile')) : ?>
											<option value="alphabetical"><?php _e('Alphabetical', 'youzer'); ?></option>
										<?php endif; ?>

										<?php

										/**
										 * Fires inside the members directory member order options.
										 *
										 * @since 1.2.0
										 */
										do_action('bp_members_directory_order_options'); ?>
									</select>
								</li>
								<?php if (apply_filters('yz_display_members_directory_search_bar', true)) : ?>
									<li id="yz-directory-search-box">
										<div id="members-dir-search" class="dir-search" role="search">
											<?php bp_directory_members_search_form(); ?>
										</div><!-- #members-dir-search -->
									</li>
								<?php endif; ?>
							</ul>
						</div>
					</div>

					<?php

					if (isset($_REQUEST['filter'])) {


						if (pmpro_hasMembershipLevel('2')) { ?>

							<div class="yz-directory-filter mobile">
								<div class="owner-portal-section owner-owner"><a href="/community/groups/?filter=ownertoowner&groups_search=topics">Owner to Owner</a></div>
								<div class="owner-portal-section subject-expert active"><a href="/community/members/?filter=subjectmatter">Subject Matter Expert
										Network</a></div>
								<div class="owner-portal-section rate-consultant"><a href="/community/members/?filter=rateconsultant">Consultants
										Performance Rating</a></div>
								<div class="description">

									<?php
									if ($_REQUEST['filter'] == 'subjectmatter') {
										echo youzer_modal(
											array(
												'modal_title' => 'Subject Matter Expert Portal',
												'subjectmatter' => '<p>Looking for a Subject Matter Expert (SME) in any specific practice area? This database was created for owners to quickly	identify technical resources and experts. The search options will help filter by subject and/or geography. You may contact these SME’s through the options available.</p><p>Are you an SME and want to be listed as one within this network? Click here to complete the form and express your interest in joining our SME network.</p>',
												'modal_name'  => 'subjectmatter',
											)
										);
									}
									if ($_REQUEST['filter'] == 'rateconsultant') {
										echo youzer_modal(
											array(
												'modal_title' => 'Consultants Performance Rating',
												'subjectmatter' => '<p>Owners need a holistic view of the firms and/or consultants they are about to engage. Sometimes, owners are not privy to previous performance evaluations from sister agencies or other owners in the same geography or multiple geographies. Want to know more? pick your firm or consultant from the menu below.</p>
						<p>For the benefit of other owners, feel free to provide your thoughts where we don’t have any previous performance records.</p>
						<p>This tool is secure and only available to owners to view and use.</p>',
												'modal_name'  => 'rateconsultant',
											)
										);
									}
									?>

								</div>
							</div>

						<?php }

						if ($_REQUEST['filter'] == 'subjectmatter') {
						?>
							<script>
								jQuery(function() {
									jQuery('#field_6_wrap').css("display", "none");
									jQuery('#field_7_wrap').css("display", "none");
									jQuery('#field_10_wrap').css("display", "none");
									jQuery('#field_11_wrap').css("display", "none");
									jQuery('#field_301_wrap').css("display", "none");
									jQuery('#mega-menu-item-760 a').css("color", "#62bafb");
									jQuery('#field_562_match_any_wrap').css("display", "inline");
								});
							</script>
						<?php
						}
						if ($_REQUEST['filter'] == 'rateconsultant') {
						?>
							<script>
								jQuery(function() {
									jQuery('.yz-directory-filter-xprofile').css("display", "none");
									//jQuery('#field_11_wrap').css("display", "none");
									//jQuery('#field_301_wrap').css("display", "none");
									jQuery('#d3map').css("display", "none");
									jQuery('#mega-menu-item-760 a').css("color", "#62bafb");
									jQuery('.subject-expert').removeClass("active");
									jQuery('.rate-consultant').addClass("active");

								});
							</script>
					<?php
						}
					} ?>
				<?php endif; ?>
				<?php do_action('synergyjar-membmap'); ?>
				<form action="" method="post" id="members-directory-form" class="dir-form">

					<div id="members-dir-list" class="members dir-list">
						<?php bp_get_template_part('members/members-loop'); ?>
					</div><!-- #members-dir-list -->

					<?php

					/**
					 * Fires and displays the members content.
					 *
					 * @since 1.1.0
					 */
					do_action('bp_directory_members_content'); ?>

					<?php wp_nonce_field('directory_members', '_wpnonce-member-filter'); ?>

					<?php

					/**
					 * Fires after the display of the members content.
					 *
					 * @since 1.1.0
					 */
					do_action('bp_after_directory_members_content'); ?>

				</form><!-- #members-directory-form -->

				<?php

				/**
				 * Fires after the display of the members.
				 *
				 * @since 1.1.0
				 */
				do_action('bp_after_directory_members'); ?>

			</div><!-- #buddypress -->
			<?php echo adrotate_group(3); ?>
		</main>

	</div>

</div>

<?php

/**
 * Fires at the bottom of the members directory template file.
 *
 * @since 1.5.0
 */
do_action('bp_after_directory_members_page');
