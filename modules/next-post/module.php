<?php
namespace Sleek\Modules;

class NextPost extends Module {
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
				'name' => 'next_post',
				'label' => __('Next post', 'sleek'),
				'instructions' => __('(Optional) Choose a post or let WordPress automatically choose the next post.', 'sleek'),
				'type' => 'relationship',
				'max' => 1
			]
		];
	}

	public function data () {
		$np = $this->get_field('next_post');

		return [
			'rows' => $np ? $np : self::get_next_post()
		];
	}

	public static function get_next_post () {
		# Adjacent post
		$next = get_adjacent_post(false, [], false);

		if (!$next) {
			global $post;

			$args = [
				'post_type' => get_post_type(),
				'numberposts' => 1,
				'orderby' => 'post_date',
				'order' => 'ASC'
			];

			# Ignore post we're on
			if (is_single()) {
				$args['post__not_in'] = [$post->ID];
			}

			# Get first post of same post type
			$next = get_posts($args)[0] ?? null;
		}

		return $next ? [$next] : null;
	}
}
