module.exports = function (grunt) {
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        sass: {
            dist: {
                options: {
                    style: 'compressed'
                },
                files: {
                    'assets/css/global.css': 'src/sass/global.scss'
                }
            }
        },
        concat: {
            options: {
                separator: ';'
            },
            dist: {
                src: ['src/js/**.js'],
                dest: 'assets/js/global.js'
            }
        },
        uglify: {
            my_target: {
                files: {
                    'assets/js/global.min.js': ['assets/js/global.js']
                }
            }
        },
        autoprefixer: {
            options: {
                map: true,
                browsers: ['Last 8 versions', 'IE > 7', '> 1%']
            },
            css: {
                src: 'assets/css/*.css'
            }
        },
        watch: {
            sass: {
                files: ['src/sass/**/*.scss'],
                tasks: ['sass', 'autoprefixer']
            },
            js: {
                files: ['src/js/**/*.js'],
                tasks: ['concat', 'uglify']
            }
        }
    });
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-autoprefixer');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-uglify');

    grunt.registerTask('default', ['sass', 'autoprefixer', 'concat', 'uglify']);
};