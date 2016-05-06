<?php
if (have_rows('sections')) {
	$sectionNumber = 0;

	while (have_rows('sections')) {
		the_row();

		$sectionNumber++;

		# Get the entire section array
		$section = get_sub_field('section');

		# Find the section name block
		$sectionName = sleek_array_search_r($section, 'section_name');

		# User has specified a name
		if (count($sectionName)) {
			$sectionName = $sectionName[0]['section_name'];
		}
		# No name
		else {
			$sectionName = false;
		}

		# If a wrapper--template exist for this section name - use that
		if ($wrapperTemplate = sleek_locate_acf_section_template('wrapper', $sectionName)) {
			include locate_template($wrapperTemplate . '.php');
		}
		# Default to a section with sectionName classes and a unique ID
		else {
			echo '<section id="acf-section-' . $sectionNumber . '"' . ($sectionName ? ' class="' . $sectionName . '"' : '' ) .'>';
		}

		# Loop each section content block
	 	if (have_rows('section')) {
			while (have_rows('section')) {
				the_row();

				# Ignore section name (it's only used as a wrapper above)
				if (get_row_layout() !== 'section_name') {
					if ($templateName = sleek_locate_acf_section_template(get_row_layout(), $sectionName)) {
						include locate_template($templateName . '.php');
					}
					else {
						echo '<h2>No template found for: "'
								. get_row_layout()
								. '"</h2><p>Please create <code>modules/acf-sections/'
								. get_row_layout()
								. '.php.</code></p><p>All template data:</p><pre>';
						var_dump($section);
						echo '</pre>';
					}
				}
			}
		}

		echo '</section>';
	}
}
?>
