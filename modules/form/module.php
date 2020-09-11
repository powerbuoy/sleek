<?php
/*
	Description: Embed a Contact Form 7, Hubspot or arbitrary form.
 */
namespace Sleek\Modules;

class Form extends Module {
	public function init () {
		$this->hubspot_form_field();
		$this->dummy_data();
	}

	public function fields () {
		$fields = [
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
				'name' => 'redirect_url',
				'label' => __('Redirect URL', 'sleek'),
				'type' => 'url'
			],
			[
				'name' => 'form_embed_code',
				'label' => __('Form Embed Code', 'sleek'),
				'type' => 'textarea'
			]
		];

		if (shortcode_exists('contact-form-7')) {
			$fields[] = [
				'name' => 'wpcf7_form_id',
				'label' => __('Contact Form 7', 'sleek'),
				'type' => 'post_object',
				'return_format' => 'id',
				'post_type' => ['wpcf7_contact_form'],
				'allow_null' => true
			];
		}

		if (\Sleek\Settings\get_setting('hubspot_portal_id')) {
			$fields[] = [
				'name' => 'hubspot_form_id',
				'label' => __('Hubspot Form ID', 'sleek'),
				'type' => 'text'
			];
		}

		return $fields;
	}

	# TODO: Move to sleek-hubspot
	private function hubspot_form_field () {
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
					<datalist id="hubspot-forms-list">
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
						document.querySelector('input[name="<?php echo $field['name'] ?>"]').setAttribute('list', 'hubspot-forms-list');
					</script>
					<?php
				});
			}
		}
	}

	# Render a dummy form
	private function dummy_data () {
		add_filter('sleek/modules/dummy_field_value', function ($value, $field, $module) {
			if ($field['name'] === 'form_embed_code' and $module === 'form') {
				return '
					<form>
						<p><input type="text" placeholder="Your Name"></p>
						<p><input type="email" placeholder="Your E-mail"></p>
						<p><textarea rows="20" cols="8" placeholder="Your Message"></textarea></p>
						<p><button>Send</button></p>
					</form>
				';
			}

			return $value;
		}, 10, 3);
	}
}
