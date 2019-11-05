<?php
namespace Sleek\Modules;

class LatestPosts extends Module {
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
				'name' => 'limit',
				'label' => __('Number of Posts', 'sleek'),
				'type' => 'number',
				'default_value' => 3
			],
			[
				'name' => 'category',
				'label' => __('Category', 'sleek'),
				'type' => 'taxonomy',
				'taxonomy' => 'category',
				'field_type' => 'multi_select',
				'multiple' => true,
				'allow_null' => true,
				'return_format' => 'id'
			]
		];
	}

	public function data () {
		return [
			'rows' => self::get_latest_posts($this->get_field('category'), $this->get_field('limit'))
		];
	}

	public static function get_latest_posts ($category = null, $limit = 3) {
		global $post;

		$args = [
			'post_type' => 'post',
			'numberposts' => $limit
		];

		# Ignore post we're on
		if (is_single()) {
			$args['post__not_in'] = [$post->ID];
		}

		# Specific category
		if ($category) {
			$args['tax_query'] = [
				[
					'taxonomy' => 'category',
					'field' => 'id',
					'terms' => $category
				]
			];
		}

		return get_posts($args);
	}
}
