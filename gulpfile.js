'use strict';
 
const Fiber = require('fibers');
const gulp  = require('gulp');
const sass  = require('gulp-sass');

sass.compiler = require('sass');

const sassGlob     = require('gulp-sass-glob');
const postcss      = require("gulp-postcss");
const autoprefixer = require("autoprefixer");
const cssnano      = require("cssnano");
const sourcemaps   = require("gulp-sourcemaps");
const concat       = require("gulp-concat");
const del          = require("del");
const uglify       = require("gulp-uglify");
const pump         = require("pump");
const replace      = require('gulp-replace');

// For generating the .pot file.
const wpPot = require('gulp-wp-pot');
// Recommended to prevent unnecessary changes in pot-file.
const sort = require('gulp-sort');

// set up paths
var folders = {
  styles: {
      // By using styles/**/*.sass we're telling gulp to check all folders for any sass file
      src: ['./src/scss/**/*.scss', '!./src/scss/block-library/**'],
      // Compiled files will end up in whichever folder it's found in (partials are not compiled)
      dest: './dist/css/'
  },
  js: {
    src: ['./src/js/concat/**/*.js'],
    // By using styles/**/*.sass we're telling gulp to check all folders for any sass file
    copy: [
      './node_modules/jquery/dist/jquery.slim.min.js',
      './node_modules/popper.js/dist/umd/popper.min.js',
      './node_modules/bootstrap/dist/js/bootstrap.min.js',
      './src/js/form-validation.js',
    ],
    // Compiled files will end up in whichever folder it's found in (partials are not compiled)
    dest: './dist/js/'
  },
  php: ['./**/*.php'],
  dist: ['dist/**', '!dist']
};

// Clean assets from 'dist' directory
function clean() {
  return del(folders.dist).then(paths => {
    console.log('Files and folders that were deleted:\n', paths.join('\n'));
  });
}

function css() {

  var plugins = [
    autoprefixer()
  ];
  return gulp
  .src(folders.styles.src)
  .pipe(sassGlob())
  .pipe(sourcemaps.init())
  .pipe(sass({fiber: Fiber, outputStyle: 'expanded'}).on('error', sass.logError))
  .pipe(postcss(plugins))
  .pipe(sourcemaps.write('./'))
  .pipe(gulp.dest(folders.styles.dest));
}
 
function cssprod() {

  var plugins = [
    autoprefixer(),
    cssnano()
  ];
  return gulp
  .src(folders.styles.src)
  .pipe(sassGlob())
  .pipe(sass({fiber: Fiber}).on('error', sass.logError))
  .pipe(postcss(plugins))
  .pipe(gulp.dest(folders.styles.dest));
}

function copyjs() {
  return gulp.src(folders.js.copy)
  .pipe(gulp.dest(folders.js.dest));
}

function js(cb) {
  pump([
    gulp.src(folders.js.src),
    concat('theme.js'),
    uglify(),
    gulp.dest(folders.js.dest)
  ],
  cb);
}

// watch and build for dev
function watchFiles() {
  gulp.watch(folders.styles.src, css);
  gulp.watch(folders.js.src, js);
  gulp.watch(folders.php, translate);
}

 /**
  * WP POT Translation File Generator.
  *
  * * This task does the following:
  *     1. Gets the source of all the PHP files
  *     2. Sort files in stream by path or any custom sort comparator
  *     3. Applies wpPot with the variable set at the top of this file
  *     4. Generate a .pot file of i18n that can be used for l10n to build .mo file
  */
 function translate() {
     return gulp
       .src(folders.php)
       .pipe(sort())
       .pipe(wpPot({
           domain: "bootstrap-twig",
           package: "Bootstrap Twig",
           bugReport: "https://rexrana.ca/contact/",
           lastTranslator: "Peter Hebert <peter@rexrana.ca>"
         }))
        .pipe(replace(/\(C\) ([0-9]{4}) ([A-Za-z ]+)/g, '(C) $1 Rex Rana Design and Development Ltd.'))
       .pipe(gulp.dest("./languages/bootstrap-twig.pot"));
 }

// define complex tasks
const build = gulp.series(clean, gulp.parallel(cssprod, js, copyjs));
const watch = gulp.series(clean, gulp.parallel(css, js, copyjs),watchFiles);

// export tasks
exports.clean = clean;
exports.css = css;
exports.cssprod = cssprod;
exports.build = build;
exports.translate = translate;
exports.js = js;
exports.copyjs = copyjs;
exports.watch = watch;
exports.default = watch;