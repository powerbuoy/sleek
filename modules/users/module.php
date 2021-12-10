<?php
# Description: Display WordPress users.

namespace Sleek\Modules;

class Users extends Module {
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
				'name' => 'users',
				'label' => __('Users', 'sleek_admin'),
				'type' => 'user',
				'multiple' => true,
				'allow_null' => false
			]
		];
	}
}
