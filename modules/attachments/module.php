<?php
# Description: Add a list of files for users to download.

namespace Sleek\Modules;

class Attachments extends Module {
	public function fields () {
		return [
			[
				'name' => 'title',
				'label' => __('Title', 'sleek_admin'),
				'type' => 'text'
			],
			[
				'name' => 'description',
				'label' => __('Title', 'sleek_admin'),
				'type' => 'wysiwyg',
				'toolbar' => 'simple',
				'media_upload' => false
			],
			[
				'name' => 'files',
				'label' => __('Title', 'sleek_admin'),
				'type' => 'repeater',
				'sub_fields' => [
					[
						'name' => 'files_file',
						'label' => __('Title', 'sleek_admin'),
						'type' => 'file',
						'return_format' => 'id'
					]
				]
			]
		];
	}
}
