var gulp = require('gulp');
var plumber = require('gulp-plumber');
var sass = require('gulp-sass');
var sassGlob = require('gulp-sass-glob');
var sourcemaps = require('gulp-sourcemaps');
var autoprefixer = require('gulp-autoprefixer');
var styleguidejs = require('gulp-styleguidejs');

module.exports = function (file, dest) {
	return gulp.src(file)
		.pipe(plumber())
		.pipe(sassGlob())
		.pipe(sass())
		.pipe(autoprefixer({
			browsers: ['last 1 version', 'IE 9', '> 2%']
		}))
		.pipe(styleguidejs(dest + 'styleguide.html', {
			templateCss: '../sleek/styleguide/style.css',
			templateJs: '../sleek/styleguide/script.js',
			template: '../sleek/styleguide/template.jade'
		}))
		.pipe(gulp.dest(dest));
};
