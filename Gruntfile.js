module.exports = function(grunt) {

    grunt.initConfig({
        less: {
            build: {
                files: {
                    'web/assets/css/style.css': 'web/assets/less/style.less'
                }
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-less');

    grunt.registerTask('default', ['less']);

};

