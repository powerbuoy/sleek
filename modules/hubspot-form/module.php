<?php
namespace Sleek\Modules;

class HubspotForm extends Module {
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
				'name' => 'form_id',
				'label' => __('Form ID', 'sleek'),
				'type' => 'text'
			]
		];
	}
}
