<?php
namespace Sleek\Modules;

class SocialLinks extends Module {
	public function data ($data) {
		$data['links'] = $this->getLinks();

		return $data;
	}

	public function getLinks () {
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

					$links[] = [
						'name' => $name,
						'url' => $url
					];
				}
			}
		}

		return $links;
	}
}
