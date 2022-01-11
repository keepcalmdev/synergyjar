<?php get_header(); ?>

<div class="header-title">
	<div class="wrapper">
		<div class="page-title"><span><?php printf( esc_attr__( 'Search Results for: %s', 'onecommunity' ), '  ' . esc_html( get_search_query() ) ); ?></span></div>
	</div>
</div>



<div class="wrapper">
<div class="content no-background">

<div class="blog-classic">

<?php
$temp = $wp_query;
$wp_query= null;
$wp_query = new WP_Query();
$wp_query->query('posts_per_page=6'.'&paged='.$paged);
while ($wp_query->have_posts()) : $wp_query->the_post();
?>

<div class="blog-post">

<div class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Fixed link <?php the_title_attribute(); ?>"><?php the_title(); ?></a>

<div class="post-title-details">
<span class="post-title-details-item"><?php esc_attr_e( 'Category', 'onecommunity' ); ?>: <span><?php the_category(',') ?></span></span> <span class="post-title-details-item"><?php esc_attr_e( 'Author', 'onecommunity' ); ?>: <span><a href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>"><?php the_author(); ?></a></span></span> <span class="post-title-details-item"><?php esc_attr_e( 'Date', 'onecommunity' ); ?>: <span><?php printf( _x( '%s ago', '%s = human-readable time difference', 'onecommunity' ), human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) ); ?></span></span> <span class="post-title-details-item"><?php esc_attr_e( 'Comments', 'onecommunity' ); ?>: <span><a href="<?php the_permalink() ?>#comments"><?php comments_number('0', '1', '%'); ?></a></span></span>
</div>
	<div class="clear"></div>
</div><!--post-title-->

<div class="blog-post-content">

<?php
if ( has_post_thumbnail() ) { ?>
	<div class="thumbnail">
		<?php the_post_thumbnail('post-thumbnail');
		DD_the_post_thumbnail_caption(); ?>
	</div>
<?php } else {
	// no thumbnail
}
?>

<div class="text">

<?php
global $more;
$more = 0;
the_content( esc_attr__('Continue reading &rarr;','onecommunity') );
?>


<br />
<div class="clear"></div>

</div><!--text-->
</div><!--blog-post-content-->

<div class="clear"></div>
</div><!--blog-post-->


<?php endwhile; // end of loop
?>

</ul>

<div class="clear"></div>

<div class="pagination-blog">
<?php
$big = 999999999; // need an unlikely integer
echo paginate_links( array(
	'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
	'format' => '?paged=%#%',
	'current' => max( 1, get_query_var('paged') ),
	'prev_text' => esc_attr__('&laquo;','onecommunity'),
	'next_text' => esc_attr__('&raquo;','onecommunity'),
	'total' => $wp_query->max_num_pages
) );
?>
</div>

<?php $wp_query = null; $wp_query = $temp;?>

</div><!-- blog-classic -->
</div><!-- .content -->

<div class="sidebar">
	<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('sidebar-blog')) : ?><?php endif; ?>
</div><!--sidebar ends-->
</div><!-- .wrapper -->



<?php get_footer(); ?>
