var argv     = require("../modules/argv");
var config   = require("../config.json");
var gulp     = require("gulp");
var sequence = require("run-sequence").use(gulp);

// Launches the development mode
// $> gulp dev
gulp.task("dev", function(callback)
{
    if (argv.env === "production" || argv.env === "preprod")
    {
        throw new Error("'production' and 'preprod' environments are not available on development mode");
    }
    sequence("clean", "browser-sync", "sass", "html", "javascript", "replace", "svg", "browser-sync-reload", function(){

        var jsSource   = config.paths.src + "/**/*.js";
        var sassSource = config.paths.src + "/**/*.scss";
        var htmlSource = config.paths.src + "/**/*.html";

        gulp.watch(sassSource, function(){
            sequence("sass", "browser-sync-reload");
        });
        gulp.watch(jsSource, function(){
            sequence("javascript", "replace", "browser-sync-reload");
        });
        gulp.watch(htmlSource, function(){
            sequence("html", "replace", "browser-sync-reload");
        });
        callback();
    });
});

// Builds the distributable project
// $> gulp build --env=production|preprod
gulp.task("build", function(callback)
{
    if (argv.env !== "production" && argv.env !== "preprod")
    {
        throw new Error("'production' and 'preprod' are the only available environments for the build task");
    }
    sequence("clean", "static", "sass", "html", "javascript", "replace", "svg", callback);
});
