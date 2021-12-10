<?php
# Description: Add a menu to the page.

namespace Sleek\Modules;

class Menu extends Module {
	public function fields () {
		return [
			[
				'name' => 'title',
				'label' => __('Title', 'sleek_admin'),
				'type' => 'text'
			],
			[
				'name' => 'description',
				'label' => __('Description', 'sleek_admin'),
				'type' => 'wysiwyg',
				'toolbar' => 'simple',
				'media_upload' => false
			],
			[
				'name' => 'menu',
				'label' => __('Menu', 'sleek_admin'),
				'type' => 'taxonomy',
				'taxonomy' => 'nav_menu',
				'field_type' => 'select'
			]
		];
	}
}
