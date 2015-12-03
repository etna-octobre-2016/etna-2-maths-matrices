/**
 * Sections Module
 * @description: this module handles sections initialization
 */
define(function(require)
{
    var setEvents;

    setEvents = function()
    {
        var events;

        events = require("core/events");
        events.on("sections:home", require("sections/home/home").init);
    };
    return {

        init: function()
        {
            setEvents();
        }
    };
});
