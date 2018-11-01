<?php
# Automatically inserts taxonomy terms as children of menu items with a "taxonomy-${tax_name}" class
add_filter('wp_nav_menu_items', function ($items) {
	# Match every li with a class
	preg_match_all('|<li class="(.*?)">(.*?)</li>|', $items, $matches);

	if (isset($matches[1]) and count($matches[1])) {
		# Check all the LIs
		foreach ($matches[1] as $classes) {
			$classes = explode(' ', $classes);
			$taxonomy = null;
			$parent = null;

			# And all their classes
			foreach ($classes as $class) {
				if (preg_match('/^taxonomy-parent-(.*?)$/', $class, $matches)) {
					$parent = $matches[1];
				}
				elseif (preg_match('/^taxonomy-(.*?)$/', $class, $matches)) {
					$taxonomy = $matches[1];
				}
			}

			# If we have a taxonomy-foo match
			if ($taxonomy) {
				$args = [
					'taxonomy' => $taxonomy,
					'title_li' => false,
					'show_option_all' => false,
					'echo' => false,
					'hide_empty' => false
				];

				if ($parent) {
					$args['parent'] = $parent;
				}

				# Get all categories
				$taxList = wp_list_categories($args);

				# If there are no categories, don't display anything
				if (strpos($taxList, 'cat-item-none') !== false) {
					$taxList = false;
				}

				# Inject the list of categories
				if ($taxList) {
					$find = '|<li class="(.*?)taxonomy-' . $taxonomy . '(.*?)">(.*?)</li>|';
					$replace = '<li class="dropdown \1taxonomy-' . $taxonomy . '\2">\3<ul class="dropdown-menu">' . $taxList . '</ul></li>';

					if ($parent) {
						$find = '|<li class="(.*?)taxonomy-' . $taxonomy . '(.*?)taxonomy-parent-' . $parent . '(.*?)">(.*?)</li>|';
						$replace = '<li class="dropdown \1taxonomy-' . $taxonomy . '\2taxonomy-parent-' . $parent . '\3">\4<ul class="dropdown-menu">' . $taxList . '</ul></li>';
					}

					$items = preg_replace($find, $replace, $items);
				}
			}
		}
	}

	return $items;
});
