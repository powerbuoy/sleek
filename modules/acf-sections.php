<?php
if (have_rows('sections')) {
	while (have_rows('sections')) {
		the_row();

		# Get the entire section array
		$section = get_sub_field('section');

		# Fields to ignore later in loop
		$ignore = array('section_name', 'section_modifiers', 'background_image');

		# Find the section name block
		$sectionName = sleek_array_search_r($section, 'section_name');
		$sectionName = count($sectionName) ? $sectionName[0]['section_name'] : false;

		# Find the section modifiers block
		$sectionModifiers = sleek_array_search_r($section, 'section_modifiers');
		$sectionModifiers = count($sectionModifiers) ? $sectionModifiers[0]['section_modifiers'] : false;

		# Find the section background image block
		$bgImg = sleek_array_search_r($section, 'background_image');
		$bgImg = count($bgImg) ? sleek_get_img_src_by_id($bgImg[0]['background_image'], 'sleek-hd') : false;

		echo '<section id="' .
				$sectionName .
				'"' .
				($sectionModifiers ? ' class="' . $sectionModifiers . '"' : '') .
				($bgImg ? ' style="background-image: url(' . $bgImg . ')"' : '') .
				'>';

		# Loop each section content block
	 	if (have_rows('section')) {
			while (have_rows('section')) {
				the_row();

				# Ignore some fields
				if (!in_array(get_row_layout(), $ignore)) {
					if ($templateName = sleek_locate_acf_section_template(get_row_layout(), $sectionName . ' ' . $sectionModifiers)) {
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
