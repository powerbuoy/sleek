<?php
namespace Sleek\Modules;

class ModulesShowcase extends Module {
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
			]
		];
	}

	public function data () {
		return [
			'modules' => self::get_modules()
		];
	}

	public static function get_modules () {
		$modules = [];

		foreach (glob(get_stylesheet_directory() . '/modules/**/README.md') as $file) {
			$pathinfo = pathinfo($file);
			$moduleName = basename($pathinfo['dirname']);

			$modules[] = (object) [
				'readme' => file_get_contents($file),
				'name' => $moduleName,
				'title' => \Sleek\Utils\convert_case($moduleName, 'title'),
				'pathinfo' => $pathinfo
			];
		}

		return $modules;
	}
}
