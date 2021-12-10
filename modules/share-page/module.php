<?php
# Description: Display social media links for sharing the current URL.

namespace Sleek\Modules;

class SharePage extends Module {
	public function fields () {
		return [
			[
				'name' => 'title',
				'label' => __('Title', 'sleek_admin'),
				'type' => 'text'
			],
			[
				'name' => 'description',
				'label' => __('Description', 'sleek_admin'),
				'type' => 'wysiwyg',
				'toolbar' => 'simple',
				'media_upload' => false
			],
			[
				'name' => 'url',
				'label' => __('(Optional) enter a specific URL to share', 'sleek_admin'),
				'instructions' => __('If left empty the URL of the page will be used.', 'sleek_admin'),
				'type' => 'url'
			],
			[
				'name' => 'services',
				'label' => __('Select sharing methods', 'sleek_admin'),
				'type' => 'checkbox',
				# NOTE: Key => Value is required for default_value to work for some reason... (simply 'Facebook', 'Twitter' etc won't work)
				'choices' => [
					'Facebook' => 'Facebook',
					'Twitter' => 'Twitter',
					'LinkedIn' => 'LinkedIn',
					'Email' => 'Email'
				],
				'default_value' => [
					'Facebook',
					'Twitter',
					'LinkedIn',
					'Email'
				]
			]
		];
	}

	public function data () {
		return [
			'urls' => self::get_urls($this->get_field('url'))
		];
	}

	public static function get_urls ($url = null) {
		global $post;
		global $wp;

		# NOTE: https://github.com/bradvin/social-share-urls
		$urls = [
			'Facebook' => 'https://www.facebook.com/sharer.php?u={url}',
			'Twitter' => 'https://twitter.com/intent/tweet?url={url}&text={title}',
			'LinkedIn' => 'https://www.linkedin.com/shareArticle?url={url}&title={title}',
			'Google Plus' => 'https://plus.google.com/share?url={url}',
			'Email' => 'mailto:?subject={title}&body={url}'
		];

		$url = $url ? $url : home_url(add_query_arg($_GET, $wp->request));
		$title = wp_title(' - ', false, 'right') . get_bloginfo('name');

		foreach ($urls as $service => $u) {
			if ($service == 'Email') {
				$urls[$service] = str_replace(['{url}', '{title}'], [$url, $title], $u);
			}
			else {
				$urls[$service] = str_replace(['{url}', '{title}'], [urlencode($url), urlencode($title)], $u);
			}
		}

		return $urls;
	}
}
