<?php
namespace Sleek\PostTypes;

class Attachment extends PostType {
	public function created () {
		add_filter('register_taxonomy_args', function ($args, $taxonomy, $object_type) {
			if ($taxonomy === 'attachment_category') {
				$args['public'] = false;
				$args['show_ui'] = true;
			}

			return $args;
		}, 10, 3);
	}

	public function config () {
		return [
			'taxonomies' => ['attachment_category']
		];
	}
}
