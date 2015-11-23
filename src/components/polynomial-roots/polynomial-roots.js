define(function(require){

    var Vue      = require("vue"),
        template = require("text!./polynomial-roots.html");

    return Vue.extend({

        data: function() {

            return {};
        },
        template: template
    });
});
