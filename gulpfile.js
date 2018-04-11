'use strict';

var gulp = require("gulp");
var sass = require("gulp-sass");
var postcss = require("gulp-postcss");
var autoprefixer = require("autoprefixer");
var cssnano = require("cssnano");
var sourcemaps = require("gulp-sourcemaps");
var concat = require("gulp-concat");
var runSequence = require("run-sequence");
var del = require("del");
var uglify = require("gulp-uglify");
var pump = require("pump");
var wpPot        = require('gulp-wp-pot'); // For generating the .pot file.
var sort         = require('gulp-sort'); // Recommended to prevent unnecessary changes in pot-file.

gulp.task('scss:prod', function () {

	var plugins = [
			autoprefixer(),
			cssnano()
	];

	return gulp.src('./src/scss/**/*.scss')
		.pipe(sass().on('error', sass.logError))
		.pipe(postcss(plugins))
		.pipe(gulp.dest('./dist/css/'))
});

gulp.task('scss:dev', function () {

	var plugins = [
		autoprefixer(),
	];

	return gulp.src('./src/scss/**/*.scss')
		.pipe(sourcemaps.init())
		.pipe(sass().on('error', sass.logError))
		.pipe(postcss(plugins))
		.pipe(sourcemaps.write('./'))
		.pipe(gulp.dest('./dist/css/'))

});

gulp.task('default', function () {
});

gulp.task('copy:js', function() {
    return gulp.src([
      './node_modules/jquery/dist/jquery.slim.min.js',
      './node_modules/popper.js/dist/umd/popper.min.js',
      './node_modules/bootstrap/dist/js/bootstrap.min.js',
    ])
    .pipe(gulp.dest('dist/js/'));
});

gulp.task('js', function (cb) {
  pump([
    gulp.src('./src/js/**/*.js'),
    concat('theme.js'),
    uglify(),
    gulp.dest('./dist/js')
  ],
  cb
);
});



// clean out 'dist' directory
gulp.task('clean', function() {
  return del(['dist/**', '!dist']).then(paths => {
		    console.log('Files and folders that were deleted:\n', paths.join('\n'));
		});

});


// build for prod
gulp.task('build', function() {
		runSequence( 'clean', [ 'scss:prod', 'js:prod', 'copy:js' ]);
});


// watch and build for dev
gulp.task('watch', function() {

	gulp.watch('./src/scss/**/*.scss', [ 'scss:dev' ]);
	gulp.watch('./src/js/**/*.js', [ 'js' ]);

});

 /**
  * WP POT Translation File Generator.
  *
  * * This task does the following:
  *     1. Gets the source of all the PHP files
  *     2. Sort files in stream by path or any custom sort comparator
  *     3. Applies wpPot with the variable set at the top of this file
  *     4. Generate a .pot file of i18n that can be used for l10n to build .mo file
  */
 gulp.task( 'translate', function () {
     return gulp
       .src("**/*.php")
       .pipe(sort())
       .pipe(wpPot({
           domain: "bootstrap-twig",
           package: "Bootstrap Twig",
           bugReport: "https://rexrana.ca/contact/",
           lastTranslator: "Peter Hebert <peter@rexrana.ca>"
         }))
       .pipe(gulp.dest("./languages/bootstrap-twig.pot"));
 });
