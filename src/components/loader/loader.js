define(function(require){

    var Vue      = require("vue"),
        template = require("text!./loader.html");

    require("textillate");

    return Vue.extend({

        data: function() {

            return {};
        },
        template: template,
        ready: function() {
            
            $(this.$$.text).textillate({
                
                in: {
                  effect: 'fadeIn'
                }
            });
        }
    });
});
