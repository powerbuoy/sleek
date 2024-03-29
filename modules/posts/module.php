<?php
# Description: Display posts in a variety of ways.

namespace Sleek\Modules;

class Posts extends Module {
	protected $postTypes;

	public function __construct () {
		parent::__construct();

		$this->postTypes = [
			'post' => __('Posts', 'sleek_admin')
		];
	}

	public function fields () {
		return [
			# Title / description
			[
				'name' => 'title',
				'label' => __('Title', 'sleek_admin'),
				'type' => 'text'
			],
			[
				'name' => 'description',
				'label' => __('Description', 'sleek_admin'),
				'type' => 'wysiwyg',
				'media_upload' => false,
				'toolbar' => 'basic'
			],
			...$this->posts_fields()
		];
	}

	public function posts_fields () {
		return [
			# Type of posts
			[
				'name' => 'type_of_posts',
				'label' => __('Type of Posts', 'sleek_admin'),
				'type' => 'radio',
				'layout' => 'horizontal',
				'choices' => [
					'auto' => __('Show posts based on filters', 'sleek_admin'),
					'featured' => __('Select which posts to show', 'sleek_admin'),
					'related' => __('Show posts related to another post', 'sleek_admin'),
				#	'user' => __('Show posts from a specific user', 'sleek_admin')
				],
				'default_value' => 'auto'
			],

			######
			# Auto
			[
				'name' => 'auto_group',
				'label' => __('Auto posts', 'sleek_admin'),
				'type' => 'group',
				'conditional_logic' => [
					[
						[
							'field' => '{acf_key}_' . $this->snakeName . '_type_of_posts',
							'operator' => '==',
							'value' => 'auto',
						]
					]
				],
				'sub_fields' => [
					# TODO: Hide this if only one post-type
					[
						'name' => 'post_types',
						'label' => __('Post types', 'sleek_admin'),
						'type' => 'checkbox',
						'choices' => $this->postTypes,
						'default_value' => array_keys($this->postTypes),
						'required' => true
					],
					[
						'name' => 'limit',
						'label' => __('Limit', 'sleek_admin'),
						'type' => 'number',
						'default_value' => 3,
						'required' => true
					],
					# TODO: orderby, category, date-span, only upcoming? only passed? (events for example)
				]
			],

			#########
			# Related
			[
				'name' => 'related_group',
				'label' => __('Related posts', 'sleek_admin'),
				'type' => 'group',
				'conditional_logic' => [
					[
						[
							'field' => '{acf_key}_' . $this->snakeName . '_type_of_posts',
							'operator' => '==',
							'value' => 'related',
						]
					]
				],
				'sub_fields' => [
					[
						'name' => 'original_post',
						'label' => __('Original post', 'sleek_admin'),
						'instructions' => __('Leave this empty to show the currently viewed post\'s related posts (only works on single pages)'),
						'type' => 'post_object',
						'post_type' => array_keys($this->postTypes),
						'return_format' => 'id'
					],
					[
						'name' => 'limit',
						'label' => __('Limit', 'sleek_admin'),
						'type' => 'number',
						'default_value' => 3,
						'required' => true
					]
				]
			],

			######
			# User
			# TODO

			##########
			# Featured
			[
				'name' => 'featured_group',
				'label' => __('Featured posts', 'sleek_admin'),
				'type' => 'group',
				'conditional_logic' => [
					[
						[
							'field' => '{acf_key}_' . $this->snakeName . '_type_of_posts',
							'operator' => '==',
							'value' => 'featured',
						]
					]
				],
				'sub_fields' => [
					[
						'name' => 'featured_rows',
						'label' => __('Featured posts', 'sleek_admin'),
						'type' => 'relationship',
						'post_type' => array_keys($this->postTypes),
						'required' => true
					]
				]
			],
		];
	}

	# Populate the rows data
	public function data () {
		$rows = null;
		$type = $this->get_field('type_of_posts');

		# Auto
		if ($type === 'auto') {
			$args = $this->get_field('auto_group');

			$rows = get_posts([
				'post_type' => $args['post_types'],
				'numberposts' => $args['limit']
			]);
		}
		# Featured
		elseif ($type === 'featured') {
			$args = $this->get_field('featured_group');
			$rows = $args['featured_rows'];
		}
		# Related
		elseif ($type === 'related') {
			$args = $this->get_field('related_group');
			$rows = self::get_related_posts($args['limit'], $args['original_post']);
		}
		# User
		elseif ($type === 'user') {
			# TODO
		}

		return [
			'args' => $args,
			'rows' => $rows
		];
	}

	# Get posts from same category (and post type) as current post (or $postId)
	public static function get_related_posts ($limit = 3, $postId = null) {
		global $post;

		# Default to "current" post (NOTE: This breaks on non single pages)
		if (!$postId) {
			$postId = $post->ID;
		}

		$args = [
			'post_type' => get_post_type($postId),
			'numberposts' => $limit,
			'tax_query' => [
				'relation' => 'OR'
			]
		];

		# Ignore same post
		if (is_single() or is_page()) {
			$args['post__not_in'] = [$postId];
		}

		# Use the same category as the currently viewed post
		$tax = 'category';

		if (get_post_type($postId) !== 'post') {
			$tax = get_post_type($postId) . '_category';
		}

		$ids = wp_get_post_terms($postId, $tax, ['fields' => 'ids']);

		if ($ids and !is_wp_error($ids)) {
			$args['tax_query'][] = [
				'taxonomy' => $tax,
				'field' => 'term_id',
				'terms' => $ids
			];

			return get_posts($args);
		}

		return null;
	}
}
