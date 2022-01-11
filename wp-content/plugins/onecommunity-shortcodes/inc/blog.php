<?php

function onecommunity_blog_categories($atts, $content = null) {

ob_start();
$cats = explode("<br />",wp_list_categories('title_li=&echo=0&depth=1&style=none'));
$cat_n = count($cats) - 1;
$cat_left = '';
$cat_right = '';
for ($i=0;$i<$cat_n;$i++):
if ($i<$cat_n/2):
$cat_left = $cat_left.'<li>'.$cats[$i].'</li>';
elseif ($i>=$cat_n/2):
$cat_right = $cat_right.'<li>'.$cats[$i].'</li>';
endif;
endfor;
?>

<ul id="blog-categories-left">
<?php echo $cat_left; ?>
</ul>
<ul id="blog-categories-right">
<?php echo $cat_right; ?>
</ul>
<?php
$shortcode_content = ob_get_clean();
return $shortcode_content;
}

add_shortcode("onecommunity-blog-categories", "onecommunity_blog_categories");


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function onecommunity_recent_blog_posts_tag($atts, $content = null) {
	extract(shortcode_atts(array(
		"number_of_blog_posts" => '3',
		"tag" => '',
		"col" => '1'
	), $atts));

ob_start(); ?>

<ul class="shortcode-small-recent-posts-container shortcode-general-list col-<?php echo $col ?>">

<?php
$wp_query = '';
$paged = '';
$temp = $wp_query;
$wp_query= null;
$wp_query = new WP_Query();
$wp_query->query('tag=' . $tag . '&posts_per_page=' . $number_of_blog_posts . ''.'&paged='.$paged);
while ($wp_query->have_posts()) : $wp_query->the_post();
?>

	<li class="recent-post">
        <div class="recent-post-thumb"><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumbnail'); ?></a></div>
       	<div class="recent-post-title"><a href="<?php the_permalink(); ?>" class="recent-post-title-link"><?php the_title(); ?></a>
		<div class="recent-post-bottom"><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author"> <?php echo get_avatar( get_the_author_meta( 'user_email' ), 22 ); ?> <?php echo get_the_author(); ?></a> <span class="recent-post-time"><?php printf( _x( '%s ago', '%s = human-readable time difference', 'onecommunity-shortcodes' ), human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) ); ?></span> <?php _e( 'in', 'onecommunity-shortcodes' ) ?> <?php the_category(', ') ?></div>
	</li>
	<div class="clear"></div>

<?php endwhile; // end of loop
wp_reset_postdata(); ?>

</ul>

<?php
$shortcode_content = ob_get_clean();
return $shortcode_content;

}

add_shortcode("onecommunity-recent-blog-posts-tag", "onecommunity_recent_blog_posts_tag");

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function my_get_comment_excerpt($comment_ID = 0) {
	$comment = get_comment( $comment_ID );
	$comment_text = strip_tags($comment->comment_content);

	if(strlen($comment_text)>70){
		$comment_text = mb_substr($comment_text, 0, 80, 'utf-8');
		$comment_text = $comment_text . '...';
		echo $comment_text;
	} else {
		echo $comment_text;
	}

}


function onecommunity_recent_blog_comments($atts, $content = null) {
	extract(shortcode_atts(array(
		"number_of_comments" => '5',
		"col" => '1'
	), $atts));
ob_start();
?>

<div class="recent-comment-container col-<?php echo $col ?>">

	<ul class="shortcode-general-list">
<?php
// This is where you run the code and display the output

$args_comm = array( 'number' => $number_of_comments, 'status' => 'approve', 'post_type' =>'post' );
$comments = get_comments($args_comm);
foreach($comments as $comment) { ?>
	<li class="shortcode-recent-comment">

		<div class="recent-comment-avatar"><?php echo get_avatar($comment, 60); ?></div>

		<div class="recent-comment-content">
			"<?php echo my_get_comment_excerpt($comment->comment_ID); ?>"

					<div class="recent-comment-info">
					<?php echo $comment->comment_author; ?> in
					<a href="<?php echo get_comment_link($comment->comment_ID); ?>">
									<?php $post_title = get_the_title($comment->comment_post_ID);
										if(strlen($post_title)>60){
											$post_title = mb_substr($post_title, 0, 60, 'utf-8');
											$post_title = $post_title . '...';
										}
									echo $post_title; ?>
					</a>
					</div><!-- recent-comment-info -->

		</div><!-- shortcode-recent-comment -->

		<div class="clear"></div>

	</li><!-- shortcode-recent-comment -->
<?php } ?>
</ul>
</div><!-- recent-comment-container -->

<?php
$shortcode_content = ob_get_clean();
return $shortcode_content;
}

