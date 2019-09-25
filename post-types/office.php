<?php
namespace Sleek\PostTypes;

class Office extends PostType {
	public function config () {
		return [
			'menu_icon' => 'dashicons-admin-multisite',
			'public' => true,
			'show_ui' => true,
			'has_single' => false, # TODO: Add support for this in sleek-post-types
			'hide_from_search' => true, # TODO: Add support for this in sleek-post-types
			'taxonomies' => ['office_category', 'city'] # TODO: Add support for this in sleek-post-types
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
