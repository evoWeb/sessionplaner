'use strict';

// Gulp
const { src, dest, series, watch } = require('gulp');

// Sass
const dartSass = require('sass');
const gulpSass = require('gulp-sass')(dartSass);
const autoprefixer = require('autoprefixer');
const postcss = require('gulp-postcss');

const paths = {
  src: './Sources/',
  dest: '../Resources/Public',
};

const tasks = {
  sass: {
    src: `${paths.src}/Sass/**/*.scss`,
    dest: `${paths.dest}/Stylesheets`,
  },
  watch: {
    sass: {
      files: [`${paths.src}/Sass/**/*.scss`, `${paths.src}/Sass/*.scss`],
    },
  },
};

// Compile Sass with autoprefixing
function sassTask() {
  const processors = [autoprefixer()];
  return src(tasks.sass.src)
    .pipe(gulpSass({ outputStyle: 'compressed' }).on('error', console.log))
    .pipe(dest(tasks.sass.dest))
    .pipe(postcss(processors))
    .pipe(dest(tasks.sass.dest));
}

// Watch for changes
function watchTask() {
  watch(tasks.watch.sass.files, sassTask);
}

// Exports
exports.css = sassTask;
exports.build = series(sassTask);
exports.watch = watchTask;
exports.default = exports.build;
