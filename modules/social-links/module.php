<?php
# Description: Display social media links added to Yoast SEO.

namespace Sleek\Modules;

class SocialLinks extends Module {
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
			]
		];
	}

	public function data () {
		return [
			'links' => self::get_links()
		];
	}

	public static function get_links () {
		$tmp = get_option('wpseo_social');
		$links = [];
		$nicenames = [
			'linkedin' => 'LinkedIn',
			'youtube' => 'YouTube',
			'google_plus' => 'Google+'
		];

		if ($tmp and count($tmp)) {
			foreach ($tmp as $k => $v) {
				# Only grab non empty URLs or "sites"
				if ((substr($k, -3) === 'url' or substr($k, -4) === 'site') and !empty($v)) {
					$url = $k === 'twitter_site' ? 'https://twitter.com/' . $v : $v;
					$name = substr($k, -3) === 'url' ? $name = substr($k, 0, -4) : $name = substr($k, 0, -5);
					$name = isset($nicenames[$name]) ? $nicenames[$name] : ucfirst(str_replace(['_', '-'], ' ', $name));

					$links[] = (object) [
						'name' => $name,
						'url' => $url
					];
				}
			}
		}

		return $links;
	}
}
