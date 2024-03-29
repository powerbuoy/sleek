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
			<?php
				$classes = [];
				$classes[] = $link['link_style'];

				# If it's any type of button, add potential button_classes
				if (strpos($link['link_style'], 'button') !== false and $args['button_classes']) {
					$classes = array_merge($classes, $args['button_classes']);
				}

				# Add potential icon
				if (!empty($link['icon'])) {
					$classes[] = 'icon-' . $link['icon'];
					$classes[] = 'icon--after';
				}
			?>
			<a href="<?php echo $link['link']['url'] ?>"
				class="<?php echo implode(' ', $classes) ?>"
				<?php if (!empty($link['link']['target'])) : ?>
					target="<?php echo $link['link']['target'] ?>"
				<?php endif ?>
			>
				<?php echo $link['link']['title'] ?>
			</a>
		<?php endif; endforeach ?>

	</nav>
<?php endif ?>

<?php
/*
Before $classes[]:

for some reason the "i" in icon-- is stripped with this code??

class="
	<?php echo $link['link_style'] ?>
	<?php echo strpos($link['link_style'], 'button') !== false ? implode(' ', $args['button_classes']) : '' ?>
	<?php echo !empty($link['icon']) ? 'icon-' . $link['icon'] : '' ?>
"
*/
?>