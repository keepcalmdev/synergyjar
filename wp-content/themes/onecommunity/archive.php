<?php get_header(); ?>

<?php if ( have_posts() ) : ?>


<section class="wrapper">

<main id="content">

	<div class="breadcrumbs">
	<?php esc_attr_e('You are here:', 'onecommunity'); ?> <a href="<?php echo home_url(); ?>"><?php esc_attr_e('Home', 'onecommunity'); ?></a> / <span class="current"><?php echo onecommunity_get_the_archive_title(); ?></span>
	</div>

	<h1 class="page-title half"><?php echo onecommunity_get_the_archive_title(); ?></h1>

	<?php $nonce = wp_create_nonce("onecommunity_blog_archive_tabs"); ?>

	<div id="item-nav">

	<div id="object-nav" class="item-list-tabs archive-tabs" role="navigation">
			<ul>
				<?php 
				$queried_object = get_queried_object();
				if ($queried_object->taxonomy == 'category') {
					$taxonomy = 'cat';
				} elseif ($queried_object->taxonomy == 'post_tag') {
					$taxonomy = 'tag_id';
				} else {
					echo "Wrong taxonomy parameter.";
				}
				?>
				<?php if (function_exists('wp_ulike_get_post_likes')) { ?><li data-posts-type="2" data-taxonomy="<?php echo esc_attr( $taxonomy ); ?>" data-tab-page="1" data-term-id="<?php echo esc_attr( $queried_object->term_id ); ?>"><?php esc_attr_e('Most liked', 'onecommunity'); ?></li><?php } ?>
				<li data-posts-type="3" data-taxonomy="<?php echo esc_attr( $taxonomy ); ?>" data-tab-page="1" data-term-id="<?php echo esc_attr( $queried_object->term_id ); ?>"><?php esc_attr_e('Most commented', 'onecommunity'); ?></li>
				<li class="current" data-posts-type="1" data-taxonomy="<?php echo esc_attr( $taxonomy ); ?>" data-tab-page="1" data-term-id="<?php echo esc_attr( $queried_object->term_id ); ?>"><?php esc_attr_e('Recent', 'onecommunity'); ?></li>
			</ul>
	</div><!-- .item-list-tabs -->

	</div><!-- item-nav -->

<div class="clear"></div>

<?php 
$desc = $queried_object->description;
if ($desc) {
	echo '<div class="subtitle desc">';
	echo esc_attr( $desc );
	echo '</div>';
	echo '<div class="clear"></div>';
}
?>


<ul class="blog-1 blog-1-sidebar col-2 list-unstyled">

<?php
$temp = $wp_query;
$term_id = $queried_object->term_id;
$wp_query->query('posts_per_page=6&' . $taxonomy . '=' . $term_id . '&paged=1');
while ($wp_query->have_posts()) : $wp_query->the_post(); ?>

	<li class="box-blog-entry<?php if ( !has_post_thumbnail() ) { echo " no-thumbnail"; } ?>" data-post-id="<?php the_ID(); ?>">
    <div class="box-blog-thumb">

    	<?php if ( has_post_thumbnail() ) { ?>
		<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('post-thumbnail'); ?></a>
		<?php } ?>

	</div>

		<div class="box-blog-details">
			<div class="box-blog-details-top">
				<span class="box-blog-cat"><?php the_category(', ') ?></span>
				<span class="box-blog-time"><?php printf( _x( '%s ago', '%s = human-readable time difference', 'onecommunity' ), human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) ); ?></span>
			</div>
				<a href="<?php the_permalink(); ?>" class="blog-thumb-title-anchor"><?php $thetitle = get_the_title(); $getlength = strlen($thetitle); $thelength = 57; echo mb_substr($thetitle, 0, $thelength, 'UTF-8'); if ($getlength > $thelength) echo "..."; ?></a>

			<div class="box-blog-details-bottom">
			<span class="box-blog-details-bottom-author">
			<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
			<?php
			echo get_avatar( get_the_author_meta( 'user_email' ), 25 );
			?>
			</a>
			<?php esc_attr_e('by', 'onecommunity'); ?> <?php echo get_the_author(); ?></span>
			<?php if (function_exists('wp_ulike_get_post_likes')) { ?><span class="box-blog-likes"><?php echo wp_ulike_get_post_likes(get_the_ID()) ?></span><?php } ?>
			<span class="box-blog-comments"><?php comments_number('0', '1', '%'); ?></span>
			<div class="clear"></div>
			</div><!-- blog-box-comments -->
		</div><!-- blog-thumb-title -->

	</li>


<?php endwhile; ?>

	<?php else : ?>

		<h2 class="center"><?php esc_attr_e('Not Found', 'onecommunity'); ?></h2>
		<?php get_search_form(); ?>

	<?php endif; ?>

<div class="clear"></div>

</ul>

<?php $wp_query = null; $wp_query = $temp; ?>

<div class="load-more-container">
<span id="load-more-archive" class="show" data-posts-type="1" data-taxonomy="<?php echo esc_attr( $taxonomy ); ?>" data-tab-page="1" data-term-id="<?php echo esc_attr( $queried_object->term_id ); ?>"><?php esc_attr_e('Load More', 'onecommunity'); ?></span>
</div>

</main><!-- content -->

<div id="sidebar-spacer"></div>

<aside id="sidebar">
	
	<?php 
	$transient = get_transient( 'onecommunity_sidebar_blog' );
	if ( false === $transient || !get_theme_mod( 'onecommunity_transient_sidebar_blog_enable', 0 ) == 1 ) {
	ob_start();

	if (function_exists('dynamic_sidebar') && dynamic_sidebar('sidebar-blog')) : endif;

	$sidebar = ob_get_clean();
	print_r($sidebar);
	
	if ( get_theme_mod( 'onecommunity_transient_sidebar_blog_enable', 0 ) == 1 ) {
		set_transient( 'onecommunity_sidebar_blog', $sidebar, MINUTE_IN_SECONDS * get_theme_mod( 'onecommunity_transient_sidebar_blog_expiration', 20 ) );
	}

	} else {
		echo '<!-- Transient onecommunity_sidebar_blog ('.get_theme_mod( 'onecommunity_transient_sidebar_blog_expiration', 20 ).' min) -->';
		print_r( $transient );
	}
	?>

</aside>
<!--sidebar ends-->

</section><!-- .wrapper -->

<?php get_footer(); ?>
