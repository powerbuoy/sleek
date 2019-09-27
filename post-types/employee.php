<?php
namespace Sleek\PostTypes;

class Employee extends PostType {
	public function config () {
		return [
			'menu_icon' => 'dashicons-groups',
			'public' => false,
			'show_ui' => true,
			'taxonomies' => ['employee_tag', 'city']
		];
	}
}
