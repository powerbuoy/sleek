<?php
	$args = array_merge([
		'media' => null,
		'size' => 'large',
		'size_portrait' => 'medium',
		'class' => 'media',
		'loading' => 'lazy',
		'video_args' => [
			'autoplay',
			'muted',
			'disablepictureinpicture',
			'disableremoteplayback',
			'playsinline',
			'loop'
		]
	], $args);

	$media_id = null;
	$media_url = null;
	$media_classes = [];
	$media_portrait_id = null;
	$media_portrait_url = null;
	$media_portrait_classes = [];

	# Default media
	if (!empty($args['media']['media'])) {
		$media_id = $args['media']['media'];
		$media_url = wp_get_attachment_url($args['media']['media']);
		$media_meta = wp_get_attachment_metadata($args['media']['media']);

		if (!empty($args['media']['ratio']) and $args['media']['ratio'] !== 'auto') {
			$media_classes[] = 'ratio--' . $args['media']['ratio'];
		}
	}

	# Portrait
	if (!empty($args['media']['media_portrait'])) {
		$media_portrait_id = $args['media']['media_portrait'];
		$media_portrait_url = wp_get_attachment_url($args['media']['media_portrait']);
		$media_portrait_meta = wp_get_attachment_metadata($args['media']['media_portrait']);
		$media_classes[] = 'portrait:hide';
		$media_portrait_classes[] = 'portrait:show';

		if (!empty($args['media']['ratio_portrait']) and $args['media']['ratio_portrait'] !== 'auto') {
			$media_portrait_classes[] = 'ratio--' . $args['media']['ratio_portrait'];
		}
	}
?>

<?php if ($media_url) : ?>
	<figure class="<?php echo $args['class'] ?>">
		<div class="<?php echo implode(' ', $media_classes) ?>">
			<?php if (isset($media_meta['mime_type']) and strpos($media_meta['mime_type'], 'video') !== false) : ?>
				<video
					src="<?php echo $media_url ?>"
					width="<?php echo $media_meta['width'] ?>"
					height="<?php echo $media_meta['height'] ?>"
					<?php echo implode(' ', $args['video_args']) ?>
				></video>
			<?php else : ?>
				<?php echo wp_get_attachment_image($media_id, $args['size'], false, ['loading' => $args['loading']]) ?>
			<?php endif ?>
		</div>
		<?php if ($media_portrait_url) : ?>
			<div class="<?php echo implode(' ', $media_portrait_classes) ?>">
				<?php if (isset($media_portrait_meta['mime_type']) and strpos($media_portrait_meta['mime_type'], 'video') !== false) : ?>
					<video
						src="<?php echo $media_portrait_url ?>"
						width="<?php echo $media_portrait_meta['width'] ?>"
						height="<?php echo $media_portrait_meta['height'] ?>"
						<?php echo implode(' ', $args['video_args']) ?>
					></video>
				<?php else : ?>
					<?php echo wp_get_attachment_image($media_portrait_id, $args['size_portrait'], false, ['loading' => $args['loading']]) ?>
				<?php endif ?>
			</div>
		<?php endif ?>
	</figure>
<?php endif ?>