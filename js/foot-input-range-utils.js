App.plugins.InputRangeUtils = {
	init: function () {
		this.values();
		this.colors();
	}, 

	values: function () {
		var inputs = document.querySelectorAll('input[type=range]');

		for (var i = 0; i < inputs.length; i++) {
			(function () {
				var input	= inputs[i];
				var label	= document.querySelector('label[for="' + input.id + '"]');
				var type	= input.getAttribute('data-value-type') ? input.getAttribute('data-value-type') : '';
				var typeB	= input.getAttribute('data-value-type-before') ? input.getAttribute('data-value-type-before') : '';
				var value	= document.createElement('span');

				value.classList.add('value');
				label.appendChild(value);

				var updateValue = function () {
					value.innerHTML = typeB + number_format(input.value, 0, ',', ' ') + type;
				};

				updateValue();

				input.addEventListener('input', updateValue);
				input.addEventListener('change', updateValue);
			})();
		}
	}, 

	colors: function () {
		var inputs = document.querySelectorAll('input[type=range]');

		for (var i = 0; i < inputs.length; i++) {
			(function () {
				var input		= inputs[i];
				var leftColor	= '#1c69d3';
				var rightColor	= '#888';

				var updateColor = function () {
					var val = (input.value - input.getAttribute('min')) / (input.getAttribute('max') - input.getAttribute('min'));
						val *= 100;

					input.style.backgroundImage = 'linear-gradient(90deg, ' + leftColor + ' 0%, ' + leftColor + ' ' + val + '%, ' + rightColor + ' ' + val + '%, ' + rightColor + ' 100%)';
				};

				updateColor();

				input.addEventListener('input', updateColor);
				input.addEventListener('change', updateColor);
			})();
		}
	}
};
