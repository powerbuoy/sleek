<?php
# Description: Display a menu tree of pages around the current page.

namespace Sleek\Modules;

class PageMenu extends Module {
	public function fields () {
		return [
			[
				'name' => 'title',
				'label' => __('Title', 'sleek_admin'),
				'instructions' => __("Enter a custom title above the menu or leave blank to display the parent page's title.", 'sleek_admin'),
				'type' => 'text'
			],
			[
				'name' => 'description',
				'label' => __('Description', 'sleek_admin'),
				'type' => 'wysiwyg',
				'toolbar' => 'simple',
				'media_upload' => false
			]
		];
	}

	public function data () {
		global $post;

		return [
			'menu' => self::get_post_tree($post)
		];
	}

	public static function get_post_tree ($post) {
		$allfather = $post;

		if ($post->post_parent) {
			$parent = get_post($post->post_parent);

			while ($parent->post_parent) {
				$parent = get_post($parent->post_parent);
			}

			$allfather = $parent;
			$children = wp_list_pages([
				'post_type' => $post->post_type,
				'child_of' => $parent->ID,
				'echo' => false,
				'link_before' => '',
				'link_after' => '',
				'title_li' => ''
			]);
		}
		else {
			$children = wp_list_pages([
				'post_type' => $post->post_type,
				'child_of' => $post->ID,
				'echo' => false,
				'link_before' => '',
				'link_after' => '',
				'title_li' => ''
			]);
		}

		$title = $allfather->post_title;
		$url = get_permalink($allfather->ID);

		if ($children) {
			return [
				'title' => $title,
				'url' => $url,
				'allfather' => $allfather,
				'children' => $children
			];
		}

		return false;
	}
}
