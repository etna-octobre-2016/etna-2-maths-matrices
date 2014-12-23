var gulp    = require('gulp'),
    del     = require('del');

gulp.task('clean', function(){

    var paths = [
        'src/css',
        'src/html/components/**/*.css',
        'src/js/app.js'
    ];
    
    del(paths, {force: true});
});
