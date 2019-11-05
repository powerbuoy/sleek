<?php
namespace Sleek\PostTypes;

class Employee extends PostType {
	public function created () {
		add_filter('register_taxonomy_args', function ($args, $taxonomy, $object_type) {
			if ($taxonomy === 'employee_tag') {
				$args['public'] = false;
				$args['show_ui'] = true;
			}

			return $args;
		}, 10, 3);
	}

	public function config () {
		return [
			'menu_icon' => 'dashicons-groups',
			'taxonomies' => ['employee_tag', 'city']
		];
	}
}
