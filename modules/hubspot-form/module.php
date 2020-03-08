<?php
namespace Sleek\Modules;

class HubspotForm extends Module {
	public function init () {
		# If Hubspot API is installed
		if (class_exists('\SevenShores\Hubspot\Factory') and \Sleek\Settings\get_setting('hubspot_api_key')) {
			# Grab all hubspot forms from transient
			$forms = get_transient('hubspot_forms_all');

			if (!$forms) {
				# Or using HS api
				$hs = \SevenShores\Hubspot\Factory::create(\Sleek\Settings\get_setting('hubspot_api_key'));
				$forms = $hs->forms()->all([
					'count' => 1000,
					'property' => ['name', 'guid'] # NOTE: Doesn't work with forms...
				], null, ['http_errors' => false], false);

				# Set a transient
				if ($forms) {
					set_transient('hubspot_forms_all', $forms->data, 60 * 60 * 24);

					$forms = $forms->data;
				}
			}

			# If we still have forms
			if ($forms) {
				# Create a datalist
				add_action('acf/input/admin_footer', function () use ($forms) {
					?>
					<datalist id="hubspot-form-list">
						<?php foreach ($forms as $form) : ?>
							<option value="<?php echo $form->guid ?>"><?php echo $form->name ?></option>
						<?php endforeach ?>
					</datalist>
					<?php
				});

				# Add a list attribute to all hubspot_form_id fields
				add_action('acf/render_field/name=hubspot_form_id', function ($field) {
					?>
					<script>
						document.querySelector('input[name="<?php echo $field['name'] ?>"]').setAttribute('list', 'hubspot-form-list');
					</script>
					<?php
				});
			}
		}
	}

	public function fields () {
		return [
			[
				'name' => 'title',
				'label' => __('Title', 'sleek'),
				'type' => 'text'
			],
			[
				'name' => 'description',
				'label' => __('Description', 'sleek'),
				'type' => 'wysiwyg'
			],
			[
				'name' => 'hubspot_form_id',
				'label' => __('Form ID', 'sleek'),
				'type' => 'text'
			]
		];
	}
}
