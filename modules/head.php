<!DOCTYPE html>

<?php
	if (is_front_page())	$htmlID = 'home-page';
	elseif (is_single())	$htmlID = 'post-page';
	elseif (is_archive())	$htmlID = 'archive-page';
	elseif (is_page())		$htmlID = 'page-page';
	elseif (is_search())	$htmlID = 'search-page';
	else					$htmlID = 'unknown-page';

	$htmlClasses = 'page-' . strtolower(preg_replace('/[^a-zA-Z0-9-_]/', '', wp_title('', false)));
	$htmlClasses .= ' lang-' . get_locale();
?>

<html id="<?php echo $htmlID ?>" <?php language_attributes() ?> class="<?php echo $htmlClasses ?> no-js">
	
	<head>

		<meta charset="<?php bloginfo('charset') ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<title><?php wp_title(' - ', true, 'right') ?></title>

		<script>
			AJAX_URL = '<?php echo admin_url('admin-ajax.php') ?>';
			document.documentElement.className = document.documentElement.className.replace('no-js', 'js');
		</script>

		<?php wp_head() ?>

	</head>

	<body <?php body_class() ?>>
