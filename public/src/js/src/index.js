// Dependencies
var $   = require("../../vendors/zepto/zepto"),
    Can = require("../../vendors/canjs/can.zepto");

// Templates
var todos = new Can.List([
    {name: "Faire les courses"},
    {name: "Apprendre CanJS"},
    {name: "Aller aux toilettes"}
]);

console.log(todos);

$("body").html(Can.view("templates/test.ejs", {todos: todos}));

window.test = function(){

    todos.attr(1, {name:"Maitriser CanJS"});
};
