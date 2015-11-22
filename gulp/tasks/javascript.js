var argv     = require("../modules/argv");
var config   = require("../config.json");
var gulp     = require("gulp");
var rjs      = require("requirejs");
var sequence = require("run-sequence");

// Javascript tasks
gulp.task("javascript", function(callback)
{
    if (argv.env === "production" || argv.env === "preprod")
    {
        sequence("javascript-copy", "javascript-optimize", callback);
    }
    else
    {
        sequence("javascript-copy", callback);
    }
});

// Copies JS files to the tmp/_buffer directory (needed by the "replace" task)
gulp.task("javascript-copy", function()
{
    var source = [
        config.paths.src + "/js/**/*.js",
        config.paths.src + "/components/**/*.js",
        config.paths.src + "/sections/**/*.js"
    ];
    return gulp.src(source, {base: config.paths.src}).pipe(gulp.dest(config.paths.buffer));
});

// Runs RequireJS optimizer
gulp.task("javascript-optimize", function(callback)
{
    var options = {
        baseUrl:        config.paths.src + "/js",
        mainConfigFile: config.paths.buffer + "/js/app.js",
        name:           "app",
        out:            config.paths.buffer + "/js/app.min.js"
    };

    function onRjsError(error)
    {
        console.log(error);
        callback();
    }
    function onRjsSuccess(buildResponse)
    {
        // @note: uncomment to see the list of concatenated modules
        // console.log(buildResponse);
        callback();
    }
    rjs.optimize(options, onRjsSuccess, onRjsError);
});
