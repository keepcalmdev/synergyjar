<?php
// hacks and mods will go here
// function remove_xprofile_links() {
//     remove_filter( 'bp_get_the_profile_field_value', 'xprofile_filter_link_profile_data', 9, 2 );
// }
// add_action( 'bp_init', 'remove_xprofile_links' );


// change 'discuss' to whatever you want
//define( 'BP_FORUMS_SLUG', 'discuss' );

function update_nav_items() {
    $bp = buddypress();

    $bp->members->nav->edit_nav( array( 'name' => __( 'Q & A', 'textdomain' ) ), 'activity' );
    
    //$bp->edit_nav( array( 'name' => __( 'Q & A', 'textdomain' ) ), 'Activity' );

    //echo json_encode($bp->members);
    
}
add_action( 'bp_init', 'update_nav_items' );
?>