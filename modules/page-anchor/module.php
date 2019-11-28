<?php
namespace Sleek\Modules;

class PageAnchor extends Module {
	public function fields () {
		return [
			[
				'name' => 'title',
				'label' => __('Title', 'sleek'),
				'type' => 'text'
			]
		];
	}

	public function data () {
		return [
			'anchor_id' => \Sleek\Utils\convert_case($this->get_field('title'), 'html')
		];
	}

	public static function getAnchors ($where, $id) {
		$modules = get_field($where, $id);
		$anchors = [];

		if ($modules) {
			foreach ($modules as $module) {
				if ($module['acf_fc_layout'] === 'page_anchor') {
					$anchors[] = [
						'title' => $module['title'],
						'id' => \Sleek\Utils\convert_case($module['title'], 'html')
					];
				}
			}
		}

		return count($anchors) ? $anchors : null;
	}
}
