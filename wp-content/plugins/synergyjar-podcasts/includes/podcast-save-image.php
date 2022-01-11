<?php
/**
 *
 * Capture XMLHTTPRequest and upload channel art.
 *
 */

require_once($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');

if ( ! function_exists( 'wp_handle_upload' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/file.php' );
}

if (isset($_FILES['itunes_image_file']) && wp_verify_nonce($_POST['add-feed-nonce'], 'add-feed')) {

	$upload_dir = wp_upload_dir();

	$upload_overrides = array(
		'test_form' => false,
		'name'=> sanitize_file_name( $_FILES['itunes_image_file']['name'] ),
	);
	
	$imgfile = wp_handle_upload( $_FILES['itunes_image_file'], $upload_overrides );

	if ( $imgfile && ! isset( $imgfile['error'] ) ) {
		echo $imgfile['url'];
	} else {
		
		echo $imgfile['error'];
	}
}

/**
 * Add channel image that is itunes image feature compatible
 * 
 * 
 */

// function sj_add_custom_feed_itunes_image($upload_path, $image_file_name)
// {

// 	$filename = str_replace(" ", "_", basename($image_file_name));
// 	$temp = $upload_path . $filename;

// 	if (file_exists($upload_path . $filename)) {
// 		$filenameParts = pathinfo($filename);
// 		if (!empty($filenameParts['extension'])) {
// 			do {
// 				$filename_no_ext = substr($filenameParts['basename'], 0, (strlen($filenameParts['extension']) + 1) * -1);
// 				$filename = sprintf('%s-%03d.%s', $filename_no_ext, rand(0, 999), $filenameParts['extension']);
// 			} while (file_exists($upload_path . $filename));
// 		}
// 	}

// 	// Check the image...
// 	if (file_exists($temp)) {
// 		$ImageData = @getimagesize($temp);

// 		$rgb = true; // We assume it is RGB
// 		if (defined('POWERPRESS_IMAGICK') && POWERPRESS_IMAGICK) {
// 			if ($ImageData[2] == IMAGETYPE_PNG && extension_loaded('imagick')) {
// 				$image = new Imagick($temp);
// 				if ($image->getImageColorspace() != imagick::COLORSPACE_RGB) {
// 					$rgb = false;
// 				}
// 			}
// 		}

// 		if (empty($ImageData['channels']))
// 			$ImageData['channels'] = 3; // Assume it's ok if we cannot detect it.

// 		if ($ImageData) {
// 			if ($rgb && ($ImageData[2] == IMAGETYPE_JPEG || $ImageData[2] == IMAGETYPE_PNG) && $ImageData[0] == $ImageData[1] && $ImageData[0] >= 1400  && $ImageData[0] <= 3000 && $ImageData['channels'] == 3) // Just check that it is an image, the correct image type and that the image is square
// 			{
// 				if (!move_uploaded_file($temp, $upload_path . $filename)) {
// 					//echo __('Error saving image', 'powerpress')  . ':	' . htmlspecialchars($_FILES['itunes_image_file']['name']) . ' - ' . __('An error occurred saving the iTunes image on the server.', 'powerpress') . ' ' . sprintf(__('Local folder: %s; File name: %s', 'powerpress'), $upload_path, $filename));
// 				} else {
// 					$Feed['itunes_image'] = $upload_url . $filename;
// 					if (!empty($_POST['itunes_image_checkbox_as_rss'])) {
// 						$Feed['rss2_image'] = $upload_url . $filename;
// 					}

// 					//if( $ImageData[0] < 1400 || $ImageData[1] < 1400 )
// 					//{
// 					//	echo  __('iTunes image warning', 'powerpress')  .':	'. htmlspecialchars($_FILES['itunes_image_file']['name']) . __(' is', 'powerpress') .' '. $ImageData[0] .' x '.$ImageData[0]   .' - '. __('Image must be square 1400 x 1400 pixels or larger.', 'powerpress') );
// 					//}
// 				}
// 			} else if ($ImageData['channels'] != 3 || $rgb == false) {
// 				//echo __('Invalid image', 'powerpress')  . ':	' . htmlspecialchars($_FILES['itunes_image_file']['name']) . ' - ' . __('Image must be in RGB color space (CMYK is not supported).', 'powerpress'));
// 			} else if ($ImageData[0] != $ImageData[1]) {
// 				//echo __('Invalid image', 'powerpress')  . ':	' . htmlspecialchars($_FILES['itunes_image_file']['name']) . ' - ' . __('Image must be square, 1400 x 1400 is the required minimum size.', 'powerpress'));
// 			} else if ($ImageData[0] != $ImageData[1] || $ImageData[0] < 1400) {
// 				//echo __('Invalid image', 'powerpress')  . ':	' . htmlspecialchars($_FILES['itunes_image_file']['name']) . ' - ' . __('Image is too small, 1400 x 1400 is the required minimum size.', 'powerpress'));
// 			} else if ($ImageData[0] != $ImageData[1] || $ImageData[0] > 3000) {
// 				//echo __('Invalid image', 'powerpress')  . ':	' . htmlspecialchars($_FILES['itunes_image_file']['name']) . ' - ' . __('Image is too large, 3000 x 3000 is the maximum size allowed.', 'powerpress'));
// 			} else {
// 				//echo __('Invalid image', 'powerpress')  . ':	' . htmlspecialchars($_FILES['itunes_image_file']['name']));
// 			}
// 		} else {
// 			//echo __('Invalid image', 'powerpress')  . ':	' . htmlspecialchars($_FILES['itunes_image_file']['name']));
// 		}
// 	}
// }
?>
