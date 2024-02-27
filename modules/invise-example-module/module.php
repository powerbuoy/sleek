<?php
# Description: This is just an example module using some components, the style tab and color-scheme

namespace Sleek\Modules;

class InviseExampleModule extends InviseModule {
	public function content_fields () {
		return [
			...(include get_stylesheet_directory() . '/components/module-header/fields.php')(),
			[
				'name' => 'rows',
				'label' => __('Rows', 'sleek_admin'),
				'type' => 'text',
				'type' => 'repeater',
				'layout' => 'row',
				'sub_fields' => [
					[
						'name' => 'title',
						'label' => __('Title', 'sleek_admin'),
						'type' => 'text',
						'required' => true
					],
					[
						'name' => 'description',
						'label' => __('Description', 'sleek_admin'),
						'type' => 'wysiwyg',
						'toolbar' => 'basic',
						'media_upload' => false
					],
					...(include get_stylesheet_directory() . '/components/media/fields.php')($this->snakeName . '_rows'),
					...(include get_stylesheet_directory() . '/components/links/fields.php')()
				]
			],
			...(include get_stylesheet_directory() . '/components/links/fields.php')()
		];
	}

	public function style_fields () {
		return [
			...(include get_stylesheet_directory() . '/components/module-header/styles.php')(),
			...(include get_stylesheet_directory() . '/components/links/styles.php')()
		];
	}
}
