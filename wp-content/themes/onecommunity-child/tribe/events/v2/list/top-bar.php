<?php
/**
 * View: Top Bar
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/events/v2/list/top-bar.php
 *
 * See more documentation about our views templating system.
 *
 * @link {INSERT_ARTCILE_LINK_HERE}
 *
 * @version 5.0.1
 *
 */
?>
<div class="tribe-events-c-top-bar tribe-events-header__top-bar">

	<?php $this->template( 'list/top-bar/nav' ); ?>

	<?php $this->template( 'components/top-bar/today' ); ?>

	<?php $this->template( 'list/top-bar/datepicker' ); ?>

	<?php $this->template( 'components/top-bar/actions' ); ?> 
	
	<?php
	
	if ( isset( $_SERVER['REQUEST_URI'] ) ) {
		$url = explode( '/', esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) );
	}

	foreach ( $url as $key => $row_url ) {
		if ( empty( $row_url ) ) {
			unset( $url[$key] );
		}
	}
	if( 'webinars' == $url[3]){
		echo '<button class="host-a-webinar">Host a Webinar</button>';
	}

	?>

</div>
