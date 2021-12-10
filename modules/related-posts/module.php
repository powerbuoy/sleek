<?php
# Description: Display posts in the same category as the current post.

namespace Sleek\Modules;

class RelatedPosts extends Module {
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
				'name' => 'limit',
				'label' => __('Number of Posts', 'sleek_admin'),
				'type' => 'number',
				'default_value' => 3
			]
		];
	}

	public function data () {
		return [
			'rows' => self::get_related_posts($this->get_field('limit'))
		];
	}

	public static function get_related_posts ($limit = 3) {
		global $post;

		$args = [
			'post_type' => get_post_type(),
			'numberposts' => $limit,
			'tax_query' => [
				'relation' => 'OR'
			]
		];

		# Ignore same post
		if (is_single() or is_page()) {
			$args['post__not_in'] = [$post->ID];

			# Use the same category as the currently viewed post
			$tax = 'category';

			if (get_post_type() !== 'post') {
				$tax = get_post_type() . '_category';
			}

			$ids = wp_get_post_terms($post->ID, $tax, ['fields' => 'ids']);

			if ($ids and !is_wp_error($ids)) {
				$args['tax_query'][] = [
					'taxonomy' => $tax,
					'field' => 'term_id',
					'terms' => $ids
				];
			}
		}

		return get_posts($args);
	}
}
