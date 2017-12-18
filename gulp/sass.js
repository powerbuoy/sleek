var gulp = require('gulp');
var sass = require('gulp-sass');
var sassGlob = require('gulp-sass-glob');
var sourcemaps = require('gulp-sourcemaps');
var autoprefixer = require('gulp-autoprefixer');
var cleanCss = require('gulp-clean-css');

module.exports = function (file, dest) {
	return gulp.src(file)
		.pipe(sourcemaps.init())
		.pipe(sassGlob())
		.pipe(sass()) // Don't use {outputStyle: 'compressed'} - it fucks up CSS selectors like .bg--white
		.on('error', sass.logError)
		.pipe(autoprefixer({
			browsers: ['last 1 version', 'IE 9', 'IE 10', '> 2%', 'Safari >= 8'],
			grid: true
		}))
		.pipe(cleanCss())
		.pipe(sourcemaps.write('./'))
		.pipe(gulp.dest(dest));
};
