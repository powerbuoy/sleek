<!DOCTYPE html>

<?php
	if (is_front_page())	$htmlID = 'home';
	elseif (is_single())	$htmlID = 'post';
	elseif (is_archive())	$htmlID = 'archive';
	elseif (is_page())		$htmlID = 'page';
	elseif (is_search())	$htmlID = 'search';
	else					$htmlID = 'unknown';
?>

<html id="<?php echo $htmlID ?>-page" <?php language_attributes() ?> <?php body_class('no-js') ?>>
	
	<head>

		<meta charset="<?php bloginfo('charset') ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<?php /* <title><?php echo wp_title(' - ', true, 'right') ?></title> */ ?>
		<title><?php echo strip_tags(str_replace(array('&lt;', '&gt;'), array('<', '>'), wp_title(' - ', false, 'right'))) ?></title>

		<?php wp_head() ?>

	</head>

	<body>
