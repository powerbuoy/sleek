<?php
# Automatically inserts taxonomy terms as children of menu items with a "taxonomy-${tax_name}" class
add_filter('wp_nav_menu_items', function ($items) {
	if (strlen($items) == 0) {
		return $items;
	}

	libxml_use_internal_errors(true); # https://stackoverflow.com/questions/9149180/domdocumentloadhtml-error

	# Load the content
	$dom = new DOMDocument();

	# https://stackoverflow.com/questions/8218230/php-domdocument-loadhtml-not-encoding-utf-8-correctly
	$dom->loadHTML('<?xml encoding="utf-8" ?><ul id="sleek-temporary-wrapper">' . $items . '</ul>');

	# Get all Lis
	$lis = $dom->getElementsByTagName('li');
	$appendLater = [];

	foreach ($lis as $li) {
		$classes = $li->getAttribute('class');
		$taxonomy = null;
		$parent = null;

		if (strlen($classes) > 0) {
			$classes = explode(' ', $classes);

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
					$fragment = $dom->createDocumentFragment();
					$fragment->appendXML('<ul class="dropdown-menu">' . $taxList . '</ul>');

					# NOTE: Do not append the children now because that makes this loop we're in iterate over the new elements too
					$appendLater[] = [
						'li' => $li,
						'children' => $fragment
					];
				}
			}
		}
	}

	# Now append them all
	if (count($appendLater)) {
		foreach ($appendLater as $elements) {
			$elements['li']->appendChild($elements['children']);
		}
	}

	libxml_use_internal_errors(false); # Turn on errors again...

	$items = preg_replace('|<ul id="sleek-temporary-wrapper">(.*)</ul>|s', '\1', $dom->saveHTML($dom->getElementById('sleek-temporary-wrapper')));

	return $items;
});
