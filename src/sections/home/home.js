define(function(require)
{
    var Vue      = require("vue"),
        template = require("text!./home.html");

    function initView()
    {
        module.view = new Vue({

            components: {
                "loader-component":           require("components/loader/loader"),
                "polynomial-roots-component": require("components/polynomial-roots/polynomial-roots")
            },
            data: {
                isLoading: true
            },
            el: "#main",
            template: template,
            ready: function() {
                
                var timeoutID = setTimeout(function(){
                    
                    this.isLoading = false;
                    clearTimeout(timeoutID);
                    
                }.bind(this), 2000);
            }
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
