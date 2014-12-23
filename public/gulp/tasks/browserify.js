var browserify  = require('browserify'),
    gulp        = require('gulp'),
    source      = require('vinyl-source-stream');

gulp.task('browserify', function(){

    return browserify('./src/js/index.js')
        .bundle()
        .pipe(source('index.js'))
        .pipe(gulp.dest('dist/js'));
});
