<?php
# Description: Embed a Contact Form 7, Hubspot or arbitrary form.

namespace Sleek\Modules;

class Form extends Module {
	public function init () {
		$this->hubspot_form_field();
		$this->dummy_data();

		# Remove CF7 CSS & JS & <p>
		add_filter('wpcf7_autop_or_not', '__return_false');
		add_filter('wpcf7_load_css', '__return_false');
		add_filter('wpcf7_load_js', '__return_false');

		# Add required attribute to CF7 forms
		add_filter('wpcf7_form_elements', function ($content) {
			# Add required attribute
			$content = str_replace('aria-required="true"', 'required="true" aria-required="true"', $content);

			return $content;
		});
	}

	public function fields () {
		$fields = [
			[
				'name' => 'title',
				'label' => __('Title', 'sleek_admin'),
				'type' => 'text'
			],
			[
				'name' => 'description',
				'label' => __('Description', 'sleek_admin'),
				'type' => 'wysiwyg',
				'toolbar' => 'simple',
				'media_upload' => false
			],
			...$this->form_fields()
		];

		return $fields;
	}

	# Return only form fields (can be used by other modules like HeroForm)
	public function form_fields($module = 'form') {
		# Add form type radio button
		if (shortcode_exists('contact-form-7') or \Sleek\Settings\get_setting('hubspot_portal_id')) {
			$choices = ['custom' => __('Custom form', 'sleek_admin')];

			if (shortcode_exists('contact-form-7')) {
				$choices['cf7'] = __('Contact form 7', 'sleek_admin');
			}

			if (\Sleek\Settings\get_setting('hubspot_portal_id')) {
				$choices['hs'] = __('HubSpot form', 'sleek_admin');
			}

			$fields[] = [
				'name' => 'form_type',
				'type' => 'radio',
				'layout' => 'horizontal',
				'choices' => $choices,
				'default_value' => 'custom'
			];
		}

		# Add custom form embed code field
		$fields[] = [
			'name' => 'form_embed_code',
			'label' => __('Form Embed Code', 'sleek_admin'),
			'type' => 'textarea',
			'conditional_logic' => [[[
				'field' => '{acf_key}_' . $module . '_form_type',
				'operator' => '==',
				'value' => 'custom'
			]]]
		];

		$hasCf7OrHs = false;

		# Add CF7 field
		if (shortcode_exists('contact-form-7')) {
			$hasCf7OrHs = true;
			$fields[] = [
				'name' => 'wpcf7_form_id',
				'label' => __('Contact Form 7', 'sleek_admin'),
				'type' => 'post_object',
				'return_format' => 'id',
				'post_type' => ['wpcf7_contact_form'],
				'allow_null' => true,
				'conditional_logic' => [[[
					'field' => '{acf_key}_' . $module . '_form_type',
					'operator' => '==',
					'value' => 'cf7'
				]]]
			];
		}

		# Add HS field
		if (\Sleek\Settings\get_setting('hubspot_portal_id')) {
			$hasCf7OrHs = true;
			$fields[] = [
				'name' => 'hubspot_form_id',
				'label' => __('Hubspot Form ID', 'sleek_admin'),
				'type' => 'text',
				'conditional_logic' => [[[
					'field' => '{acf_key}_' . $module . '_form_type',
					'operator' => '==',
					'value' => 'hs'
				]]]
			];
		}

		# Add redirect URL (only works with HS or CF7)
		if ($hasCf7OrHs) {
			$fields[] = [
				'name' => 'redirect_url',
				'label' => __('Redirect URL', 'sleek_admin'),
				'type' => 'url',
				'conditional_logic' => [[[
					'field' => '{acf_key}_' . $module . '_form_type',
					'operator' => '!=',
					'value' => 'custom'
				]]]
			];
		}

		return $fields;
	}

	# Autocomplete hubspot form ID field
	private function hubspot_form_field () {
		# If Hubspot API is installed
		if (\Sleek\Settings\get_setting('hubspot_api_key')) {
			# Grab all hubspot forms from transient
			$forms = get_transient('hubspot_forms_all');

			# Or using HS api
			if (!$forms) {
				$response = wp_remote_get('https://api.hubapi.com/marketing/v3/forms/?hapikey=' . \Sleek\Settings\get_setting('hubspot_api_key'));

				if ($response['response']['code'] === 200) {
					$json = json_decode($response['body']);
					$forms = $json->results;

					set_transient('hubspot_forms_all', $forms, 60 * 60 * 24);
				}
			}

			# If we still have forms
			if ($forms) {
				# Create a datalist
				add_action('acf/input/admin_footer', function () use ($forms) {
					?>
					<datalist id="hubspot-forms-list">
						<?php foreach ($forms as $form) : ?>
							<option value="<?php echo $form->id ?>"><?php echo $form->name ?></option>
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
						<p><textarea rows="6" cols="8" placeholder="Your Message"></textarea></p>
						<p><button>Send</button></p>
					</form>
				';
			}

			return $value;
		}, 10, 3);
	}
}
