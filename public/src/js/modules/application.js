var vendors = require("./vendors"),
    $       = vendors.Zepto,
    Can     = vendors.Can;

module.exports = {

    // PUBLIC METHODS
    /////////////////////////////////////////////////////////

    init: function(){

        this._createComponent();
        this._render();
    },

    // PRIVATE METHODS
    /////////////////////////////////////////////////////////

    _createComponent: function(){

        Can.Component.extend({

            tag         : "component-app",
            template    : Can.view("templates/app.ejs")
        });
    },
    _render: function(){

        $("#main").html(Can.view("templates/main.ejs", {}));
    }
};
