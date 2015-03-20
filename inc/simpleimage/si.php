<?php
die('goodbye');
	error_reporting(E_ALL);
	ini_set('display_errors', true);

	$docRoot = $_SERVER['DOCUMENT_ROOT'];

	# Get src/path
	$src = isset($_GET['src']) ? $_GET['src'] : false;

	if (!$src) {
		die('have to set ?src');
	}

	# A little safety
	$src = str_replace('..', '', $src);

	# Get name and extension
	$arr = explode('.', $src);
	$ext = end($arr);
	$name = substr(basename($src), 0, -(strlen($ext) + 1));

	# Remove potential http://
	if (strpos($src, 'http://') === 0) {
		$src = preg_replace('/http:\/\/(.*?)\//', '/', $src);
	}

	# See if it's cached
	$cacheSrc = md5(implode($_GET));
	$cacheSrc = 'cache/' . $cacheSrc . '.' . $ext;

	if (file_exists($cacheSrc)) {
		# TODO: Load file directly and die
	}

	# Get the rest of the params TODO: Add all options: https://github.com/claviska/SimpleImage
	$blur = isset($_GET['blur']) ? $_GET['blur'] : false;

	# Run SimpleImage
	include 'SimpleImage.php';

	try {
		$img = new abeautifulsite\SimpleImage($docRoot . $src);

		# TODO: Add all options
		if ($blur > 0) {
			
		}

		$img->save($cacheSrc);
		$img->output();
	}
	catch (Exception $e) {
		echo $e->getMessage();
	}
?>
