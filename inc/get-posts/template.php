<?php if ($title) : ?>
	<h2>
		<?php echo $title ?>
		<?php if ($all_link) : ?>
			 <a href="<?php echo $archive_url ?>"><?php echo $all_link ?></a>
		<?php endif ?>
	</h2>
<?php endif ?>

<?php if ($rows) : ?>
	<ul>
		<?php global $post; foreach ($rows as $post) : setup_postdata($post) ?>
			<li>
				<h3>
					<a href="<?php the_permalink() ?>">
						<?php the_post_thumbnail($img_size) ?> <?php the_title() ?>
					</a>
				</h3>

				<?php if ($excerpt_length) : ?>
					<p><?php echo wp_trim_words(get_the_excerpt(), $excerpt_length) ?></p>
				<?php else : ?>
					<?php the_excerpt() ?>
				<?php endif ?>

				<?php if ($more_link) : ?>
					 <a href="<?php the_permalink() ?>"><?php echo $more_link ?></a>
				<?php endif ?>
			</li>
		<?php endforeach; wp_reset_postdata() ?>
	</ul>
<?php else : ?>
	<p><?php echo $empty ?></p>
<?php endif ?>
