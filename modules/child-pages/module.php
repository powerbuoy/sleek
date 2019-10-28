<?php
namespace Sleek\Modules;

class ChildPages extends Module {
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
				'name' => 'page_id',
				'label' => __('Page', 'sleek'),
				'instructions' => __('Select the page whose child pages you want to display. If left empty the current page\'s child pages will be displayed.', 'sleek'),
				'type' => 'post_object',
				'post_type' => ['page'],
				'required' => false,
				'allow_null' => true,
				'return_format' => 'id',
				'multiple' => false
			]
		];
	}

	public function data () {
		return [
			'rows' => self::get_child_pages($this->get_field('page_id'))
		];
	}

	public static function get_child_pages ($parent = null) {
		global $post;

		$parentId = $parent ? $parent : $post->ID;

		if ($parentId) {
			return get_posts([
				'post_type' => 'page',
				'post_parent' => $parentId,
				'orderby' => 'menu_order',
				'sort' => 'ASC',
				'numberposts' => -1
			]);
		}
	}
}
