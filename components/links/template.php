<?php
	$args = array_merge([
		'links' => null,
		'styles' => [],
		'wrapper_classes' => [
			'links'
		],
		'button_classes' => []
	], $args);

	if (!empty($args['styles']['text_align']) and $args['styles']['text_align'] !== 'inherit') {
		$args['wrapper_classes'][] = 'text--' . $args['styles']['text_align'];
	}
?>

<?php if ($args['links']) : ?>
	<nav class="<?php echo implode(' ', $args['wrapper_classes']) ?>">

		<?php $i = 0; foreach ($args['links'] as $link) : ?>
			<a href="<?php echo $link['link']['url'] ?>"
				class="
					<?php echo $link['link_style'] ?>
					<?php echo strpos($link['link_style'], 'button') !== false ? implode(' ', $args['button_classes']) : '' ?>
				"
				<?php if (!empty($link['link']['target'])) : ?>
					target="<?php echo $link['link']['target'] ?>"
				<?php endif ?>
			>
				<?php echo $link['link']['title'] ?>
			</a>
		<?php endforeach ?>

	</nav>
<?php endif ?>
