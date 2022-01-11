<?php
function onecommunity_recent_forum_topics($atts, $content = null) {
	extract(shortcode_atts(array(
		"number_of_topics" => '5',
		"col" => '1',
	), $atts));
ob_start(); ?>
<div class="recent-forum-topics-wrapper col-<?php echo $col ?>">

<?php
	if ( bbp_has_topics( array( 'author' => 0, 'show_stickies' => false, 'order' => 'DESC', 'post_parent' => 'any', 'paged' => 1, 'posts_per_page' => $number_of_topics ) ) ) :
		bbp_get_template_part( 'loop', 'mytopics' );
	else :
		bbp_get_template_part( 'feedback', 'no-topics' );
	endif; ?>
</div>
<?php
$shortcode_content = ob_get_clean();
return $shortcode_content;
}

add_shortcode("onecommunity-recent-forum-topics", "onecommunity_recent_forum_topics");

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////