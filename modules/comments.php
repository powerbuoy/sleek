<?php if (have_comments()) : ?>
	<section id="comments">

		<h2>
			<?php comments_number(
				sprintf(__('No comments on "%s"', 'sleek'), get_the_title()),
				sprintf(__('One comment on "%s"', 'sleek'), get_the_title()),
				sprintf(__('%s comments on "%s"', 'sleek'), get_comments_number(), get_the_title())
			) ?>
		</h2>

		<ol>
			<?php wp_list_comments() ?>
		</ol>

		<nav>
			<?php previous_comments_link() ?>
			<?php next_comments_link() ?>
		</nav>

	</section>
<?php endif ?>
