/**
 * A couple of nice features for input[type=range] 
 * - until it's supported with CSS in all browsers
 *
 * You can change the colors of the input from your child theme with
 * App.plugins.InputRangeUtils.rangeLeftColor = 'red'; for example
 */
var InputRangeUtils = {
	// Init
	init: function () {
		this.values();
		this.colors();
	}, 

	// Appends a span to the label containing the value of the range input
	// Can be prefixed or suffixed by adding a data-value-prefix="$" or data-value-suffix=" years" for example
	values: function () {
		var inputs = document.querySelectorAll('input[type=range]');

		for (var i = 0; i < inputs.length; i++) {
			(function () {
				var input	= inputs[i];
				var label	= document.querySelector('label[for="' + input.id + '"]');
				var prefix	= input.getAttribute('data-value-prefix') ? input.getAttribute('data-value-prefix') : '';
				var suffix	= input.getAttribute('data-value-suffix') ? input.getAttribute('data-value-suffix') : '';
				var minTxt	= input.getAttribute('data-min-text') ? input.getAttribute('data-min-text') : false;
				var maxTxt	= input.getAttribute('data-max-text') ? input.getAttribute('data-max-text') : false;
				var value	= document.createElement('span');

				value.classList.add('value');
				label.appendChild(value);

				var updateValue = function () {
					var niceVal = typeof(number_format) == 'undefined' ? input.value : number_format(input.value, 0, ',', ' ');
						niceVal	= prefix + niceVal + suffix;

					niceVal = (input.value == input.getAttribute('max') && maxTxt) ? maxTxt : niceVal;
					niceVal = (input.value == input.getAttribute('min') && minTxt) ? minTxt : niceVal;

					value.innerHTML = niceVal;
				};

				updateValue();

				input.addEventListener('input', updateValue);
				input.addEventListener('change', updateValue);
			})();
		}
	}, 

	// Gives the left and right side of the input different colors (done with CSS for IE11)
	colors: function (leftColor, rightColor) {
		var leftColor = leftColor || '#06c';
		var rightColor = rightColor || '#888';
		var inputs = document.querySelectorAll('input[type=range]');

		for (var i = 0; i < inputs.length; i++) {
			(function () {
				var input = inputs[i];

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
