<?php
namespace Sleek\PostTypes;

class Employee extends PostType {
	public function config () {
		return [
			'menu_icon' => 'dashicons-groups',
			'taxonomies' => ['employee_tag', 'city'],
			'taxonomy_config' => [
				'employee_tag' => [
					'public' => false,
					'show_ui' => true
				]
			]
		];
	}
}
