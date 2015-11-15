<?php if ($title) : ?>
	<h2>
		<?php if ($link_title) : ?>
			<a href="<?php echo $archive_url ?>"><?php echo $title ?></a>
		<?php else : ?>
			<?php echo $title ?>
		<?php endif ?>
		<?php if ($all_link) : ?>
			 <a href="<?php echo $archive_url ?>"><?php echo $all_link ?></a>
		<?php endif ?>
	</h2>
<?php endif ?>

<?php if ($rows) : ?>
	<ul>
		<?php global $post; foreach ($rows as $post) : setup_postdata($post) ?>
			<?php if (function_exists('simple_fields_register_field_group')) $ytID = simple_fields_fieldgroup('youtube_id_group') ?>
			<li>
				<h3>
					<a href="<?php the_permalink() ?>">
						<?php if (has_post_thumbnail()) : ?>
							<?php if ($ytID) : ?>
								<span class="youtube"><?php the_post_thumbnail($img_size) ?></span> 
							<?php else : ?>
								<?php the_post_thumbnail($img_size) ?> 
							<?php endif ?>
						<?php elseif ($ytID) : ?>
							<span class="youtube"><img src="//img.youtube.com/vi/<?php echo $ytID ?>/maxresdefault.jpg"></span> 
						<?php endif ?>
						<?php the_title() ?>
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