add_shortcode("onecommunity-recent-blog-comments", "onecommunity_recent_blog_comments");



function onecommunity_blog_posts($atts, $content = null) {
	extract(shortcode_atts(array(
		"number_of_posts" => 3,
		"col" => 3
	), $atts));

ob_start();
?>

<div class="shortcode-posts-container">

<ul class="blog-1 blog-1-full-width col-<?php echo $col ?> list-unstyled">

<?php
$temp = $wp_query;
$wp_query= null;
$wp_query = new WP_Query();
$wp_query->query('posts_per_page=' . $number_of_posts . '&paged=1');
while ($wp_query->have_posts()) : $wp_query->the_post();

get_template_part( 'template-parts/blog', 'grid' );

endwhile; // end of loop
?>

</ul>
<div class="clear"></div>

<?php $wp_query = null; $wp_query = $temp;?>

</div><!-- shortcode-posts-container -->

<?php
$shortcode_content = ob_get_clean();
return $shortcode_content;

}
add_shortcode("onecommunity-blog-posts", "onecommunity_blog_posts");


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function onecommunity_blog_tags($atts, $content = null) {

ob_start();
$args_tags = array(
    'smallest'                  => 14,
    'largest'                   => 14,
    'unit'                      => 'px',
    'number'                    => 45,
    'format'                    => 'flat',
    'separator'                 => ' ',
    'orderby'                   => 'count',
    'order'                     => 'ASC',
    'exclude'                   => null,
    'include'                   => null,
    'link'                      => 'view',
    'taxonomy'                  => 'post_tag',
    'echo'                      => true,
    'child_of'                   => null
);
?>

<div class="shortcode-blog-tags">
<?php
wp_tag_cloud( $args_tags );
?>
</div>
<?php
$shortcode_content = ob_get_clean();
return $shortcode_content;
}

add_shortcode("onecommunity-blog-tags", "onecommunity_blog_tags");


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


$number_of_posts = 3;

function onecommunity_popular_blog_posts($atts, $content = null) {
	extract(shortcode_atts(array(
		"number_of_posts" => '3'
	), $atts));
ob_start();

global $number_of_posts;
$number_of_posts = $number_of_posts;
$nonce = wp_create_nonce("onecommunity_popular_blog_posts");
?>

<div class="shortcode-popular-posts">

<div class="sidebar-title sidebar-title-show">
	<span id="tab-news-1-title" class="tab-news-content-title current"><?php _e('Most Liked', 'onecommunity-shortcodes'); ?></span>
	<span id="tab-news-2-title" class="tab-news-content-title"><?php _e('Commented', 'onecommunity-shortcodes'); ?></span>
	<span id="tab-news-3-title" class="tab-news-content-title"><?php _e('Featured', 'onecommunity-shortcodes'); ?></span>
	<span id="tab-news-4-title" class="tab-news-content-title"><?php _e('Events', 'onecommunity-shortcodes'); ?></span>

 <div class="shortcode-popular-posts-menu"></div>
 <div class="shortcode-popular-posts-menu-drop-down">
  	<span data-tab="1" data-tab-title="tab-news-1-title" data-nonce="<?php echo $nonce ?>" class="current"><?php _e('Most Liked', 'onecommunity-shortcodes'); ?></span>
 	<span data-tab="2" data-tab-title="tab-news-2-title" data-nonce="<?php echo $nonce ?>"><?php _e('Most commented', 'onecommunity-shortcodes'); ?></span>
 	<span data-tab="3" data-tab-title="tab-news-3-title" data-nonce="<?php echo $nonce ?>"><?php _e('Featured', 'onecommunity-shortcodes'); ?></span>
  	<span data-tab="4" data-tab-title="tab-news-4-title" data-nonce="<?php echo $nonce ?>"><?php _e('Events', 'onecommunity-shortcodes'); ?></span>
 </div>
</div>


<ul class="tab-news-content">
<?php
$row = null;
$wp_query = null;
$temp = $wp_query;
$wp_query = new WP_Query();
$wp_query->query('orderby=meta_value_num&meta_key=_liked&posts_per_page=' . $number_of_posts . ''.'&paged=null');
while ($wp_query->have_posts()) : $wp_query->the_post(); ?>

	<li>
		<div class="pop-left">
		<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumbnail'); ?></a>
		</div>
		<div class="pop-right">
    	<div class="shortcode-popular-post-title"><a href="<?php the_permalink(); ?>"><?php $thetitle = get_the_title(); $getlength = strlen($thetitle); $thelength = 60; echo mb_substr($thetitle, 0, $thelength, 'UTF-8'); if ($getlength > $thelength) echo "..."; ?></a></div>
		<div class="shortcode-popular-posts-details"><span class="shortcode-popular-posts-time"><?php the_time('l, M j'); ?></span> <?php if (function_exists('wp_ulike_get_post_likes')) { ?><span class="shortcode-popular-posts-likes"><?php echo wp_ulike_get_post_likes(get_the_ID()) ?></span><?php } ?></div>
		</div>
		<div class="clear"></div>
	</li>

<?php
endwhile;
wp_reset_postdata();
?>
</ul>

</div><!-- shortcode-popular-posts -->
<?php
$shortcode_content = ob_get_clean();
return $shortcode_content;

}
add_shortcode("onecommunity-popular-blog-posts", "onecommunity_popular_blog_posts");



