"use strict";

// Vendors
var vendors = require("./vendors"),
    $       = vendors.Zepto,
    Can     = vendors.Can;

// Components
var components = {

    add: require("./add")
};

module.exports = {

    // ATTRIBUTES
    /////////////////////////////////////////////////////////

    component   : null,
    controller  : null,

    // PUBLIC METHODS
    /////////////////////////////////////////////////////////

    init: function(){

        this._initController("#main");
        this._initRouter();
    },

    // PRIVATE METHODS
    /////////////////////////////////////////////////////////

    _initComponent: function(name){

        if (typeof components[name] !== "undefined")
        {
            components[name].init();
        }
    },
    _initController: function(containerSelector){

        var Controller = Can.Control({

            init: function($container, options){

                $container.html(Can.view(options.view));
            }
        });

        this.controller = new Controller(containerSelector, {
            view: "templates/app.ejs"
        });
    },
    _initRouter: function(){

        var self;

        self = this;
        Can.route(":page", {page: "welcome"});
        Can.route.bind('page', function(e, newValue, oldValue) {

            if (oldValue !== undefined)
            {
                self._destroyComponent(oldValue);
            }
            self._initComponent(newValue);
        });
        Can.route.ready();
    },
    _destroyComponent: function(name){

        if (typeof components[name] !== "undefined")
        {
            components[name].destroy();
        }
    }
};
