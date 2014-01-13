<!doctype html>

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

<!--[if lt IE 7]><html id="<?php echo $htmlID ?>" <?php language_attributes() ?>class="<?php echo $htmlClasses ?> no-js lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if IE 7]><html id="<?php echo $htmlID ?>" <?php language_attributes() ?>class="<?php echo $htmlClasses ?> no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if IE 8]><html id="<?php echo $htmlID ?>" <?php language_attributes() ?>class="<?php echo $htmlClasses ?> no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--><html id="<?php echo $htmlID ?>" <?php language_attributes() ?>class="<?php echo $htmlClasses ?> no-js"><!--<![endif]-->
	
	<head>

		<meta charset="<?php bloginfo('charset') ?>">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title><?php wp_title('|', true, 'right') ?> <?php bloginfo('name') ?></title>

		<link rel="profile" href="http://gmpg.org/xfn/11">
  		<link rel="pingback" href="<?php bloginfo('pingback_url') ?>">

		<script>
			AJAX_URL = '<?php echo admin_url('admin-ajax.php') ?>';
		</script>

		<?php wp_head() ?>

	</head>

	<body <?php body_class() ?>>