function onecommunity_top_news_load() {
$posts_list_type = esc_html( $_POST['posts_list_type'] );
$nonce = esc_html( $_POST['nonce'] );
global $number_of_posts;

if ( !wp_verify_nonce( $_REQUEST['nonce'], "onecommunity_popular_blog_posts")) {
    exit("Illegal request");
}

if ( $posts_list_type == 1 ) {

$row = null;
$wp_query = null;
$temp = $wp_query;
$wp_query = new WP_Query();
$wp_query->query('orderby=meta_value_num&meta_key=_liked&posts_per_page=' . $number_of_posts . ''.'&paged=null');
while ($wp_query->have_posts()) : $wp_query->the_post(); ?>

	<li>
		<div class="pop-left">
		<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumbnail'); ?></a>
		</div>
		<div class="pop-right">
    	<div class="shortcode-popular-post-title"><a href="<?php the_permalink(); ?>"><?php $thetitle = get_the_title(); $getlength = strlen($thetitle); $thelength = 60; echo mb_substr($thetitle, 0, $thelength, 'UTF-8'); if ($getlength > $thelength) echo "..."; ?></a></div>
		<div class="shortcode-popular-posts-details"><span class="shortcode-popular-posts-time"><?php the_time('l, M j'); ?></span> <?php if (function_exists('wp_ulike_get_post_likes')) { ?><span class="shortcode-popular-posts-likes"><?php echo wp_ulike_get_post_likes(get_the_ID()) ?></span><?php } ?></div>
		</div>
		<div class="clear"></div>
	</li>

<?php
endwhile;
wp_reset_postdata();
wp_die();

 } elseif ($posts_list_type == 2) {

$wp_query = null;
$temp = $wp_query;
$wp_query = new WP_Query();
$wp_query->query('orderby=comment_count&posts_per_page=' . $number_of_posts . ''.'&paged=null');
while ($wp_query->have_posts()) : $wp_query->the_post();
?>

	<li>
		<div class="pop-left">
		<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumbnail'); ?></a>
		</div>
		<div class="pop-right">
    	<div class="shortcode-popular-post-title"><a href="<?php the_permalink(); ?>"><?php $thetitle = get_the_title(); $getlength = strlen($thetitle); $thelength = 60; echo mb_substr($thetitle, 0, $thelength, 'UTF-8'); if ($getlength > $thelength) echo "..."; ?></a></div>
		<div class="shortcode-popular-posts-details"><span class="shortcode-popular-posts-time"><?php the_time('l, M j'); ?></span> <?php if (function_exists('wp_ulike_get_post_likes')) { ?><span class="shortcode-popular-posts-likes"><?php echo wp_ulike_get_post_likes(get_the_ID()) ?></span><?php } ?></div>
		</div>
		<div class="clear"></div>
	</li>

<?php
endwhile;
wp_reset_postdata();
wp_die();
} elseif ($posts_list_type == 3) {

$counter_3 = null;
$wp_query = null;
$temp = $wp_query;
$wp_query = new WP_Query();
$wp_query->query('tag=Featured&orderby=comment_count&posts_per_page=' . $number_of_posts . ''.'&paged=null');
while ($wp_query->have_posts()) : $wp_query->the_post();
?>

	<li>
		<div class="pop-left">
		<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumbnail'); ?></a>
		</div>
		<div class="pop-right">
    	<div class="shortcode-popular-post-title"><a href="<?php the_permalink(); ?>"><?php $thetitle = get_the_title(); $getlength = strlen($thetitle); $thelength = 60; echo mb_substr($thetitle, 0, $thelength, 'UTF-8'); if ($getlength > $thelength) echo "..."; ?></a></div>
		<div class="shortcode-popular-posts-details"><span class="shortcode-popular-posts-time"><?php the_time('l, M j'); ?></span> <?php if (function_exists('wp_ulike_get_post_likes')) { ?><span class="shortcode-popular-posts-likes"><?php echo wp_ulike_get_post_likes(get_the_ID()) ?></span><?php } ?></div>
		</div>
		<div class="clear"></div>
	</li>

<?php
endwhile;
wp_reset_postdata();
wp_die();
} else {

$wp_query = null;
$temp = $wp_query;
$wp_query = new WP_Query();
$wp_query->query('tag=Events&orderby=comment_count&posts_per_page=' . $number_of_posts . ''.'&paged=null');
while ($wp_query->have_posts()) : $wp_query->the_post();
?>

	<li>
		<div class="pop-left">
		<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumbnail'); ?></a>
		</div>
		<div class="pop-right">
    	<div class="shortcode-popular-post-title"><a href="<?php the_permalink(); ?>"><?php $thetitle = get_the_title(); $getlength = strlen($thetitle); $thelength = 60; echo mb_substr($thetitle, 0, $thelength, 'UTF-8'); if ($getlength > $thelength) echo "..."; ?></a></div>
		<div class="shortcode-popular-posts-details"><span class="shortcode-popular-posts-time"><?php the_time('l, M j'); ?></span> <?php if (function_exists('wp_ulike_get_post_likes')) { ?><span class="shortcode-popular-posts-likes"><?php echo wp_ulike_get_post_likes(get_the_ID()) ?></span><?php } ?></div>
		</div>
		<div class="clear"></div>
	</li>

<?php
endwhile;
wp_reset_postdata();
wp_die();
}


}
add_action( 'wp_ajax_nopriv_onecommunity_top_news_load', 'onecommunity_top_news_load' );
add_action( 'wp_ajax_onecommunity_top_news_load', 'onecommunity_top_news_load' );

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function onecommunity_cat_posts($atts, $content = null) {
	extract(shortcode_atts(array(
		"cat_id" => ''
	), $atts));

ob_start();
?>

<div id="shortcode-category-posts">

<div class="shortcode-category-posts-menu">
<ul>
<li class="cat-item cat-item-0 current"><a href="javascript: void(0)">All</a></li>
<?php wp_list_categories( array(
    'include' => $cat_id,
    'title_li' => '',
    'orderby'=> 'count',
    'order' => 'DESC',
    'show_count' => false
) );

$cats_array = explode(",", $cat_id);
?>
</ul>
</div>


<div class="big-post-container">

<ul class="big-post col-1">
<?php
$wp_query = null;
$paged = null;
$temp = $wp_query;
$wp_query= null;
$wp_query = new WP_Query();
$wp_query->query('cat=0&posts_per_page=1'.'&paged='.$paged);
while ($wp_query->have_posts()) : $wp_query->the_post();
?>

	<li class="box-blog-entry<?php if ( !has_post_thumbnail() ) { echo " no-thumbnail"; } ?>">
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

<?php
endwhile;
wp_reset_postdata(); ?>

</ul>

</div><!-- big-post-container -->

<div class="cat-posts-list-container">

<ul class="cat-posts-list col-2 shortcode-category-id-<?php echo $cats_array[0]; ?>">
<?php
$wp_query = null;
$paged = null;
$temp = $wp_query;
$wp_query= null;
$wp_query = new WP_Query();
$wp_query->query('cat=0&posts_per_page=8&offset=1'.'&paged='.$paged);
while ($wp_query->have_posts()) : $wp_query->the_post();
?>

	<li class="recent-post<?php if ( !has_post_thumbnail() ) { echo " no-thumbnail"; } ?>">
		<?php if ( has_post_thumbnail() ) { ?>
         <div class="recent-post-thumb"><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumbnail'); ?></a></div>
         <?php } ?>
         <div class="recent-post-content">
       	 	<div class="recent-post-title"><a href="<?php the_permalink(); ?>" class="recent-post-title-link"><?php echo mb_strimwidth(get_the_title(), 0, 70, '...'); ?></a></div>
			<div class="recent-post-bottom">
			<span class="recent-post-bottom-date"><?php the_time( 'l, M j' ); ?></span>

			<?php if (function_exists('wp_ulike_get_post_likes')) { ?><span class="box-blog-likes"><?php $likes = wp_ulike_get_post_likes(get_the_ID()); if($likes == 0) { echo "0"; } else { echo $likes; } ?></span><?php } ?>
			<span class="box-blog-comments"><?php comments_number('0', '1', '%'); ?></span>

			</div>
		</div>
	</li>

<?php endwhile; // end of loop
wp_reset_postdata();
?>
</ul>
</div><!-- cat-posts-list-container -->

</div><!-- #shortcode-category-posts -->

<?php
$shortcode_content = ob_get_clean();
return $shortcode_content;

}

