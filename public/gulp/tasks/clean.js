var gulp    = require('gulp'),
    del     = require('del');

gulp.task('clean', function(){

    del(['dist'], function(err, deletedFiles){

        if (deletedFiles.length > 0)
        {
            var i;
            for (i = 0; i < deletedFiles.length; i++)
            {
                console.log('Deleted:', deletedFiles[i]);
            }
        }
    });
});
