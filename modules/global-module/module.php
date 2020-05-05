<?php
namespace Sleek\Modules;

class GlobalModule extends Module {
	public function fields () {
		return [
			[
				'name' => 'global_module',
				'label' => __('Select Module', 'sleek'),
				'type' => 'post_object',
				'post_type' => 'sleek_global_module',
				'return_format' => 'id'
			]
		];
	}
}
