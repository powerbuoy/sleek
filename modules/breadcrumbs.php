<?php if (function_exists('bcn_display')) : ?>
	<nav id="breadcrumbs">
		<?php bcn_display() ?>
	</nav>
<?php elseif (function_exists('yoast_breadcrumb') and $bc = yoast_breadcrumb('', '', false)) : ?>
	<nav id="breadcrumbs">
		<?php echo $bc ?>
	</nav>
<?php endif ?>
