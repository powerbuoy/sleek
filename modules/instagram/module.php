<?php
namespace Sleek\Modules;

class Instagram extends Module {
	public function init () {
		$this->dummy_data();

		add_filter('wpiw_proxy', '__return_true');
	}

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
				'name' => 'username',
				'label' => __('Instagram Username', 'sleek'),
				'instructions' => __('Enter the Instagram username here. Please note that this module requires the WP Instagram Widget plug-in: https://github.com/scottsweb/wp-instagram-widget', 'sleek'),
				'type' => 'text'
			],
			[
				'name' => 'limit',
				'label' => __('Number of Images', 'sleek'),
				'type' => 'number',
				'default_value' => 4
			]
		];
	}

	private function dummy_data () {
		add_filter('sleek/modules/dummy_field_value', function ($value, $field, $module) {
			if ($field['name'] === 'username' and $module === 'instagram') {
				return 'albertdrosphotography';
			}
			elseif ($field['name'] === 'limit' and $module === 'instagram') {
				return 4;
			}

			return $value;
		}, 10, 3);
	}
}
