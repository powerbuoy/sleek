<?php
# Eable post thumbnails
add_action('after_setup_theme', function () {
	add_theme_support('post-thumbnails');
	set_post_thumbnail_size(150, 150, true);
});

function sleek_register_image_sizes ($width, $height, $crop = ['center', 'center'], $additionalSizes = false) {
	$aspectRatio = $width / $height;

	# Override WP's built-in sizes
	update_option('thumbnail_size_w', ($width * .25));
	update_option('thumbnail_size_h', ($width * .25) / $aspectRatio);
	update_option('thumbnail_crop', 1);

	update_option('medium_size_w', ($width * .5));
	update_option('medium_size_h', ($width * .5) / $aspectRatio);
	update_option('medium_crop', 1);

	update_option('medium_large_size_w', ($width * .75));
	update_option('medium_large_size_h', ($width * .75) / $aspectRatio);
	update_option('medium_large_crop', 1);

	update_option('large_size_w', $width);
	update_option('large_size_h', $height);
	update_option('large_crop', 1);

	# Now set the sizes again so we can specify our own crop (note that if you only use this (and remove the above) users can still change the size in the admin)
	add_image_size('thumbnail', ($width * .25), ($width * .25) / $aspectRatio, $crop);
	add_image_size('medium', ($width * .5), ($width * .5) / $aspectRatio, $crop);
	add_image_size('medium_large', ($width * .75), ($width * .75) / $aspectRatio, $crop);
	add_image_size('large', $width, $height, $crop);

	# Add additional sizes
	if ($additionalSizes) {
		foreach ($additionalSizes as $size => $config) {
			$width = $config['width'];
			$height = $config['height'];
			$aspectRatio = $width / $height;
			$crop = isset($config['crop']) ? $config['crop'] : $crop;

			# Add all 4 size variants for srcset
			add_image_size($size . '_thumbnail', ($width * .25), ($width * .25) / $aspectRatio, $crop);
			add_image_size($size . '_medium', ($width * .5), ($width * .5) / $aspectRatio, $crop);
			add_image_size($size . '_medium_large', ($width * .75), ($width * .75) / $aspectRatio, $crop);
			add_image_size($size . '_large', $width, $height, $crop);
		}

		# Also add our own sizes to the image-size dropdown in the admin
		add_filter('image_size_names_choose', function ($sizes) use ($additionalSizes) {
			$newSizes = [];

			foreach ($additionalSizes as $size => $config) {
				$newSizes[$size . '_thumbnail'] = __(ucfirst(str_replace('_', ' ', $size))) . ' (' . __('Thumbnail') . ')';
				$newSizes[$size . '_medium'] = __(ucfirst(str_replace('_', ' ', $size))) . ' (' . __('Medium') . ')';
				$newSizes[$size . '_medium_large'] = __(ucfirst(str_replace('_', ' ', $size))) . ' (' . __('Medium large') . ')';
				$newSizes[$size . '_large'] = __(ucfirst(str_replace('_', ' ', $size))) . ' (' . __('Large') . ')';
			}

			return array_merge($sizes, $newSizes);
		});
	}
}
