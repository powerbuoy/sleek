<?php if (have_comments()) : ?>
	<section id="comments">

		<h2><?php comments_number() ?></h2>

		<ol>
			<?php wp_list_comments() ?>
		</ol>

		<nav>
			<?php previous_comments_link() ?>
			<?php next_comments_link() ?>
		</nav>

	</section>
<?php endif ?>
