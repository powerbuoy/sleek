<?php
function sleek_attachment_archives ($slug = 'url_media', $textdomain = 'sleek', $taxonomies = []) {
	# Give attachment post type archive and slug
	# https://wordpress.org/ideas/topic/archive-attachmentphp
	/* add_filter('register_post_type_args', function ($args, $postType) {
		if ($postType == 'attachment'){
			$args['has_archive'] = true;
			$args['rewrite'] = [
				'slug' => __($slug, $textdomain)
			];
		}

		return $args;
	}, 10, 2); */

	/* $obj = get_post_type_object('attachment');

	$obj->has_archive = true;
	$obj->rewrite = [
		'slug' => __($slug, $textdomain)
	]; */

	# Remove post parent when uploading attachments
	add_action('add_attachment', function ($postId) {
		wp_update_post([
			'ID' => $postId,
			'post_parent' => 0
		]);
	});

	# Include attachments in taxonomy archives
	# http://wordpress.stackexchange.com/questions/29635/how-to-create-an-attachments-archive-with-working-pagination
	if (count($taxonomies)) {
		add_action('parse_query', function () use ($taxonomies) {
			global $wp_query;

			$isTax = false;

			# See if we're on one of our attachment taxonomies
			foreach ($taxonomies as $tax) {
				if (is_tax($tax)) {
					$isTax = true;
				}
			}

			# When inside a custom taxonomy archive include attachments
			if ($isTax) {
				$wp_query->query_vars['post_type'] = ['attachment'];
				$wp_query->query_vars['post_status'] =  [null];

				return $wp_query;
			}
		});
	}
}
