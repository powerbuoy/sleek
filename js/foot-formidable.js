H5B.plugins.Formidable = {
	init: function () {
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

		$('[placeholder]').placeholder();
	}
};
