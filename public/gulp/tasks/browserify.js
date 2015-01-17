var browserify  = require('browserify'),
    gulp        = require('gulp'),
    gutil       = require('gulp-util'),
    source      = require('vinyl-source-stream');

gulp.task('browserify', function(){

    return browserify('./src/js/src/index.js')
        .transform('browserify-shim')
        .bundle()
        .on('error', gutil.log)
        .pipe(source('app.js'))
        .pipe(gulp.dest('src/js'))
        .pipe(global.browserSyncReload({ stream:true }));
});
