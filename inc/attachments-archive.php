<?php
# TODO: Deprecate
function sleek_attachment_archives ($slug = 'attachments', $taxonomies = []) {
	# Give attachments an archive page
	# Doesn't work :/
	# https://wordpress.org/ideas/topic/archive-attachmentphp
	/* add_filter('register_post_type_args', function ($args, $postType) {
		if ($postType == 'attachment'){
			$args['has_archive'] = true;
			$args['rewrite'] = [
				'slug' => $slug
			];
		}

		return $args;
	}, 10, 2); */

	# This doesn't work either... :/
	/* $obj = get_post_type_object('attachment');

	$obj->has_archive = true;
	$obj->rewrite = [
		'slug' => $slug
	]; */

	# Remove post parent when uploading attachments (to keep attachment-URLs the same)
	# TODO: This works fine when uploading an attachment directly to a post - but if the attachment is
	# first uploaded and _then_ added to a post it will still get "attached" to that post...
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
				$wp_query->query_vars['post_status'] = [null]; # TODO: Is this needed?

				return $wp_query;
			}
		});
	}
}
