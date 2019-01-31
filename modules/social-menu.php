<?php
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
?>

<?php if (count($links)) : ?>
	<nav id="social-menu">

		<ul>
			<?php foreach ($links as $link) : ?>
				<li><a href="<?php echo $link['url'] ?>" target="_blank"><?php echo $link['name'] ?></a></li>
			<?php endforeach ?>
		</ul>

	</nav>
<?php endif ?>
