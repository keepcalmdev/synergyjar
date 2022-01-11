<?php

class MetaParts
{

	function __construct()
	{
	}

	/**
	 * 
	 * Return Meta Part for PowerPress
	 */
	public function get_channel_art($post_id = null)
	{
		$post_meta = get_post_custom($post_id);

		$post_meta_0 = $post_meta['enclosure'][0];

		$MetaParts = explode("\n", $post_meta_0, 4);

		$Serialized = false;
		$Data = array();
		$Data['id'] = $post_id;
		$Data['feed'] = $feed_slug;
		$Data['url'] = '';
		$Data['duration'] = '';
		$Data['size'] = '';
		$Data['type'] = '';
		$Data['width'] = '';
		$Data['height'] = '';

		if (count($MetaParts) > 0)
			$Data['url'] = trim($MetaParts[0]);
		if (count($MetaParts) > 1)
			$Data['size'] = trim($MetaParts[1]);
		if (count($MetaParts) > 2)
			$Data['type'] = trim($MetaParts[2]);
		if (count($MetaParts) > 3)
			$Serialized = $MetaParts[3];

		if ($Serialized) {
			$ExtraData = @unserialize($Serialized);
			if ($ExtraData && is_array($ExtraData)) {
				foreach ($ExtraData as $key => $value) {

					// Make sure specific fields are not overwritten...
					switch ($key) {
						case 'id':
						case 'feed':
						case 'url':
						case 'size':
						case 'type':
							break;
						default:
							$Data[$key] = $value;
					}
				}

				if (isset($Data['length'])) // Setting from the "Podcasting" plugin...
					$Data['duration'] = powerpress_readable_duration($Data['length'], true);

				if (!empty($Data['webm_src'])) {
					$Data['webm_src'] = trim($Data['webm_src']);
				}


				if (strpos($MetaParts[0], 'http://') !== 0 && !empty($Data['hosting'])) // if the URL is not set (just file name) and we're a hosting customer...
				{
					$post_status = get_post_status($post_id);
					switch ($post_status) {
						case 'pending':
						case 'draft':
						case 'auto-draft': {
								// Determine if audio or video, then set the demo episode here...
								$Data['url'] = 'http://media.blubrry.com/blubrry/content.blubrry.com/blubrry/preview.mp3'; // audio
								if (strstr($Data['type'], 'video'))
									$Data['url'] = 'http://media.blubrry.com/blubrry/content.blubrry.com/blubrry/preview.mp4'; // video
							};
							break;
					}
				}
			}
		}

		return $Data;
	}
}
