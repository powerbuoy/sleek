<?php
namespace Sleek\PostTypes;

class Page extends PostType {
	# init() runs once every page load
	public function init () {
		# Remove editor entirely
	/*	add_action('registered_post_type', function ($post_type) {
			if ($post_type === 'page') {
				remove_post_type_support('page', 'editor');
			}
		}); */
	}

	# Sidebar/meta acf-fields for this post-type
	public function fields () {
		return [];
	}

	# Non flexible modules
	public function sticky_modules () {
	#	return ['hero'];
	}

	# Flexible modules
	public function flexible_modules () {
	 	return array_values(array_map('basename', array_filter(glob(get_stylesheet_directory() . '/modules/*'), 'is_dir')));
	}
}
