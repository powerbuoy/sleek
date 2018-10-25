<?php
# Disable theme updates for sleek and sleek-child
# https://markjaquith.wordpress.com/2009/12/14/excluding-your-plugin-or-theme-from-update-checks/
add_filter('http_request_args', function ($request, $url) {
	# Is a theme update-check happening?
	if (strpos($url, 'http://api.wordpress.org/themes/update-check') === 0 or strpos($url, 'https://api.wordpress.org/themes/update-check') === 0) {
		# Grab list of themes
		$themes = unserialize($request['body']['themes']);

		# Unset our themes
		unset($themes[get_option('template')]); # Sleek
		unset($themes[get_option('stylesheet')]); # Sleek-Child

		# Set new list of themes
		$request['body']['themes'] = serialize($themes);
	}

	return $request;
}, 5, 2);
