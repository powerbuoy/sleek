<?php
namespace Sleek\PostTypes;

class Employee extends PostType {
	public function init () {
		# Make employee business area non public
		add_filter('register_taxonomy_args', function ($args, $taxonomy) {
			if ($taxonomy === 'employee_business_area') {
				$args['public'] = false;
				$args['show_ui'] = true;
			}

			return $args;
		}, 10, 2);

		# Show all employees in archive and sort by name
		add_action('pre_get_posts', function ($query) {
			if (!is_admin() and $query->is_main_query()) {
				if (is_post_type_archive('employee')) {
					$query->set('posts_per_page', -1);
					$query->set('orderby', 'post_title');
					$query->set('order', 'asc');

					# NOTE: Even though we show all posts on the first page
					# WP still genereates URLs for pages like /employees/page/123/
					# Make them 404s
					if (is_paged()) {
						status_header(404);
						$query->set_404();
					}
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
