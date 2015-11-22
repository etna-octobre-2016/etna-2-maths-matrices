var argv    = require("../modules/argv");
var config  = require("../config.json");
var gulp    = require("gulp");
var replace = require("gulp-replace");

gulp.task("replace", function()
{
    var destination;
    var source;

    if (argv.env === "production" || argv.env === "preprod")
    {
        destination = config.paths.dist;
    }
    else
    {
        destination = config.paths.tmp;
    }
    source = config.paths.buffer + "/**/*.{html,js}";
    return gulp.src(source)
        .pipe(replace("@@CACHE_BUST", (new Date()).getTime()))
        .pipe(replace("@@JS_MAIN", config.replace[argv.env].JS_MAIN))
        .pipe(gulp.dest(destination));
});
