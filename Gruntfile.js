module.exports = function(grunt) {

    var joomla_extensions_path = '../../../xampp/htdocs/handball/hb_joomla3/';
    // console.log(joomla_extensions_path);

    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        sync: {
            mod_tsvevents: {
                files: [{
                    cwd: joomla_extensions_path + 'zzz_packages/mod_tsvevents/', // makes all src relative to cwd
                    src: [
                        '**'
                    ],
                    dest:  './mod_tsvevents/',  
                }],
                pretend: false, // Don't do any IO. Before you run the task with `updateAndDelete` PLEASE MAKE SURE it doesn't remove too much. 
                verbose: false // Display log messages when copying files 
            }
        },
        'string-replace': {
            version: {
                files: {
                    './mod_tsvevents/': './mod_tsvevents/mod_tsvevents.xml',    // 'a': 'b' means b is source file and a is destination file 
                },
                options: {
                    replacements: [{
                            pattern: /<version>.+?<\/version>/g,
                            replacement: '<version><%= pkg.version %></version>'
                        },
                        {
                            pattern: /<creationDate>.+?<\/creationDate>/g,
                            replacement: '<creationDate><%= pkg.date %></creationDate>'
                        }]
                }
            }
        },
        version: {
            project: {
                src: ['package.json']
                }
        },
        bumpup: {
            options: {
                dateformat: 'YYYY-MM-DD HH:mm Z',
                normalize: false,
                updateProps: {
                    pkg: 'package.json'
                }
            },
            setters: {
                // Overwrites setter for `date` property 
                date: function (old, releaseType, options) {
                    return grunt.template.today('yyyy-mm-dd HH:MM Z');   // local timezone 
                },
            },
            files: ['package.json']
        },
        compress: {
            main: {
                options: {
                  archive: '../Releases/mod_tsvevents_' + grunt.template.today('yyyymmdd_HHMMss') + '.zip'
                },
                files: [
                    {
                    expand: true,
                    cwd: 'mod_tsvevents',
                    src: '**/*',
                    },
                ]
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-compress');
    grunt.loadNpmTasks('grunt-sync');
    grunt.loadNpmTasks('grunt-string-replace');
    grunt.loadNpmTasks('grunt-bumpup');

    // grunt.loadNpmTasks('grunt-contrib-uglify');
    // grunt.loadNpmTasks('grunt-contrib-cssmin');
    // grunt.loadNpmTasks('grunt-spritesmith');
    // grunt.loadNpmTasks('grunt-contrib-copy');
    // grunt.loadNpmTasks('grunt-contrib-watch');
    // grunt.loadNpmTasks('grunt-sass');
    // grunt.loadNpmTasks('grunt-contrib-clean');
    // grunt.loadNpmTasks('grunt-postcss');
    // grunt.loadNpmTasks('grunt-contrib-concat');


    grunt.registerTask('default', ['compress']);
    // grunt.registerTask('build_patch', ['sync:mod_tsvevents', 'version::patch', 'string-replace:version', 'compress']);
    // grunt.registerTask('build_minor', ['sync:mod_tsvevents', 'version::minor', 'string-replace:version', 'compress']);
    // grunt.registerTask('build_major', ['sync:mod_tsvevents', 'version::major', 'string-replace:version', 'compress']);
    grunt.registerTask('build_patch', ['sync:mod_tsvevents', 'bumpup:patch', 'string-replace:version', 'compress']);

    // grunt.registerTask('build', ['clean:build', 'concat:main', 'uglify:build', 'sass:build', 'postcss:dist', 'cssmin', 'copy:build', 'copy:buildmin']);
    // grunt.registerTask('dev', ['clean:build', 'concat:main', 'sass:dev', 'postcss:dist', 'copy:dev']);
    // grunt.registerTask('devplusmin', ['clean:build', 'concat:main', 'sass:dev', 'postcss:dist', 'copy:dev', 'uglify:build', 'sass:build', 'postcss:dist', 'cssmin', 'copy:buildmin']);
    // grunt.registerTask('sprite-all', ['sprite:all']);
    // grunt.registerTask('compsass', ['sass:dev', 'postcss:dist']);

};
