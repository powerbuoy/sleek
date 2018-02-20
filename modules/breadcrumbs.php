<?php if (function_exists('bcn_display')) : ?>
	<nav id="breadcrumbs">
		<?php bcn_display() ?>
	</nav>
<?php elseif (function_exists('yoast_breadcrumb')) : ?>
	<nav id="breadcrumbs">
		<?php yoast_breadcrumb('', '') ?>
	</nav>
<?php endif ?>
