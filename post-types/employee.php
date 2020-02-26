<?php
namespace Sleek\PostTypes;

class Employee extends PostType {
	public function created () {
		# Make employee business area non public
		add_filter('register_taxonomy_args', function ($args, $taxonomy) {
			if ($taxonomy === 'employee_business_area') {
				$args['public'] = false;
				$args['show_ui'] = true;
			}

			return $args;
		}, 10, 2);

		# Show all employees in archive
		add_action('pre_get_posts', function ($query) {
			if (!is_admin() and $query->is_main_query()) {
				if (is_post_type_archive('employee')) {
					$query->set('posts_per_page', -1);
					$query->set('orderby', 'post_title');
					$query->set('order', 'asc');
				}
			}
		});
	}

	public function config () {
		return [
			'menu_icon' => 'dashicons-businesswoman',
			'has_single' => false,
			'hide_from_search' => true,
			'taxonomies' => ['employee_business_area']
		];
	}

	public function fields () {
		return [
			[
				'name' => 'job_title',
				'label' => __('Job Title', 'sleek'),
				'type' => 'text'
			],
			[
				'name' => 'phone',
				'label' => __('Phone', 'sleek'),
				'type' => 'text'
			],
			[
				'name' => 'email',
				'label' => __('E-mail', 'sleek'),
				'type' => 'email'
			]
		];
	}
}
