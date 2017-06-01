module.exports = function(grunt) {

    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        sync: {
            mod_tsvevents: {
                files: [{
                    cwd: '<%= paths.joomla %><%= paths.package %>mod_tsvevents/', // makes all src relative to cwd
                    //cwd: '../../../xampp/htdocs/handball/hb_joomla3/' + function(){console.log('test'); return 'zzz_packages/';} + 'mod_tsvevents/',
                    //cwd: '../../../xampp/htdocs/handball/hb_joomla3/' + 'zzz_packages/' + 'mod_tsvevents/',
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
        },

    });

    grunt.loadNpmTasks('grunt-contrib-compress');
    grunt.loadNpmTasks('grunt-sync');
    grunt.loadNpmTasks('grunt-string-replace');
    grunt.loadNpmTasks('grunt-bumpup');

    // load path from separate json file that is not synced with git
    grunt.config.set('paths', grunt.file.readJSON('paths.json'));
    // --> paths.json => e.g.
    // {
    //     "joomla": "D:\\xampp\\htdocs\\handball\\hb_joomla3\\",
    //     "package": "zzz_packages/"
    // }

    /// ------------

    grunt.registerTask('default', ['compress']);
    grunt.registerTask('import', ['run-grunt', 'sync:mod_tsvevents']);
    grunt.registerTask('build_patch', ['bumpup:patch', 'string-replace:version', 'compress']);
    grunt.registerTask('build_minor', ['bumpup:minor', 'string-replace:version', 'compress']);
    grunt.registerTask('build_major', ['bumpup:major', 'string-replace:version', 'compress']);

    // run grunt file in joomla folder
    grunt.registerTask('run-grunt', function() {
        var paths = require('./paths.json');
        // console.log(paths);
        var cb = this.async();
        var child = grunt.util.spawn({
            grunt: true,
            args: ['build_mod_tsvevents'],
            opts: {
                cwd: paths.joomla
                }
        }, function(error, result, code) {
          cb();
        });

        child.stdout.pipe(process.stdout);
        child.stderr.pipe(process.stderr);
    });



};
