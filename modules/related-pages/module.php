<?php
namespace Sleek\Modules;

class RelatedPages extends Module {
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
				'name' => 'type',
				'label' => __('Type of pages', 'sleek'),
				'type' => 'radio',
				'allow_null' => false,
				'other_choice' => false,
				'default_value' => 'children',
				'layout' => 'horizontal',
				'return_format' => 'value',
				'choices' => [
					'children' => __('Children', 'sleek'),
					'siblings' => __('Siblings', 'sleek')
				]
			],
			[
				'name' => 'page_id',
				'label' => __('Page', 'sleek'),
				'instructions' => __('Select the page whose related pages you want to display or leave empty to display the current page\'s related pages.', 'sleek'),
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
			'rows' => self::get_related_pages($this->get_field('page_id'), $this->get_field('type'))
		];
	}

	public static function get_related_pages ($id = null, $type = 'children') {
		global $post;

		if ($type === 'children') {
			$postId = $id ? $id : $post->ID;
		}
		elseif ($type === 'siblings') {
			$postId = $id ? get_post($id)->post_parent : $post->post_parent;
		}

		if ($postId) {
			return get_posts([
				'post_type' => 'page',
				'post_parent' => $postId,
				'orderby' => 'menu_order',
				'sort' => 'ASC',
				'numberposts' => -1
			]);
		}

		return null;
	}
}
