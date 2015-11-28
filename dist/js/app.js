// @note: here you can configure requireJS (see: http://requirejs.org/docs/api.html#config)
require.config({

    paths: {

        // vendors
        crossroads: "../vendors/crossroads/dist/crossroads.min",
        ee:         "../vendors/eventEmitter/EventEmitter.min",
        jquery:     "../vendors/jquery/dist/jquery.min",
        lettering:  "../vendors/letteringjs/jquery.lettering",
        lodash:     "../vendors/lodash/lodash.min",
        signals:    "../vendors/js-signals/dist/signals.min", // @note: crossroads dependency
        text:       "../vendors/requirejs-text/text",
        textillate: "../vendors/textillate/jquery.textillate",
        typedjs:    "../vendors/typed.js/dist/typed.min",
        vue:        "../vendors/vue/dist/vue.min",

        // require paths
        core:       "./core",
        modules:    "./modules",
        sections:   "../sections",
        components: "../components"
    },
    shim: {
        lettering: {
            deps: ["jquery"]
        },
        textillate: {
            deps: ["jquery", "lettering"]
        },
        typedjs: {
            deps: ["jquery"]
        }
    }
});

// @note: here is the main entry point of the application
require(
    [
        "core/router",
        "core/sections"
    ],
    function(router, sections)
    {
        sections.init();
        router.init();
    }
);
