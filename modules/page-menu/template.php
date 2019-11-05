<?php if ($menu) : ?>
	<nav id="page-menu">

		<header>

			<?php if ($title) : ?>
				<h2><?php echo $title ?></h2>
			<?php else : ?>
				<h2>
					<a href="<?php echo $menu['url'] ?>">
						<?php echo $menu['title'] ?>
					</a>
				</h2>
			<?php endif ?>

			<?php echo $description ?>

		</header>

		<ul>
			<?php echo $menu['children'] ?>
		</ul>

	</nav>
<?php else : ?>
	<p class="error"><?php _e('This page does not have any relatives. You can remove this module until you add some.', 'sleek') ?></p>
<?php endif ?>
