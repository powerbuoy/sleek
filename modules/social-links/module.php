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

		$urlMap = [
			'500px.com' => '500px',
			'amazon.' => 'amazon',
			'apple.com' => 'apple',
			'itunes.com' => 'apple',
			'bandcamp.com' => 'bandcamp',
			'behance.net' => 'behance',
			'blogger.com' => 'blogger',
			'blogspot.com' => 'blogger',
			'codepen.io' => 'codepen',
			'deviantart.com' => 'deviantart',
			'discord.gg' => 'discord',
			'discordapp.com' => 'discord',
			'digg.com' => 'digg',
			'dribbble.com' => 'dribbble',
			'dropbox.com' => 'dropbox',
			'etsy.com' => 'etsy',
			'eventbrite.com' => 'eventbrite',
			'facebook.com' => 'facebook',
			'flickr.com' => 'flickr',
			'foursquare.com' => 'foursquare',
			'ghost.org' => 'ghost',
			'goodreads.com' => 'goodreads',
			'google.com' => 'google',
			'github.com' => 'github',
			'instagram.com' => 'instagram',
			'linkedin.com' => 'linkedin',
			'mailto:' => 'mail',
			'meetup.com' => 'meetup',
			'medium.com' => 'medium',
			'patreon.com' => 'patreon',
			'pinterest.' => 'pinterest',
			'getpocket.com' => 'pocket',
			'ravelry.com' => 'ravelry',
			'reddit.com' => 'reddit',
			'skype.com' => 'skype',
			'skype:' => 'skype',
			'slideshare.net' => 'slideshare',
			'snapchat.com' => 'snapchat',
			'soundcloud.com' => 'soundcloud',
			'spotify.com' => 'spotify',
			'stackoverflow.com' => 'stackoverflow',
			'stumbleupon.com' => 'stumbleupon',
			'telegram.me' => 'telegram',
			'tiktok.com' => 'tiktok',
			'tumblr.com' => 'tumblr',
			'twitch.tv' => 'twitch',
			'twitter.com' => 'twitter',
			'vimeo.com' => 'vimeo',
			'vk.com' => 'vk',
			'whatsapp.com' => 'whatsapp',
			'woocommerce.com' => 'woocommerce',
			'wordpress.org' => 'wordpress',
			'wordpress.com' => 'wordpress',
			'yelp.com' => 'yelp',
			'xanga.com' => 'xanga',
			'youtube.com' => 'youtube'
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

				# Other social urls
				if (substr($k, -4) === 'urls' and is_array($v) and !empty($v)) {
					foreach($v as $url) {
						$host = parse_url($url, PHP_URL_HOST);
						$name = array_filter($urlMap, function($url) use ($host) {
							return str_contains($url, $host) || str_contains($host, $url);
						}, ARRAY_FILTER_USE_KEY);

						$name = reset($name) ? reset($name) : $host;
						$name = isset($nicenames[$name]) ? $nicenames[$name] : ucfirst(str_replace(['_', '-'], ' ', $name));

						$links[] = (object) [
							'name' => $name,
							'url' => $url
						];
					}
				}
			}
		}

		return $links;
	}
}
