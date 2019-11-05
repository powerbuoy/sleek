<?php
namespace Sleek\Modules;

class Users extends Module {
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
				'type' => 'wysiwyg'
			],
			[
				'name' => 'users',
				'label' => __('Users', 'sleek'),
				'type' => 'user',
				'multiple' => true,
				'allow_null' => false
			]
		];
	}
}
