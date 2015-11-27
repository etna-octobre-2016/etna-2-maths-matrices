define(
    [
        "core/events"
    ],
    function(events)
    {
        return {

            init: function()
            {
                if (this.isInitialized !== true)
                {
                    window.addEventListener('orientationchange', this.onWindowOrientationChange.bind(this));
                    window.addEventListener('resize', this.onWindowResize.bind(this));
                    this.isInitialized = true;
                }
            },
            getCurrentDevice: function()
            {
                var tag = window.getComputedStyle(document.body,':before').getPropertyValue('content');
                tag = tag.replace( /"/g,'');
                return tag;
            },
            onWindowOrientationChange: function()
            {
                events.emit("utils:responsive:viewportUpdate", {
                    currentDevice: this.getCurrentDevice()
                });
            },
            onWindowResize: function()
            {
                events.emit("utils:responsive:viewportUpdate", {
                    currentDevice: this.getCurrentDevice()
                });
            }
        };
    }
);
