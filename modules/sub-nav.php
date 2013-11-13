<?php
	global $post;

	if (is_page($post)) {
		if ($post->post_parent) {
			$parent = get_page($post->post_parent);

			while ($parent->post_parent) {
				$parent = get_page($parent->post_parent);
			}

			$children = wp_list_pages('title_li=&child_of=' . $parent->ID . '&echo=0&link_before=&link_after=');
			$title = $parent->post_title;
			$url = get_permalink($parent->ID);
		}
		else {
			$children = wp_list_pages('title_li=&child_of=' . $post->ID . '&echo=0&link_before=&link_after=');
			$title = $post->post_title;
			$url = get_permalink($post->ID);
		}
	}
?>

<?php if ($children) : ?>
	<nav id="sub-nav">

		<h2><a href="<?php echo $url ?>"><?php echo $title ?></a></h2>
	
		<ul>
			<?php echo $children ?>
		</ul>

	</nav>
<?php endif ?>
