<?php
# Hide some unused meta boxes (https://www.vanpattenmedia.com/2014/code-snippet-hide-post-meta-boxes-wordpress)
add_filter('default_hidden_meta_boxes', function ($hidden, $screen) {
	$postTypes = [
		'all' => [
			'revisionsdiv',
			'trackbacksdiv',
			'postcustom',
			'commentstatusdiv',
			'commentsdiv',
			'slugdiv'
		],
		'post' => [
			'tagsdiv-post_tag' # Tags aren't used in this theme (NOTE: Shit assumption!)
		],
		'news' => [
			'pageparentdiv'
		],
		'product' => [
			'pageparentdiv'
		],
		'guide' => [
			'pageparentdiv'
		],
		'case' => [
			'pageparentdiv'
		],
		'vacancy' => [
			'pageparentdiv'
		],
		'office' => [
			'pageparentdiv'
		],
		'employee' => [
			'pageparentdiv'
		]
	];
	$newHidden = $postTypes['all'];

	if (isset($postTypes[$screen->post_type])) {
		$newHidden = array_merge($newHidden, $postTypes[$screen->post_type]);
	}

	return $newHidden;
}, 10, 2);

# TODO: These should be configurable...
# on the other hand we can just keep adding common CPTs here forever since adding filters that don't exist doesn't hurt
$postTypes = ['news', 'product', 'guide', 'case', 'vacancy', 'office', 'employee', 'job', 'post', 'page'];

# Always close Yoast (http://wordpress.stackexchange.com/questions/4381/make-custom-metaboxes-collapse-by-default)
foreach ($postTypes as $pt) {
	add_filter('get_user_option_closedpostboxes_' . $pt, function ($closed) {
		if (empty($closed)) {
			return ['wpseo_meta'];
		}

		return $closed;
	});
}
