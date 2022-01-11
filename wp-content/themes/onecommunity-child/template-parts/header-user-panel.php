<div class="user-top logged-in">

	<?php

	if (pmpro_hasMembershipLevel('2') || pmpro_hasMembershipLevel('1')) {

	$member_class = pmpro_hasMembershipLevel('2') ? "level-2" : "level-1";

	}

	?>
		<a class="top-bar-avatar <?php echo $member_class ?>" href="<?php echo bp_loggedin_user_domain() ?>">
			<?php bp_loggedin_user_avatar('type=thumb&width=32&height=32') ?>
		</a>
		<!-- <span class="top-bar-username"><?php //esc_attr_e('Hello', 'onecommunity'); 
											?><br> -->
		<a href="<?php
					echo bp_loggedin_user_domain() ?>"><?php
										$theusername = bp_core_get_user_displayname(bp_loggedin_user_id());
										$getlength = strlen($theusername);
										$thelength = 15;
										//echo mb_substr($theusername, 0, $thelength, 'UTF-8'); 
										//if ($getlength > $thelength) echo "..."; 
										?>
		</a>
		<!-- </span> -->
	
	

</div>

<div class="user-top-menu">
	<div id="user-top-menu-expander"></div>

	<div class="user-top-menu-container">
		<div class="arrow"></div>
		<ul>
			
			<li><a href="<?php echo bp_loggedin_user_domain(); ?><?php esc_attr_e('settings', 'onecommunity'); ?>"><?php esc_attr_e('My Settings', 'onecommunity'); ?></a>
			</li>
			<li><a href="/membership-account/">My Account</a></li>
			<li><b><a href="<?php echo wp_logout_url(home_url()) ?>"><?php esc_attr_e('Log Out', 'onecommunity'); ?></a></b>
			</li>
		</ul>
	</div>

</div>

<!-- user-top logged-in -->