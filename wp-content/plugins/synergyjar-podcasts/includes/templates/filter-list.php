

	<?php 

	
	$nonce = wp_create_nonce("sj_podcast_1"); ?>

	

	<ul class="podcast-1 podcast-1-sidebar list-unstyled">

		<?php

		$temp = $wp_query;
		$wp_query = null;
		$wp_query = new WP_Query();
		$wp_query->query('posts_per_page=6&category__in=' . $_POST['id']);

		while ($wp_query->have_posts()) : $wp_query->the_post();
			
			$meta_parts = $get_meta_parts->get_channel_art(get_the_ID());
			$image_src = $meta_parts['itunes_image'] != null ? $meta_parts['itunes_image'] : $meta_parts['image'];

			include( 'podcast.php' );

		endwhile; ?>
		

	</ul>

	<!-- blog-classic -->
	<?php $wp_query = null; $wp_query = $temp;?>

	<div class="load-more-container">
		<span id="load-more-podcasts-1" class="show" data-posts-type="1" data-tab-page="1"><?php esc_attr_e('Load More', 'onecommunity'); ?></span>
	</div>

<!-- content -->




<!--sidebar ends-->
<!-- wrapper -->
<!--blog-post-->