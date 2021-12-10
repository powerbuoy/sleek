<?php
# Description: Add any module or collection of modules that have been created in Global Modules.

namespace Sleek\Modules;

class GlobalModule extends Module {
	public function fields () {
		return [
			[
				'name' => 'global_module',
				'label' => __('Select Module', 'sleek_admin'),
				'type' => 'post_object',
				'post_type' => 'sleek_global_module',
				'return_format' => 'id'
			]
		];
	}
}
