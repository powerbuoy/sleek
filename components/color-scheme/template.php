<?php
$args = array_merge([
	'styles' => null
], $args);

if (!empty($args['styles']['media']['media'])) {
	get_template_part('components/media/template', null, [
		'media' => $args['styles']['media'],
		'class' => 'bg'
	]);
}