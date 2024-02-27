<?php
# Description: This is just an example module using some components, the style tab and color-scheme

namespace Sleek\Modules;

class InviseExampleModule extends InviseModule {
	public function content_fields () {
		return [
			...(include get_stylesheet_directory() . '/components/module-header/fields.php')(),
			[
				'name' => 'rows',
				'label' => __('Rows', 'sleek_admin'),
				'type' => 'text',
				'type' => 'repeater',
				'layout' => 'row',
				'sub_fields' => [
					[
						'name' => 'title',
						'label' => __('Title', 'sleek_admin'),
						'type' => 'text',
						'required' => true
					],
					[
						'name' => 'description',
						'label' => __('Description', 'sleek_admin'),
						'type' => 'wysiwyg',
						'toolbar' => 'basic',
						'media_upload' => false
					],
					...(include get_stylesheet_directory() . '/components/media/fields.php')($this->snakeName . '_rows', [
						'ratio' => false # NOTE: We prodivde ratio settings for _all_ rows in the styles tab instead
					]),
					...(include get_stylesheet_directory() . '/components/links/fields.php')()
				]
			],
			...(include get_stylesheet_directory() . '/components/links/fields.php')()
		];
	}

	public function style_fields () {
		return [
			...(include get_stylesheet_directory() . '/components/color-scheme/styles.php')($this->snakeName),
			...(include get_stylesheet_directory() . '/components/module-header/styles.php')(),
			...(include get_stylesheet_directory() . '/components/links/styles.php')(),
			[
				'name' => 'rows',
				'label' => __('Rows', 'sleek_admin'),
				'type' => 'group',
				'sub_fields' => [
					...(include get_stylesheet_directory() . '/components/ratio.php')([
						'name' => 'media_ratio',
						'label' => __('Ratio for all Media', 'sleek_admin')
					]),
					...(include get_stylesheet_directory() . '/components/ratio.php')([
						'name' => 'media_ratio_portrait',
						'label' => __('Ratio for all Portrait Media', 'sleek_admin')
					])
				]
			]
		];
	}

	public function data () {
		# Use the ratios from the styles tab for all media added to rows
		$rows = $this->get_field('rows');
		$styles = $this->get_field('styles');
		$newRows = [];

		foreach ($rows as $row) {
			if (!empty($styles['rows']['media_ratio'])) {
				$row['media']['ratio'] = $styles['rows']['media_ratio'];
			}
			if (!empty($styles['rows']['media_ratio_portrait'])) {
				$row['media']['ratio_portrait'] = $styles['rows']['media_ratio_portrait'];
			}

			$newRows[] = $row;
		}

		return [
			'new_rows' => $newRows
		];
	}
}
