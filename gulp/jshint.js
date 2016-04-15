var gulp = require('gulp');
var jsHint = require('gulp-jshint');

module.exports = function (src) {
	return gulp.src(src + '**/*.js')
		.pipe(jsHint({
			// undef: true, // To check undefined vars
			curly: true,
			forin: true,
			freeze: true,
			latedef: true,
			strict: true,
			unused: true
		}))
		.pipe(jsHint.reporter('jshint-stylish'))
		.pipe(jsHint.reporter('fail'));
};
