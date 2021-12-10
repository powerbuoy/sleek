<?php
# Description: Display either direct children or siblings of the current page.

namespace Sleek\Modules;

class RelatedPages extends Module {
	public function fields () {
		return [
			[
				'name' => 'title',
				'label' => __('Title', 'sleek_admin'),
				'type' => 'text'
			],
			[
				'name' => 'description',
				'label' => __('Description', 'sleek_admin'),
				'type' => 'wysiwyg',
				'toolbar' => 'simple',
				'media_upload' => false
			],
			[
				'name' => 'type',
				'label' => __('Type of pages', 'sleek_admin'),
				'type' => 'radio',
				'allow_null' => false,
				'other_choice' => false,
				'default_value' => 'children',
				'layout' => 'horizontal',
				'return_format' => 'value',
				'choices' => [
					'children' => __('Children', 'sleek_admin'),
					'siblings' => __('Siblings', 'sleek_admin')
				]
			],
			[
				'name' => 'related_page_id',
				'label' => __('Page', 'sleek_admin'),
				'instructions' => __('Select the page whose related pages you want to display or leave empty to display the current page\'s related pages.', 'sleek_admin'),
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
			'rows' => self::get_related_pages($this->get_field('related_page_id'), $this->get_field('type'))
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

		$args = [
			'post_type' => 'page',
			'post_parent' => $postId,
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'numberposts' => -1
		];

	/*	if (is_singular()) {
			$args['post__not_in'] = [$post->ID];
		} */

		if ($postId) {
			return get_posts($args);
		}

		return null;
	}
}
