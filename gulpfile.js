'use strict';

const gulp = require('gulp');
const babel = require('gulp-babel');
const jshint = require('gulp-jshint');
const uglify = require('gulp-uglify');
const postcss = require('gulp-postcss');
const autoprefixer = require('autoprefixer');
const sass = require('gulp-sass');
sass.compiler = require('node-sass');

const paths = {
    src: './Resources/Private',
    dest: './Resources/Public',
};

const tasks = {
    sass: {
        src: paths.src + '/Sass/**/*.scss',
        dest: paths.dest + '/Stylesheets',
    },
    jshint: {
        src: paths.src + '/Script/**/*.js',
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
    uglify: [
        {
            src: paths.src + '/Script/*.js',
            dest: paths.dest + '/JavaScript'
        }
    ],
    watch: {
        javascript: {
            files: [paths.src + '/Script/*.js'],
            tasks: ['jshint', 'uglify']
        },
        sass: {
            files: [paths.src + '/Sass/**/*.scss'],
            tasks: ['sass']
        }
    }
};

// jshint
gulp.task('jshint', function() {
    return gulp.src(tasks.jshint.src)
        .pipe(jshint(tasks.jshint.options));
});

// Uglify
gulp.task('uglify', gulp.series(function(cb) {
    tasks.uglify.forEach(function (file) {
        gulp.src(file.src)
            .pipe(babel())
            .on('error', function (e) { console.log(e); })
            .pipe(uglify())
            .on('error', function (e) { console.log(e); })
            .pipe(gulp.dest(file.dest));
    });
    cb();
}));

// Sass
gulp.task('sass', function () {
    let processors = [
        autoprefixer({ browsers: ['last 2 version'] })
    ];
    return gulp.src(tasks.sass.src)
        .pipe(sass({ outputStyle: 'compressed' }).on('error', sass.logError))
        .pipe(gulp.dest(tasks.sass.dest))
        .pipe(postcss(processors))
        .pipe(gulp.dest(tasks.sass.dest));
});

// Watch
gulp.task('watch', function() {
    gulp.watch(tasks.watch.javascript.files, gulp.series(...tasks.watch.javascript.tasks));
    gulp.watch(tasks.watch.sass.files, gulp.series(...tasks.watch.sass.tasks));
});

gulp.task('test', gulp.series('jshint'));
gulp.task('js', gulp.series('jshint', 'uglify'));
gulp.task('css', gulp.series('sass'));
gulp.task('build', gulp.series('css', 'js'));
gulp.task('default', gulp.series('watch'));
