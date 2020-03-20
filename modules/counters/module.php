<?php
namespace Sleek\Modules;

class Counters extends Module {
	public function init () {
		$this->dummy_data();
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
				'name' => 'counters',
				'label' => __('Counters', 'sleek'),
				'button_label' => __('Add a Counter', 'sleek'),
				'type' => 'repeater',
				'layout' => 'row',
				'sub_fields' => [
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
						'name' => 'from',
						'label' => __('From', 'sleek'),
						'type' => 'number'
					],
					[
						'name' => 'to',
						'label' => __('To', 'sleek'),
						'type' => 'number'
					],
					[
						'name' => 'unit',
						'label' => __('Unit', 'sleek'),
						'type' => 'text'
					]
				]
			]
		];
	}

	private function dummy_data () {
		add_filter('sleek/modules/dummy_field_value', function ($value, $field, $module) {
			if ($module === 'counters') {
				if ($field['name'] === 'from') {
					return 0;
				}
				elseif ($field['name'] === 'to') {
					return rand(0, 100);
				}
				elseif ($field['name'] === 'unit') {
					return '%';
				}
			}

			return $value;
		}, 10, 3);
	}
}
