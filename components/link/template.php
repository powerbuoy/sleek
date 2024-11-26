<?php
	$args = array_merge([
		'link' => null,
		'button_classes' => []
	], $args);
?>

<?php if ($args['link']) : ?>
	<?php
		$classes = [];
		$classes[] = $args['link']['link_style'];

		# If it's any type of button, add potential button_classes
		if (strpos($args['link']['link_style'], 'button') !== false and $args['button_classes']) {
			$classes = array_merge($classes, $args['button_classes']);
		}

		# Add potential icon
		if (!empty($args['link']['icon'])) {
			$classes[] = 'icon-' . $args['link']['icon'];
			$classes[] = 'icon--after';
		}
	?>
	<a href="<?php echo $args['link']['link']['url'] ?>"
		class="<?php echo implode(' ', $classes) ?>"
		<?php if (!empty($args['link']['link']['target'])) : ?>
			target="<?php echo $args['link']['link']['target'] ?>"
		<?php endif ?>
	>
		<?php echo $args['link']['link']['title'] ?>
	</a>
<?php endif ?>