<?php
namespace Sleek\Modules;

class InviseModule extends Module {
	public function fields () {
		return [
			[
				'name' => 'content_tab',
				'label' => __('Content', 'sleek_admin'),
				'type' => 'tab',
				'placement' => 'top'
			],
			...$this->content_fields(),
			[
				'name' => 'style_tab',
				'label' => __('Style', 'sleek_admin'),
				'type' => 'tab',
				'placement' => 'top'
			],
			[
				'name' => 'style',
				'label' => __('Style', 'sleek_admin'),
				'type' => 'group',
				'sub_fields' => $this->style_fields(),
				'wrapper' => [
					'class' => 'sleek-module-group' # NOTE: This creates an unstyled group (no border or padding etc)
				]
			]
		];
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
				'name' => 'no_style',
				'label' => __('No style', 'sleek_admin'),
				'type' => 'message',
				'message' => __('There is nothing to style.', 'sleek_admin')
			]
		];
	}
}