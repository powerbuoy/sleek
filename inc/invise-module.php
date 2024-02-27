<?php
# This is a middle-layer between a finished module and Sleek.Module that adds
# Content and Style tabs as well as methods to add fields to both.
# See modules/invise-example-module for an example that uses this class as well as components.
namespace Sleek\Modules;

class InviseModule extends Module {
	public function fields () {
		$fields = [
			[
				'name' => 'content_tab',
				'label' => __('Content', 'sleek_admin'),
				'type' => 'tab',
				'placement' => 'top'
			],
			...$this->content_fields(),
			[
				'name' => 'styles_tab',
				'label' => __('Styles', 'sleek_admin'),
				'type' => 'tab',
				'placement' => 'top'
			],
			[
				'name' => 'styles',
				'label' => __('Styles', 'sleek_admin'),
				'type' => 'group',
				'sub_fields' => $this->style_fields(),
				'wrapper' => [
					'class' => 'sleek-module-group' # NOTE: This creates an unstyled group (no border or padding etc)
				]
			]
		];

		# \Sleek\Utils\log($fields);

		return $fields;
	}

	public function content_fields () {
		return [
			[
				'name' => 'no_content',
				'label' => __('No content', 'sleek_admin'),
				'type' => 'message',
				'message' => __('There is nothing to do here.', 'sleek_admin')
			]
		];
	}

	public function style_fields () {
		return [
			[
				'name' => 'no_styles',
				'label' => __('No styles', 'sleek_admin'),
				'type' => 'message',
				'message' => __('There is nothing to style.', 'sleek_admin')
			]
		];
	}
}