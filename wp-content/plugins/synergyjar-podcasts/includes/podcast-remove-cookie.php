<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php';

print_r($_COOKIE);

if (current_user_can( 'manage_options' ) && isset($_COOKIE['synergyjarpodcastid'])) {

	

	if(setcookie("synergyjarpodcastid", null, time() - 3600, '/')){
		//wp_die('Cookie Removed');
		var_dump($_COOKIE);
	}
}

?>
