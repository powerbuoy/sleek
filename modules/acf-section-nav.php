<?php if (have_rows('sections')) : ?>
	<nav id="acf-section-nav">

		<ul>
			<?php while (have_rows('sections')) : the_row() ?>
				<?php
					$section = get_sub_field('section');
					$sectionName = sleek_array_search_r($section, 'section_name');
					$sectionName = count($sectionName) ? $sectionName[0]['section_name'] : false;
				?>
				<li>
					<a href="#<?php echo $sectionName ?>">
						<?php _e(ucfirst(str_replace('-', ' ', $sectionName))) ?>
					</a>
				</li>
			<?php endwhile ?>
		</ul>

	</nav>
<?php endif ?>
