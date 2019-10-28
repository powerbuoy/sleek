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

		# Or first post of same post type
		$next = $next ? $next : get_posts([
			'post_type' => get_post_type(),
			'numberposts' => 1
		])[0];

		return [$next];
	}
}
