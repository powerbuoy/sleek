var gulp = require('gulp');
var sass = require('gulp-sass');
var sassGlob = require('gulp-sass-glob');
var sourcemaps = require('gulp-sourcemaps');
var autoprefixer = require('gulp-autoprefixer');

module.exports = function (file, dest) {
	return gulp.src(file)
		.pipe(sourcemaps.init())
		.pipe(sassGlob())
		.pipe(sass({style: 'compressed'}))
		.on('error', sass.logError)
		.pipe(autoprefixer({
			browsers: ['last 1 version', 'IE 9', 'IE 10', '> 2%', 'Safari >= 8']
		}))
		.pipe(sourcemaps.write('./'))
		.pipe(gulp.dest(dest));
};
