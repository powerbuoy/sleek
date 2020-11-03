<?php
	if (function_exists('icl_get_languages')) {
		# Get all languages
		$langs = icl_get_languages('skip_missing=0&orderby=code');

		# Add "code" (polylang uses language_code)
		$langs = array_map(function ($lang) {
			$lang['code'] = $lang['code'] ?? $lang['language_code'];
			$lang['code'] = strtoupper($lang['code']);

			return $lang;
		}, $langs);

		# Grab active lang
		$currLang = array_filter($langs, function ($lang) {
			return $lang['active'];
		});
		$currLang = array_values($currLang); # Strip keys
		$currLang = array_shift($currLang); # Fetch first element

		# Remove active
		// $langs = array_filter($langs, function ($lang) {
		// 	return !$lang['active'];
		// });
	}
	else {
		$currLang = [
			'code' => 'EN',
			'native_name' => 'English'
		];
		$langs = [
			[
				'code' => 'EN',
				'url' => '#',
				'native_name' => 'English'
			],
			[
				'code' => 'SV',
				'url' => '#',
				'native_name' => 'Svenska'
			],
			[
				'code' => 'NO',
				'url' => '#',
				'native_name' => 'Norsk'
			]
		];
	}
?>

<?php if ($langs) : ?>
	<ul class="language-menu">
		<li>
			<?php echo $currLang['native_name'] ?>
			<ul>
				<?php foreach ($langs as $lang) : ?>
					<li class="<?php echo $currLang['code'] === $lang['code'] ? 'active' : '' ?>">
						<a href="<?php echo $lang['url'] ?>">
							<?php echo $lang['code'] ?>
						</a>
					</li>
				<?php endforeach ?>
			</ul>
		</li>
	</ul>
<?php endif ?>