add_shortcode("onecommunity-cat-posts", "onecommunity_cat_posts");




function onecommunity_cat_big_post_load() {
$cat_id = esc_html( $_POST['cat_id'] );
$wp_query = null;
$paged = null;
$temp = $wp_query;
$wp_query= null;
$wp_query = new WP_Query();
$wp_query->query('cat=' . $cat_id . '&posts_per_page=1'.'&paged='.$paged);
while ($wp_query->have_posts()) : $wp_query->the_post();
?>

	<li class="box-blog-entry<?php if ( !has_post_thumbnail() ) { echo " no-thumbnail"; } ?>">
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

<?php
endwhile;
wp_reset_postdata();
wp_die();
}
add_action( 'wp_ajax_nopriv_onecommunity_cat_big_post_load', 'onecommunity_cat_big_post_load' );
add_action( 'wp_ajax_onecommunity_cat_big_post_load', 'onecommunity_cat_big_post_load' );




function onecommunity_cat_posts_load() {
$cat_id = esc_html( $_POST['cat_id'] );
$wp_query = null;
$paged = null;
$temp = $wp_query;
$wp_query= null;
$wp_query = new WP_Query();
$wp_query->query('cat=' . $cat_id . '&posts_per_page=8&offset=1'.'&paged='.$paged);
while ($wp_query->have_posts()) : $wp_query->the_post();
?>

	<li class="recent-post<?php if ( !has_post_thumbnail() ) { echo " no-thumbnail"; } ?>">
		<?php if ( has_post_thumbnail() ) { ?>
         <div class="recent-post-thumb"><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumbnail'); ?></a></div>
         <?php } ?>
         <div class="recent-post-content">
       	 	<div class="recent-post-title"><a href="<?php the_permalink(); ?>" class="recent-post-title-link"><?php echo mb_strimwidth(get_the_title(), 0, 70, '...'); ?></a></div>
			<div class="recent-post-bottom">
			<span class="recent-post-bottom-date"><?php the_time( 'l, M j' ); ?></span>

			<?php if (function_exists('wp_ulike_get_post_likes')) { ?><span class="box-blog-likes"><?php $likes = wp_ulike_get_post_likes(get_the_ID()); if($likes == 0) { echo "0"; } else { echo $likes; } ?></span><?php } ?>
			<span class="box-blog-comments"><?php comments_number('0', '1', '%'); ?></span>

			</div>
		</div>
	</li>

<?php endwhile; // end of loop
wp_reset_postdata();
wp_die();
}
add_action( 'wp_ajax_nopriv_onecommunity_cat_posts_load', 'onecommunity_cat_posts_load' );
add_action( 'wp_ajax_onecommunity_cat_posts_load', 'onecommunity_cat_posts_load' );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////