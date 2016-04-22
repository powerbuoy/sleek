<?php
if (have_rows('containers')) {
	$containerNumber = 0;

	while (have_rows('containers')) {
		the_row();

		$containerNumber++;

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

		# If a wrapper--template exist for this container name - use that
		if ($wrapperTemplate = sleek_locate_acf_container_template('wrapper', $containerName)) {
			include locate_template($wrapperTemplate . '.php');
		}
		# Default to a section with containerName classes and a unique ID
		else {
			echo '<section id="acf-container-' . $containerNumber . '"' . ($containerName ? ' class="' . $containerName . '"' : '' ) .'>';
		}

		# Loop each container content block
	 	if (have_rows('container')) {
			while (have_rows('container')) {
				the_row();

				# Ignore container name (it's only used as a wrapper above)
				if (get_row_layout() !== 'container_name') {
					if ($templateName = sleek_locate_acf_container_template(get_row_layout(), $containerName)) {
						include locate_template($templateName . '.php');
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

		echo '</section>';
	}
}
?>
