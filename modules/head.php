<!DOCTYPE html>

<?php
	if (is_front_page())	$htmlID = 'home-page';
	elseif (is_single())	$htmlID = 'post-page';
	elseif (is_archive())	$htmlID = 'archive-page';
	elseif (is_page())		$htmlID = 'page-page';
	elseif (is_search())	$htmlID = 'search-page';
	else					$htmlID = 'unknown-page';
?>

<html id="<?php echo $htmlID ?>" <?php language_attributes() ?> class="<?php echo $htmlClasses ?> no-js">
	
	<head>

		<meta charset="<?php bloginfo('charset') ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<title><?php wp_title(' - ', true, 'right') ?></title>

		<?php wp_head() ?>

	</head>

	<body <?php body_class() ?>>
