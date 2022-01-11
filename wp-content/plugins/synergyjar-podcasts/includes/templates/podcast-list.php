<main id="content" class="podcast-content">

	<?php $nonce = wp_create_nonce("sj_podcast_1"); ?>



	<ul class="podcast-1 podcast-1-sidebar list-unstyled podcast-list">

		<?php
		$temp = $wp_query;
		$wp_query = null;
		$wp_query = new WP_Query();
		$wp_query->query('posts_per_page=6&category__in=39');

		while ( $wp_query->have_posts()) : $wp_query->the_post();

			$settings = get_option( 'powerpress_feed_' . get_the_author_meta( 'ID' ) );

			$slug = sanitize_title( $settings['value'] );

			if ( $settings != false ) {
				$meta_parts = powerpress_get_enclosure_data( get_the_ID(), $slug );
				$image_src = $meta_parts['itunes_image'] != null ? $meta_parts['itunes_image'] : $meta_parts['image'];
			}else{
				$image_src = $settings['itunes_image'];
			};
			//echo '<script>console.log('.json_encode( powerpress_get_enclosure_data( get_the_ID(), $slug ) ).');</script>';

			include 'wp-content/plugins/synergyjar-podcasts/includes/templates/podcast.php';

		endwhile; ?>


	</ul>

	<!-- blog-classic -->
	<?php $wp_query = null;
	$wp_query = $temp; ?>

	<div class="load-more-container">
		<span id="load-more-podcasts-1" class="show" data-posts-type="1" data-tab-page="1" data-category="39" data-nonce=<?php echo $nonce; ?>><?php esc_attr_e('Load More', 'onecommunity'); ?></span>
	</div>	

	<?php include 'add-feed.php'; ?>

</main><!-- content -->



<aside id="sidebar">

	<div class="sidebar-tools podcast-filters">
		<h3 class="widget-title">Podcast Filters</h3>
		<ul class="sidebar-ul">
			<?php do_shortcode('[podcast_filters]'); ?>
		</ul>
	</div>
	<div class="sidebar-tools podcast-recorder">
		<h3 class="widget-title">Record a Podcast</h3>
		<div class="record-button">Start</div>
	</div>

</aside>
<!--sidebar ends-->
</section><!-- wrapper -->
<!--blog-post-->
