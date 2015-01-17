var vendors = require("./vendors"),
    $       = vendors.Zepto,
    Can     = vendors.Can;

module.exports = {

    deps: {},

    init: function()
    {
        console.log("init app");

        // Templates
        var todos = new Can.List([
            {name: "Faire les courses"},
            {name: "Apprendre CanJS 6"},
            {name: "Aller aux toilettes"}
        ]);

        $("body").html(Can.view("templates/test.ejs", {todos: todos}));

        window.test = function(){

            todos.attr(1, {name:"Maitriser CanJS"});
        };
    }
};
