<?php if (have_rows('containers')) : while (have_rows('containers')) : the_row() ?>
	<?php
		# Get the entire container array
		$container = get_sub_field('container');

		# Find the container name block
		$containerName = sleek_array_search_r($container, 'container_name');

		# User has specified a name
		if (count($containerName)) {
			$containerName = $containerName[0]['container_name'];
		}
		# No name
		else {
			$containerName = false;
		}
	?>
	<?php
		if ($templateName = sleek_locate_acf_container_template('wrapper', $containerName)) {
			get_template_part($templateName);
		}
		else {
			echo '<section' . ($containerName ? ' class="' . $containerName . '"' : '' ) .'>';
		}
	?>

		<?php
		 	if (have_rows('container')) {
				while (have_rows('container')) {
					the_row();

					# Ignore container name (it's only used as a wrapper above)
					if (get_row_layout() !== 'container_name') {
						if ($templateName = sleek_locate_acf_container_template(get_row_layout(), $containerName)) {
							get_template_part($templateName);
						}
						else {
							echo '<h2>No template found for: "'
									. get_row_layout()
									. '"</h2><p>Please create <code>modules/acf-containers/'
									. get_row_layout()
									. '.php.</code></p><p>All template data:</p><pre>';
							var_dump($container);
							echo '</pre>';
						}
					}
				}
			}
		?>

	</section>
<?php endwhile; endif ?>
