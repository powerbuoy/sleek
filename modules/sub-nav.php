<?php
	global $post;

	$sub_nav_tree = sleek_get_sub_nav_tree($post);
?>

<?php if ($sub_nav_tree['children']) : ?>
	<nav id="sub-nav">

		<h2><a href="<?php echo $sub_nav_tree['url'] ?>"><?php echo $sub_nav_tree['title'] ?></a></h2>
	
		<ul>
			<?php echo $sub_nav_tree['children'] ?>
		</ul>

	</nav>
<?php endif ?>
