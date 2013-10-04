H5B.plugins.HTML5Forms = {
	init: function () {
		// Datepickers
	/*	$('input[type=date]').datepicker({
			showOn:				'both',
			buttonImage:		WEBROOT + 'css/gfx/calendar.gif', 
			buttonImageOnly:	true
		}); */

		// Placeholders for Formidable forms
		$('div.frm_forms').each(function () {
			var container	= $(this);
			var form		= container.find('form');

			// Set placeholder texts
			form.find('label').each(function () {
				var label = $(this).clone();

				label.find('span').remove();

				form.find('#' + label.attr('for')).attr('placeholder', $.trim(label.text()));
			});

			// Set empty selects
			form.find('option[value=""]').each(function () {
				var option	= $(this);
				var select	= option.parent();
				var label	= form.find('label[for="' + select.attr('id') + '"]').clone();

				label.find('span').remove();
				option.html($.trim(label.text()));
			});
		});

		// And older browsers
		$('[placeholder]').placeholder();

		// Validation
		$('form').each(function (i) {
			var form = $(this);

			// Append error containers for inputs with a title attribute
			form.find('input[title], select[title], textarea[title]').each(function (j) {
				var input = $(this);
				var id = 'form-' + i + '-' + input.attr('name') + '-' + j + '-error';

				input.attr('data-h5-errorid', id);

				$('<strong id="' + id + '" class="error"></strong>').appendTo(input.parent()).hide();
			});

			// Validate
			form.h5Validate().submit(function () {
				// HACK: Blur all fields so that validation is run
				form.find(':input').blur();

				// If form has an "error" class or NO "valid" classes - don't submit form
			//	if (form.find('.ui-state-error').length || !form.find('.ui-state-valid').length) {

				// If form has an "error" class - don't submit form
				if (form.find('.ui-state-error').length) {
					form.find('.ui-state-error').eq(0).focus();

					return false;
				}
			});
		});
	}
};
