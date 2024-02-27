<?php
	function sleek_media_component_is_video ($meta) {
		if (isset($meta['mime_type']) and strpos($meta['mime_type'], 'video') !== false) {
			return true;
		}

		return false;
	}

	$args = array_merge([
		'media' => null,
		'size' => 'large',
		'size_portrait' => 'medium'
	], $args);

	$video_args = [
		'autoplay',
		'muted',
		'disablepictureinpicture',
		'disableremoteplayback',
		'playsinline'
	];

	$media_id = null;
	$media_url = null;
	$media_classes = [];
	$media_portrait_id = null;
	$media_portrait_url = null;
	$media_portrait_classes = [];

	if (!empty($args['media']['media'])) {
		$media_id = $args['media']['media'];
		$media_url = wp_get_attachment_url($args['media']['media']);
		$media_meta = wp_get_attachment_metadata($args['media']['media']);

		if (!empty($args['media']['ratio']) and $args['media']['ratio'] !== 'auto') {
			$media_classes[] = 'ratio--' . $args['media']['ratio'];
		}
	}

	if (!empty($args['media']['media_portrait'])) {
		$media_portrait_id = $args['media']['media_portrait'];
		$media_portrait_url = wp_get_attachment_url($args['media']['media_portrait']);
		$media_portrait_meta = wp_get_attachment_metadata($args['media']['media']);
		$media_classes[] = 'portrait:hide';
		$media_portrait_classes[] = 'portrait:show';

		if (!empty($args['media']['ratio_portrait']) and $args['media']['ratio_portrait'] !== 'auto') {
			$media_portrait_classes[] = 'ratio--' . $args['media']['ratio_portrait'];
		}
	}
?>

<?php if ($media_url) : ?>
	<figure class="media">
		<div class="<?php echo implode(' ', $media_classes) ?>">
			<?php if (sleek_media_component_is_video($media_meta)) : ?>
				<video
					src="<?php echo $media_url ?>"
					width="<?php echo $media_meta['width'] ?>"
					height="<?php echo $media_meta['height'] ?>"
					<?php echo implode(' ', $video_args) ?>
				></video>
			<?php else : ?>
				<?php echo wp_get_attachment_image($media_id, $args['size']) ?>
			<?php endif ?>
		</div>
		<?php if ($media_portrait_url) : ?>
			<div class="<?php echo implode(' ', $media_portrait_classes) ?>">
				<?php if (sleek_media_component_is_video($media_portrait_meta)) : ?>
					<video
						src="<?php echo $media_portrait_url ?>"
						width="<?php echo $media_portrait_meta['width'] ?>"
						height="<?php echo $media_portrait_meta['height'] ?>"
						<?php echo implode(' ', $video_args) ?>
					></video>
				<?php else : ?>
					<?php echo wp_get_attachment_image($media_portrait_id, $args['size_portrait']) ?>
				<?php endif ?>
			</div>
		<?php endif ?>
	</figure>
<?php endif ?>