define(function(require)
{
    var Vue      = require("vue"),
        template = require("text!./home.html");

    function initView()
    {
        module.view = new Vue({

            data     : {},
            el       : "#main",
            template : template
        });
    }

    var module = {

        view: null,

        init: function()
        {
            console.log("home section init");
            initView();
        }
    };

    return module;
});
