<?php
/*
	Description: Add a menu to the page.
 */
namespace Sleek\Modules;

class Menu extends Module {
	public function fields () {
		return [
			[
				'name' => 'title',
				'label' => __('Title', 'sleek'),
				'type' => 'text'
			],
			[
				'name' => 'description',
				'label' => __('Description', 'sleek'),
				'type' => 'wysiwyg',
				'toolbar' => 'simple',
				'media_upload' => false
			],
			[
				'name' => 'menu',
				'label' => __('Menu', 'sleek'),
				'type' => 'taxonomy',
				'taxonomy' => 'nav_menu',
				'field_type' => 'select'
			]
		];
	}
}
