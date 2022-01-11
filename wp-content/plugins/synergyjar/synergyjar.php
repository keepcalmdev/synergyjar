<?php
/**
 * Plugin Name: SynergyJar Plugin
 * Plugin URI: https://www.redcircle.biz
 * Description: View Buddypress profile locations using Google maps
 * Version: 1.0
 * Author: Michael Burbage
 * Author URI: https://www.redcircle.biz
 **/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'Synergy Jar', '1.0.1' );

define( 'SYNERGYJAR_PLUGIN', __FILE__ );
define( 'SYNERGYJAR_DIR', untrailingslashit( dirname( SYNERGYJAR_PLUGIN ) ) );

require_once SYNERGYJAR_DIR . '/settings.php';
require_once SYNERGYJAR_DIR . '/d3.php';


?>