<?php

/**
 * Summary: Template to display for creating a channel from add_feed controller
 * Description:
 *
 * @since 1.0
 * @package WordPress
 */

?>
<?php

$user_id = get_current_user_id();

$settings = get_option('powerpress_feed_' . $user_id);

$user_info = wp_get_current_user();

?>
<div class="podcast-wrapper feed-info feed-show <?php echo get_option('powerpress_feed_' . $user_id) ? 'show-feed-info' : '' ?>">
	<h2>Channel Information</h2>
	<form id="add-feed-sj">
		<div class="uk-option-item yz-text-field">
			<div class="option-infos">
				<label for="email" class="option-title">Channel Title</label>
				<p class="option-desc">Enter the name of your channel</p>
			</div>
			<div id="feed-show-title" class="option-content">
				<?php echo $settings['title']; ?>
			</div>
		</div>
		<div class="uk-option-item yz-text-field">
			<div class="option-infos">
				<label for="email" class="option-title">Channel Description</label>
				<p class="option-desc">Enter a description your channel</p>
			</div>
			<div id="feed-show-description" class="option-content">
				<?php echo $settings['description']; ?>
			</div>
		</div>
		<div class="uk-option-item yz-text-field">
			<div class="option-infos">
				<label for="email" class="option-title">Channel Art</label>
				<p class="option-desc">Upload a cover image for your channel</p>
			</div>
			<div class="option-content">
				<img id="feed-show-itunes-image" src="<?php echo $settings['itunes_image']; ?>" width="200" />
			</div>
		</div>
		<input type="hidden" id="feed-slug" value="<?php echo sanitize_title(wp_unslash($settings['title'])); ?>" />
		<input type="hidden" id="itunes_image" value="<?php echo $settings['itunes_image']; ?>" />
		<input type="hidden" id="feed-author" value="<?php echo $user_info->display_name; ?>" />
		<div id="add-feed-edit" class="add-feed add-feed-edit">
			<i class="fas fa-arrow-to-right add-feed-icon"></i>
			<span>Edit</span>
		</div>
		<div id="add-feed-episode" class="add-feed add-feed-episode">
			<i class="fas fa-arrow-to-right add-feed-icon"></i>
			<span>Add Episode</span>
		</div>
	</form>
</div>

<div class="podcast-wrapper feed-info feed-set <?php echo get_option('powerpress_feed_' . $user_id) ? '' : 'show-feed-info' ?>">
	<h2>Create Your Channel</h2>
	<form id="add-feed-sj">
		<?php $nonce = wp_create_nonce('add-feed'); ?>
		<div class="uk-option-item yz-text-field">
			<div class="option-infos">
				<label for="email" class="option-title">Channel Title</label>
				<p class="option-desc">Enter the name of your channel</p>
			</div>
			<div class="option-content">
				<input name="feed-name" id="feed-name" placeholder="Your Channel Name" value="<?php echo $settings['title'] ? $settings['title'] : ''; ?>" />
			</div>
		</div>
		<div class="uk-option-item yz-text-field">
			<div class="option-infos">
				<label for="email" class="option-title">Channel Description</label>
				<p class="option-desc">Enter a description your channel</p>
			</div>
			<div class="option-content">
				<textarea name="feed-description" id="feed-description" rows="3" placeholder="Your channel description"><?php echo $settings['description'] ? $settings['description'] : ''; ?></textarea>
			</div>
		</div>
		<div class="uk-option-item yz-text-field">
			<div class="option-infos">
				<label for="email" class="option-title">Channel Art</label>
				<p class="option-desc">Upload a cover image for your channel</p>
			</div>
			<div class="option-content">
				<input type="file" id="itunes_image_file" name="itunes_image_file" accept="image/png, image/jpeg, image/jpg">
			</div>
		</div>
		<input type="hidden" id="add-feed-nonce" name="add-feed-nonce" value="<?php echo $nonce; ?>" />
		<div id="add-feed-submit" class="add-feed">
			<i class="fas fa-arrow-to-right add-feed-icon"></i>
			<span>Save</span>
		</div>
	</form>
</div>

<div class="podcast-wrapper feed-info feed-episode">
	<h2>Create Your Episode</h2>
	<form id="add-feed-sj">
		<?php $nonce = wp_create_nonce('add-episode'); ?>
		<div class="uk-option-item yz-text-field">
			<div class="option-infos">
				<label for="email" class="option-title">Episode Title</label>
				<p class="option-desc">Enter the name of your episode</p>
			</div>
			<div class="option-content">
				<input name="episode-name" id="episode-name" placeholder="Episode Title" />
			</div>
		</div>
		<div class="uk-option-item yz-text-field">
			<div class="option-infos">
				<label for="email" class="option-title">Episode Description</label>
				<p class="option-desc">Enter a description your channel</p>
			</div>
			<div class="option-content">
				<textarea name="episode-description" id="episode-description" placeholder="New episode description" rows="3"></textarea>
			</div>
		</div>

		<div class="uk-option-item yz-text-field record-episode-wrapper">
			<div class="option-infos">
				<label for="email" class="option-title">Episode Recorder</label>
				<p class="option-desc">Begin recording your episode</p>
			</div>
			<div class="option-content">
				<section class="main-controls">
					<canvas class="visualizer" height="60px"></canvas>
					<div id="buttons">
						<button class="web-audio-record-record">Record</button>
						<button class="web-audio-record-stop">Stop</button>
					</div>

				</section>

				<section class="sound-clips">


				</section>
				<div id="refresh-tracks">
					<div id="refresh-button">Reload Track</div>
				</div>
			</div>
		</div>
		<div class="uk-option-item yz-text-field upload-episode-wrapper">
			<div class="option-infos">
				<label for="email" class="option-title">Upload Your Episode</label>
				<p class="option-desc">Upload a prerecorded episode</p>
			</div>
			<div class="option-content">
				<input type="file" id="upload_audio_file" name="upload_audio_file" accept="audio/mgeg3">
			</div>
		</div>
		<input type="hidden" id="add-episode-nonce" name="add-episode-nonce" value="<?php echo $nonce; ?>" />
		<input type="hidden" id="user-id" name="user-id" value="<?php echo $user_id; ?>" />
		<div id="add-episode-submit" class="add-feed">
			<i class="fas fa-arrow-to-right add-feed-icon"></i>
			<span>Save</span>
		</div>
		<div id="upload-episode-submit" class="add-feed">
			<i class="fas fa-arrow-to-right add-feed-icon"></i>
			<span>Save</span>
		</div>
		<div id="upload-episode" class="add-feed">
			<i class="fas fa-arrow-to-right add-feed-icon"></i>
			<span>Upload</span>
		</div>
		<div id="record-episode" class="add-feed">
			<i class="fas fa-arrow-to-right add-feed-icon"></i>
			<span>Record</span>
		</div>
	</form>
</div>
<div id="podcast-modal-wrapper">
	<div id="podcast-modal">
		<div id="podcast-modal-loader-wrapper">
			<div class="loader">Loading...</div>
		</div>
		<div id="podcast-modal-content"></div>
		<div id="podcast-modal-button">OK</div>
	</div>
</div>
