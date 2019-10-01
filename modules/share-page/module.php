<?php
namespace Sleek\Modules;

class SharePage extends Module {
	public function fields () {
		return [
			[
				'name' => 'title',
				'label' => __('Title', 'sleek'),
				'type' => 'text'
			],
			[
				'name' => 'description',
				'label' => __('Description', 'sleek'),
				'type' => 'wysiwyg'
			],
			[
				'name' => 'url',
				'label' => __('(Optional) enter a specific URL to share', 'sleek'),
				'instructions' => __('If left empty the URL of the page will be used.', 'sleek'),
				'type' => 'url'
			],
			[
				'name' => 'services',
				'label' => __('Select sharing methods', 'sleek'),
				'type' => 'checkbox',
				'choices' => [
					'Facebook',
					'Twitter',
					'LinkedIn',
					'Google Plus',
					'Email'
				],
				'default_value' => [
					'Facebook',
					'Twitter',
					'LinkedIn',
					'Google Plus',
					'Email'
				]
			]
		];
	}

	public function data ($data) {
		$data['urls'] = $this->getUrls();

		return $data;
	}

	private function getUrls () {
		global $post;
		global $wp;

		$urls = [
			'Facebook' => 'https://www.facebook.com/sharer.php?u={url}',
			'Twitter' => 'https://twitter.com/intent/tweet?url={url}&text={title}',
			'LinkedIn' => 'https://www.linkedin.com/shareArticle?url={url}&title={title}',
			'Google Plus' => 'https://plus.google.com/share?url={url}',
			'Email' => 'mailto:?subject={title}&body={url}'
		];

		$url = $share_page_url ?? home_url(add_query_arg($_GET, $wp->request));
		$title = wp_title('|', false, 'right');

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

/*
Module::render('share-page', [
	'acf_post_id' => get_the_ID(), # or...
	'acf_post_id' => 'job_archive_meta' # or...
	'data' => [
		'title' => 'Share this page!'
	],
	'template' => 'default'
]);
Module::render([
	'acf_flexible_field' => 'below_content', # module_area instead of acf_flexible_field?
	'acf_post_id' => get_the_ID()
]);
Module::renderFlexible('below_content', get_the_ID() (default)) => Modlue::render(['acf_flexible_field' => 'below_content'])
*/
