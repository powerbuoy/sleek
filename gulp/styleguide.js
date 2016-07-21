var gulp = require('gulp');
var plumber = require('gulp-plumber');
var sass = require('gulp-sass');
var sassGlob = require('gulp-sass-glob');
var sourcemaps = require('gulp-sourcemaps');
var autoprefixer = require('gulp-autoprefixer');
var styleguidejs = require('gulp-styleguidejs');

module.exports = function (file, dest) {
	return gulp.src(file)
		.pipe(plumber({
			errorHandler: function (err) {
				console.log(err);
				this.emit('end');
			}
		}))
		.pipe(sassGlob())
		.pipe(sass())
		.pipe(autoprefixer({
			browsers: ['last 1 version', 'IE 9', '> 2%']
		}))
		.pipe(styleguidejs({
			templateCss: __dirname + '/styleguide/style.css',
			templateJs: __dirname + '/styleguide/script.js',
			template: __dirname + '/styleguide/template.jade',
			outputFile: dest + 'styleguide.html'
		}));
};
