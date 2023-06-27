'use strict';

// Common
import {src, dest, series, watch} from 'gulp';

// JS
import babel from 'gulp-babel';
import terser from 'gulp-terser';
import jshint from 'gulp-jshint';

// CSS
import nodeSass from 'node-sass';
import gulpSass from 'gulp-sass';
import autoprefixer from 'autoprefixer';
import postcss from 'gulp-postcss';

const sass = gulpSass(nodeSass);

const paths = {
  src: './Sources/',
  dest: '../Resources/Public',
};

const tasks = {
  sass: {
    src: `${paths.src}/Sass/**/*.scss`,
    dest: `${paths.dest}/Stylesheets`,
  },
  jshint: {
    src: `${paths.src}/Script/**/*.js`,
    options: {
      curly: true,
      eqeqeq: true,
      immed: true,
      latedef: true,
      newcap: true,
      noarg: true,
      sub: true,
      undef: true,
      boss: true,
      eqnull: true,
      node: true,
      globals: {
        window: true,
        document: true,
        $: true,
        ga: true
      }
    },
  },
  terser: [
    {
      src: `${paths.src}/Script/*.js`,
      dest: `${paths.dest}/JavaScript`
    }
  ],
  watch: {
    javascript: {
      files: [`${paths.src}/Script/*.js`]
    },
    sass: {

      files: [`${paths.src}/Sass/**/*.scss`, `${paths.src}/Sass/*.scss`]
    }
  }
};

// jshint
let jshintTask = () => {
  return src(tasks.jshint.src)
    .pipe(jshint(tasks.jshint.options));
};

// Uglify
let terserTask = series(function (cb) {
  tasks.terser.forEach(function (file) {
    return src(file.src)
      .pipe(babel())
      .on('error', console.log)
      .pipe(terser())
      .on('error', console.log)
      .pipe(dest(file.dest));
  });
  cb();
});

// Sass
let sassTask = () => {
  let processors = [
    autoprefixer()
  ];
  return src(tasks.sass.src)
    .pipe(sass({outputStyle: 'compressed'}).on('error', console.log))
    .pipe(dest(tasks.sass.dest))
    .pipe(postcss(processors))
    .pipe(dest(tasks.sass.dest));
};

// Watch
let watchTask = () => {
  watch(tasks.watch.javascript.files, series(jshintTask, terserTask));
  watch(tasks.watch.sass.files, sassTask);
};

exports.test = jshintTask;
exports.js = series(jshintTask, terserTask);
exports.build = series(sassTask, exports.js);
exports.watch = watchTask;
