<?php
###################
# Composer Autoload
require __DIR__ . '/vendor/autoload.php';

######################################
# Modify WP's built in thumbnail sizes
Sleek\ImageSizes\register(1920, 1080, ['center', 'center']/*, [
	'portrait' => ['width' => 1080, 'height' => 1920, 'crop' => ['center', 'top']],
	'square' => ['width' => 1920, 'height' => 1920],
]*/);

################
# 404 some pages
# NOTE: While we wait for has_single PostType setting
# TODO: Create ticket
add_filter('sleek_404s', function () {
	return is_attachment();
});

################
# My custom code
# TODO
