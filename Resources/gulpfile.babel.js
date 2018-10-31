'use strict';

import gulp from 'gulp';
import path from 'path';
import sourcemaps from 'gulp-sourcemaps';
import babel from 'gulp-babel';
import compass from 'gulp-compass';
import concat from 'gulp-concat';
import jshint from 'gulp-jshint';
import rename from 'gulp-rename';
import uglify from 'gulp-uglify';
import watch from 'gulp-watch';

const paths = {
	src: './Private',
	dest: './Public'
};

const tasks = {
	compass: {
		src: path.join(paths.src, 'Sass/*.scss'),
		dest: path.join(paths.dest, 'Stylesheets'),
		options: {
			debug: false,
			force: true,

			environment: 'development',
			style: 'expanded',
			comments: false,
			sourcemap: true,
			http_path: 'typo3conf/ext/sessionplaner/Resources',
			project: path.join(__dirname),
			sass: path.join(paths.src, 'Sass'),
			css: path.join(paths.dest, 'Stylesheets'),
			image: path.join(paths.dest, 'Images'),
			javascript: path.join(paths.dest, 'JavaScript'),
			import_path: [
				require('node-normalize-scss').includePaths,
				require('modularscale-sass-npm').includePaths
			]
		}
	},
	jshint: {
		src: path.join(paths.src, 'Script/*.js'),
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
	concat: {
		folder: path.join(paths.dest, 'JavaScript'),
		files: [
			{
				src: [
					path.join(paths.src, 'Script/*.js')
				],
				dest: 'Edit.js'
			}
		]
	},
	babel: {
		srcs: [
			path.join(paths.src, 'Script/*.js')
		],
		dest: 'JavaScript'
	},
	uglify: [
		{
			src: path.join(paths.dest, 'JavaScript/Edit.js'),
			dest: path.join(paths.dest, 'JavaScript')
		}
	],
	watch: {
		javascript: {
			files: [path.join(paths.src, 'Script/*.js')],
			tasks: ['jshint', 'concat', 'uglify']
		},
		compass: {
			files: [path.join(paths.src, 'Sass/*.scss')],
			tasks: ['compass:development']
		}
	}
};

// Js hint
gulp.task('jshint', () => {
	return gulp.src(tasks.jshint.src)
		.pipe(jshint(tasks.jshint.options));
});

// Concat JavaScript files
gulp.task('concat', () => {
	tasks.concat.files.forEach(function (file) {
		gulp.src(file.src)
			.pipe(babel())
			.pipe(concat(file.dest, {newLine: ';'}))
			.pipe(gulp.dest(tasks.concat.folder));
	});
});

// Uglify
gulp.task('babel', () => {
	return gulp.src(tasks.babel.srcs)
		.pipe(sourcemaps.init())
		.pipe(babel({ presets: ['es2015'] }))
		.pipe(sourcemaps.write('./'))
		.pipe(gulp.dest(path.join(paths.dest, tasks.babel.dest)));
});
gulp.task('uglify', ['babel'], () => {
	tasks.uglify.forEach(function (file) {
		gulp.src(file.src)
			.pipe(uglify())
			.pipe(rename({ suffix: '.min' }))
			.pipe(gulp.dest(file.dest));
	});
});

// CSS development
gulp.task('compass:development', () => {
	return gulp.src(tasks.compass.src)
		.pipe(compass(tasks.compass.options))
		.pipe(gulp.dest(tasks.compass.dest));
});

// CSS production
gulp.task('compass:production', () => {
	let options = tasks.compass.options;
	options.environment = 'production';
	options.style = 'compressed';
	options.comments = false;

	return gulp.src(tasks.compass.src)
		.pipe(compass(options))
		.pipe(rename({ suffix: '.min' }))
		.pipe(gulp.dest(tasks.compass.dest));
});

// Watch
gulp.task('watch', () => {
	gulp.watch(tasks.watch.javascript.files, tasks.watch.javascript.tasks);
	gulp.watch(tasks.watch.compass.files, tasks.watch.compass.tasks);
});

gulp.task('test', ['jshint']);
gulp.task('development', ['compass:development', 'jshint', 'concat']);
gulp.task('production', ['compass:production', 'uglify']);
gulp.task('default', ['watch']);
