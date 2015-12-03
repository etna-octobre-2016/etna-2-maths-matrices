/**
 * Events Module
 * @description: this module provides methods for event driven programming
 */
 define(
    [
        "ee"
    ],
    function(EventEmitter)
    {
        var obj;

        obj = new EventEmitter();

        return {

            emit: function(eventName, args)
            {
                obj.emitEvent(eventName, args);
            },
            off: function(eventName)
            {
                obj.removeEvent(eventName);
            },
            on: function(eventName, callback)
            {
                obj.addListener(eventName, callback);
            }
        };
    }
);
