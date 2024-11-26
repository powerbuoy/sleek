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

		<?php $i = 0; foreach ($args['links'] as $link) : if (!empty($link['link']['url'])) : ?>
			<?php get_template_part('components/link/template', null, ['link' => $link]) ?>
		<?php endif; endforeach ?>

	</nav>
<?php endif ?>