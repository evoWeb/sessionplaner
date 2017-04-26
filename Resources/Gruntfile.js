module.exports = function(grunt) {
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		compass: {
			dist: {
				options: {
					basePath: 'Private/',
					sassDir: 'Sass/',
					cssDir: '../Public/Stylesheets/',
					imagesDir: '../Public/Images/',
					javascriptsDir: '../Public/JavaScript/',
					httpPath: 'typo3conf/ext/sessionplaner/Resources/',
					environment: 'development'
				}
			}
		},
		cssmin: {
			dist: {
				files: [
					{ src: ['Public/Stylesheets/backend.css'], dest: 'Public/Stylesheets/backend.min.css' }
				]
			}
		},

		concat: {
			options: {
				separator: ';'
			},
			dist: {
				files: [
					{ src: ['Private/Script/*.js'], dest: 'Public/JavaScript/Edit.unminified.js' }
				]
			}
		},
		uglify: {
			dist: {
				files: [
					{ src: 'Public/JavaScript/Edit.unminified.js', dest: 'Public/JavaScript/Edit.js' }
				]
			}
		},

		jshint: {
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
				node: true
			},
			globals: {
				exports: true,
				module: false,
				files: [
					{src: ['Private/Script/*.js', '!Private/Script/*.min.js']}
				]
			}
		},

		watch: {
			javascript: {
				files: ['Private/Script/*.js'],
				tasks: ['concat', 'uglify']
			},
			compass: {
				files: ['Private/Sass/*.scss'],
				tasks: ['compass', 'cssmin']
			}
		}
	});

		// load modules
	grunt.loadNpmTasks('grunt-contrib-compass');
	grunt.loadNpmTasks('grunt-contrib-cssmin');

	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-uglify');

	grunt.loadNpmTasks('grunt-contrib-jshint');

	grunt.loadNpmTasks('grunt-contrib-watch');


		// add tasks
	grunt.registerTask('test', ['jshint']);
	grunt.registerTask('production', ['compass', 'cssmin', 'concat', 'uglify']);
	grunt.registerTask('default', ['watch']);
};