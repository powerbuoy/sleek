<?php
namespace Sleek\PostTypes;

class Office extends PostType {
	public function config () {
		return [
			'menu_icon' => 'dashicons-admin-multisite',
			'has_single' => false,
			'hide_from_search' => true,
			'taxonomies' => ['office_category', 'city']
		];
	}

	public function fields () {
		return [
			[
				'name' => 'address',
				'label' => __('Address', 'sleek'),
				'type' => 'textarea'
			],
			[
				'name' => 'phone',
				'label' => __('Phone', 'sleek'),
				'type' => 'text'
			],
			[
				'name' => 'email',
				'label' => __('E-mail', 'sleek'),
				'type' => 'text'
			]
		];
	}
}
