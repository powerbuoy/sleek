<?php
function sleek_register_acf ($fields) {
	foreach ($fields as $field => $location) {
		$path = 'acf/' . basename($field) . '.php';
		$absPath = locate_template($path);

		if ($absPath) {
			$definition = include $absPath;

			# Get location config
			if (is_array($location) and count($location)) {
				# If first element is not array (acf standard)
				# assume a list of post types are passed in
				if (!is_array($location[0])) {
					$newLocation = [];

					foreach ($location as $pt) {
						$newLocation[] = [
							[
								'param' => 'post_type',
								'operator' => '==',
								'value' => $pt
							]
						];
					}

					$definition['location'] = $newLocation;
				}
				# A normal ACF location array was passed in
				else {
					$definition['location'] = $location;
				}
			}

			# Add definition
			acf_add_local_field_group($definition);
		}
	}
}
