define(function(require){

    var Vue      = require("vue"),
        template = require("text!./loader.html");

    return Vue.extend({

        data: function() {

            return {};
        },
        template: template
    });
});
