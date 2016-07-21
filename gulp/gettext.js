var gulp = require('gulp');
var gettext = require('gulp-gettext');

module.exports = function (path) {
	return gulp.src(path + '**/*.po')
		.pipe(gettext())
		.pipe(gulp.dest(path));
};
