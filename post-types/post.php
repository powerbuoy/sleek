<?php
namespace Sleek\PostTypes;

class Post extends PostType {
	public function init () {
		# Include all post-types when viewing categories
		add_action('pre_get_posts', function ($query) {
			if (!is_admin() and $query->is_main_query()) {
				if ($query->is_category()) {
					$query->set('post_type', 'any');
				}
			}
		});
	}

	public function config () {
		# Rename "Post"
		return [
			'labels' => [
				'name' => __('Blogs', 'sleek'),
				'singular_name' => __('Blog', 'sleek'),
			]
		];
	}

	# Non flexible archive modules
	public function sticky_archive_modules () {
	#	return ['featured-posts'];
	}

	# Flexible archive modules
	public function flexible_archive_modules () {
	#	return ['text-block', 'text-blocks'];
	}
}
