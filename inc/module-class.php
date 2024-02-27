<?php function sleek_module_class ($styles) {
	$classes[] = 'section';

	\Sleek\Utils\log($styles);

	return implode(' ', $classes);
}