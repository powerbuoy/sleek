<?php
namespace Sleek\Modules;

class RedirectUrl extends Module {
	public function created () {
		# Make sure the_permalink() points to the redirect URL
		add_filter('the_permalink', function ($url, $postId) {
			if (function_exists('get_field')) {
				$redirectUrl = \get_field('redirect_url', $postId);

				if (isset($redirectUrl['url']) and !empty($redirectUrl['url'])) {
					return $redirectUrl['url'];
				}
			}

			return $url;
		}, 10, 2);

		# Redirect single pages to the redirect URL
		add_action('template_redirect', function () {
			if (is_singular() and function_exists('get_field')) {
				global $post;

				$redirectUrl = \get_field('redirect_url', $post->ID);

				if (isset($redirectUrl['url']) and !empty($redirectUrl['url'])) {
					wp_redirect($redirectUrl['url']);
				}
			}
		}, 10, 1);
	}

	public function fields () {
		return [
			[
				'name' => 'url',
				'label' => __('Redirect URL', 'sleek'),
				'instructions' => __('Enter a URL to have this post redirect there.', 'sleek'),
				'type' => 'url'
			]
		];
	}
}
