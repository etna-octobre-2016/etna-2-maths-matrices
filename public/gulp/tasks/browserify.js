var browserify  = require('browserify'),
    gulp        = require('gulp'),
    gutil       = require('gulp-util'),
    source      = require('vinyl-source-stream');

gulp.task('browserify', function(){

    return browserify('./src/js/index.js')
        .bundle()
        .on('error', gutil.log)
        .pipe(source('index.js'))
        .pipe(gulp.dest('dist/js'))
        .pipe(global.browserSyncReload({ stream:true }));
});
