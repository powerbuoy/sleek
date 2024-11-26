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
		],
		'link' => null
	], $args);

	$media_id = null;
	$media_url = null;
	$media_classes = [];
	$media_portrait_id = null;
	$media_portrait_url = null;
	$media_portrait_classes = [];

	# Video embed
	if (!empty($args['media']['video_embed'])) {
		echo '<figure class="media video">' . $args['media']['video_embed'] . '</figure>';
	}
	# Media
	else {
		# Border radius?
		if (!empty($args['media']['border_radius']) and $args['media']['border_radius'] !== 'none') {
			$media_classes[] = 'border-radius--' . $args['media']['border_radius'];
			$media_portrait_classes[] = 'border-radius--' . $args['media']['border_radius'];
		}

		# Default media
		if (!empty($args['media']['media'])) {
			$media_id = $args['media']['media'];
			$media_url = wp_get_attachment_url($args['media']['media']);
			$media_meta = wp_get_attachment_metadata($args['media']['media']);

			if (!empty($args['media']['ratio'])) {
				if ($args['media']['ratio'] !== 'auto') {
					$media_classes[] = 'ratio--' . $args['media']['ratio'];
				}
				else {
					$args['size'] = 'original_' . $args['size'];
				}
			}
		}

		# Portrait
		if (!empty($args['media']['media_portrait'])) {
			$media_portrait_id = $args['media']['media_portrait'];
			$media_portrait_url = wp_get_attachment_url($args['media']['media_portrait']);
			$media_portrait_meta = wp_get_attachment_metadata($args['media']['media_portrait']);
			$media_classes[] = 'portrait:hide';
			$media_portrait_classes[] = 'portrait:show';

			if (!empty($args['media']['ratio_portrait'])) {
				if ($args['media']['ratio_portrait'] !== 'auto') {
					$media_portrait_classes[] = 'ratio--' . $args['media']['ratio_portrait'];
				}
				else {
					$args['size_portrait'] = 'original_' . $args['size_portrait'];
				}
			}
		}

		# Potential link
		$link_url = '';
		$link_target = '';
		$link_start = '';
		$link_end = '';

		if (!empty($args['link'])) {
			# Link to media
			if ($args['link'] === true) {
				$link_url = $media_url;
				$link_target = 'target="_blank"';
			}
			# ACF link / array link
			elseif (!empty($args['link']['url'])) {
				$link_url = $args['link']['url'];
				$link_target = !empty($args['link']['target']) ? 'target="' . $args['link']['target'] . '"' : '';
			}
			# String
			else {
				$link_url = $args['link'];
			}

			$link_start = '<a href="' . $link_url . '" ' . $link_target . '>';
			$link_end = '</a>';
		}
	}
?>

<?php if ($media_url) : ?>
	<figure class="<?php echo $args['class'] ?>">

		<div class="<?php echo implode(' ', $media_classes) ?>">

			<?php echo $link_start ?>

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

			<?php echo $link_end ?>

		</div>

		<?php if ($media_portrait_url) : ?>

			<div class="<?php echo implode(' ', $media_portrait_classes) ?>">

				<?php echo $link_start ?>

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

				<?php echo $link_end ?>

			</div>
		<?php endif ?>

		<?php if (!empty($args['media']['description'])) : ?>
			<figcaption><?php echo $args['media']['description'] ?></figcaption>
		<?php endif ?>

	</figure>
<?php endif ?>