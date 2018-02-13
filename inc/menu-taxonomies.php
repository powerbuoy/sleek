<?php
# Automatically inserts taxonomy terms as children of menu items with a "taxonomy-${tax_name}" class
add_filter('wp_nav_menu_items', function ($items) {
	# Match every li with a class
	preg_match_all('|<li class="(.*?)">(.*?)</li>|', $items, $matches);

	if (isset($matches[1]) and count($matches[1])) {
		# Check all the classes
		foreach ($matches[1] as $classes) {
			$classes = explode(' ', $classes);

			# All of them...
			foreach ($classes as $class) {
				# If one is prefixed with 'taxonomy-'
				if (substr($class, 0, strlen('taxonomy-')) == 'taxonomy-') {
					$tax = substr($class, strlen('taxonomy-'));

					# Get all categories
					$taxList = wp_list_categories([
						'taxonomy' => $tax,
						'title_li' => false,
						'show_option_all' => false,
						'echo' => false
					]);

					# If there are no categories, don't display anything
					if (strpos($taxList, 'cat-item-none') !== false) {
						$taxList = false;
					}

					# Inject the list of categories
					if ($taxList) {
						$items = preg_replace('|<li class="(.*?)taxonomy-' . $tax . '(.*?)">(.*?)</li>|', '<li class="dropdown \1taxonomy-' . $tax . '\2">\3<ul class="dropdown-menu">' . $taxList . '</ul></li>', $items);
					}
				}
			}
		}
	}

	return $items;
});
