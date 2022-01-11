<?php
/*
Plugin Name: PMPro Customizations
Plugin URI: https://www.paidmembershipspro.com/wp/pmpro-customizations/
Description: Customizations for my Paid Memberships Pro Setup
Version: .1
Author: Paid Memberships Pro
Author URI: https://www.paidmembershipspro.com
*/
 
//Now start placing your customization code below this line

/*
Define the global array below for your main accounts and sponsored levels.
Array keys should be the main account level.
*/
global $pmprosm_sponsored_account_levels;

$pmprosm_sponsored_account_levels = array(
	//set 5 seats at checkout
	1 => array(
		'main_level_id' => 1, //redundant but useful
		'sponsored_level_id' => array(1,2), //array or single id
		'seats' => 5
	),
	//seats based on field at checkout
	3 => array(
		'main_level_id' => 3, //redundant but useful
		'sponsored_level_id'  => 4,
		'seat_cost' => 250,
		'max_seats' => 10
	)
);


//*
// * Example Register Helper fields for Company, Referral Code, and Budget.
// *
// */

// We have to put everything in a function called on init, so we are sure Register Helper is loaded.
function my_pmprorh_init() {
	// don't break if Register Helper is not loaded
	if ( ! function_exists( 'pmprorh_add_registration_field' ) ) {
		return false;
	}

	// define the fields
	$fields = array();
	$fields[] = new PMProRH_Field(
		'subject_matter',                      // input name, will also be used as meta key
		'select',                         // type of field
		array(
			'buddypress' => 'Public Owner/Agency Category',       // XProfile Field Name <-- !!!
			'label'     => 'Subject Matter',       // custom field label
			'size'      => 40,              // input size
			'class'     => 'subject_matter',       // custom class
			'profile'   => true,            // show in user profile
			'required'  => true,            // make this field required
			'option_value' => 'Option Label',
			'levels'        => array( 1,2,3,4,5,6 ),   // only levels 1 and 2 should have the company field
		)
	);
	// $fields[] = new PMProRH_Field(
	// 	'referral',                         // input name, will also be used as meta key
	// 	'text',                             // type of field
	// 	array(
	// 		'buddypress' => 'Referral',     // XProfile Field Name <-- !!!
	// 		'label'     => 'Referral Code', // custom field label
	// 		'profile'   => 'only_admin',     // only show in profile for admins
	// 	)
	// );

	// add the fields into a new checkout_boxes are of the checkout page
	// foreach ( $fields as $field ) {
	// 	pmprorh_add_registration_field(
	// 		'checkout_boxes',               // location on checkout page
	// 		$field                          // PMProRH_Field object
	// 	);
	// }
	// that's it. see the PMPro Register Helper readme for more information and examples.
}
add_action( 'init', 'my_pmprorh_init' );

function my_pmpro_login_redirect_url($redirect_to, $request, $user)
{
	global $wpdb;

	//if logged in and a member, send to members page
	if(pmpro_hasMembershipLevel(NULL, $user->ID))
		return "/community/activity";
	else
		return $redirect_to;
}
add_filter("pmpro_login_redirect_url", "my_pmpro_login_redirect_url", 10, 3);