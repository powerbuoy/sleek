<?php
namespace Sleek\PostTypes;

class Page extends PostType {
	# created() runs once every page load
	public function created () {
		# Remove editor entirely
	/*	add_action('init', function () {
			remove_post_type_support('page', 'editor');
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
	#	return ['text-block', 'text-blocks'];
	}

	# Non flexible archive modules
	public function sticky_archive_modules () {
	#	return ['sticky-post'];
	}

	# Flexible archive modules
	public function flexible_archive_modules () {
	#	return ['text-block', 'text-blocks'];
	}
}
