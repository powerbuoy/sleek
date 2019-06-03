<?php if ($sub_nav_tree = sleek_get_sub_nav_tree($post)) : ?>
	<nav id="page-menu">

		<header>

			<?php if ($page_menu_title) : ?>
				<h2><?php echo $page_menu_title ?></h2>
			<?php else : ?>
				<h2>
					<a href="<?php echo $sub_nav_tree['url'] ?>">
						<?php echo $sub_nav_tree['title'] ?>
					</a>
				</h2>
			<?php endif ?>

			<?php echo $page_menu_description ?>

		</header>

		<ul>
			<?php echo $sub_nav_tree['children'] ?>
		</ul>

	</nav>
<?php else : ?>
	<p class="error"><?php _e('This page does not have any relatives. You can remove this module until you add some.', 'sleek') ?></p>
<?php endif ?>
