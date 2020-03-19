<nav id="in-page-menu">

	<?php if ($anchors = Sleek\Modules\PageAnchor::get_anchors('flexible_modules', get_the_ID())) : ?>
		<?php foreach ($anchors as $anchor) : ?>
			<a href="#<?php echo $anchor['id'] ?>"><?php echo $anchor['title'] ?></a>
		<?php endforeach ?>
	<?php endif ?>

</nav>
