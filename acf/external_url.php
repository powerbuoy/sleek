<?php
	$externalUrl = get_field('external_url');
	$title = isset($title) ? $title : get_the_title($post->ID);
?>

<?php if ($externalUrl) : ?>
	<a href="<?php echo $externalUrl ?>" target="_blank"><?php echo $title ?></a>
<?php endif ?>
