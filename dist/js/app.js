// @note: here you can configure requireJS (see: http://requirejs.org/docs/api.html#config)
require.config({

    paths: {

        // vendors
        cropper:    "../vendors/cropper/dist/cropper.min",
        crossroads: "../vendors/crossroads/dist/crossroads.min",
        ee:         "../vendors/eventEmitter/EventEmitter.min",
        lodash:     "../vendors/lodash/lodash.min",
        signals:    "../vendors/js-signals/dist/signals.min", // @note: crossroads dependency
        text:       "../vendors/requirejs-text/text",
        vue:        "../vendors/vue/dist/vue.min",

        // require paths
        core:       "./core",
        modules:    "./modules",
        sections:   "../sections",
        components: "../components"
    },
    shim: {
        cropper: {
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
