<?php
namespace Sleek\PostTypes;

class Post extends PostType {
	public function created () {
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
		return [
			'labels' => [
				'name' => __('Blogs', 'sleek'),
				'singular_name' => __('Blog', 'sleek'),
			]
		];
	}
}
