<?php
	$args = array_merge([
		'links' => null,
		'styles' => []
	], $args);
?>

<?php if ($args['links']) : ?>
	<nav class="links">

		<?php $i = 0; foreach ($args['links'] as $link) : ?>
			<a href="<?php echo $link['link']['url'] ?>"
				class="button"
				<?php if (!empty($link['link']['target'])) : ?>
					target="<?php echo $link['link']['target'] ?>"
				<?php endif ?>
			>
				<?php echo $link['link']['title'] ?>
			</a>
		<?php endforeach ?>

	</nav>
<?php endif ?>
