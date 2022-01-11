<li class="podcast-wrapper">
		<a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>" rel="author">
			<div class="podcast-avatar"><?php
										echo get_avatar(get_the_author_meta('user_email'), 48);
										?></div>
		</a>
		<span class="podcast-author"><?php echo get_the_author(); ?></span> posted in

		<span class="podcast-category"><?php the_category(', ') ?></span>
		<span class="podcast-time"><?php printf(_x('%s ago', '%s = human-readable time difference', 'onecommunity'), human_time_diff(get_the_time('U'), current_time('timestamp'))); ?></span>

		<div class="podcast-meta">
			<img src="<?php echo $image_src; ?>" />
			<span class="podcast-title">
				<a href="<?php the_permalink(); ?>"><?php $thetitle = get_the_title();
													$getlength = strlen($thetitle);
													$thelength = 57;
													echo mb_substr($thetitle, 0, $thelength, 'UTF-8');
													if ($getlength > $thelength) echo "..."; ?></a>
			</span>
			<div class="podcast-player"><audio controls src="<?php echo $meta_parts['url']; ?>">
				Your browser does not support the
				<code>audio</code> element.
			</audio>
			</div>
			<div class="clear"></div>

		</div>

		<?php if (has_post_thumbnail()) { ?>
			<div class="featured-image">
				<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('post-thumbnail'); ?></a>
			</div>
		<?php } ?>
		<div class="clear"></div>	
</li>