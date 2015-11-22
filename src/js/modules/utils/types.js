define({
    isArray: function(variable)
    {
        if (variable !== null && typeof variable === "object" && variable.constructor === Array)
        {
            return true;
        }
        return false;
    },
    isObject: function(variable)
    {
        if (variable !== null && typeof variable === "object" && variable.constructor === Object)
        {
            return true;
        }
        return false;
    }
});
