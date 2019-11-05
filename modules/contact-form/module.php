<?php
namespace Sleek\Modules;

class ContactForm extends Module {
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
				'name' => 'form_id',
				'label' => __('Form', 'sleek'),
				'instructions' => __('Select a Contact Form 7 form from the dropdown. Please note that this module requires the Contact Form 7 plug-in: https://wordpress.org/plugins/contact-form-7/', 'sleek'),
				'type' => 'post_object',
				'return_format' => 'id',
				'post_type' => ['wpcf7_contact_form']
			]
		];
	}
}
