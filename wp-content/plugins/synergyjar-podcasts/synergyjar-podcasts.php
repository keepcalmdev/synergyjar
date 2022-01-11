<?php
/*
Plugin Name: SynergyJar Podcasts
Plugin URI: https://redcircle.biz
Description: Custom plugin to use only for Synergy Jar requires Powerpress plugin 
Version: 1.0
Author: Michael Burbage
Author URI: https://redcircle.biz
*/
 
//Now start placing your customization code below this line


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'Synergy Jar Podcasts', '1.0.0' );

define( 'SYNERGYJAR_PODCASTS_PLUGIN', __FILE__ );
define( 'SYNERGYJAR_PODCASTS_DIR', untrailingslashit( dirname( SYNERGYJAR_PODCASTS_PLUGIN ) ) );

require_once SYNERGYJAR_PODCASTS_DIR . '/settings.php';
