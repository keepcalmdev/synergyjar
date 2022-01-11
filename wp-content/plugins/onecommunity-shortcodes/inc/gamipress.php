<?php
function onecommunity_gamipress_leaderboard($atts, $content = null) {
	extract(shortcode_atts(array(
		"limit" => '10',
		"type" => '_gamipress_points_points',
		"page" => '1',
		"layout" => 'small',
		"name" => 'points'
	), $atts));

ob_start();

global $wpdb;

$query = "
    SELECT user_id, meta_value
    FROM {$wpdb->prefix}usermeta
    WHERE meta_key = '$type'
    ORDER BY CAST(meta_value AS DECIMAL) DESC
    LIMIT $limit
    ";

$gamipress_points = $wpdb->get_results($query, OBJECT);

echo '<div class="' . $layout . '-leaderboard">';

$i = 0;
foreach ( $gamipress_points as $user_IDs )
{
	$i++;
	echo '<div class="' . $layout . '-leaderboard-row">';
	echo '<div class="leaderboard-position">' . $i . '.</div>';
	$user_info = get_userdata($user_IDs->user_id);
	echo '<div class="leaderboard-user"><a href="' . esc_url( home_url( '/' ) ) . 'members/' . $user_info->user_nicename . '" class="avatar">' . get_avatar( $user_IDs->user_id, 50 ) . '</a></div>';
	echo '<a href="' . esc_url( home_url( '/' ) ) . 'members/' . $user_info->user_nicename . '" class="name">' . $user_nicename = $user_info->display_name . '</a>';
	echo '<div class="leaderboard-points">' . $user_IDs->meta_value . ' ' . $name . '</div>';

	echo '</div>';
}

echo '</div><!-- small-leaderboard -->';

$shortcode_content = ob_get_clean();
return $shortcode_content;
}
add_shortcode("onecommunity-gamipress-leaderboard", "onecommunity_gamipress_leaderboard");
