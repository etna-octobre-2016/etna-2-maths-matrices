define(
    [
        "modules/utils/types"
    ],
    function(types)
    {
        return {

            forEach: function(variable, mapFunction)
            {
                var key;

                if (types.isArray(variable))
                {
                    for (key = 0; key < variable.length; key++)
                    {
                        mapFunction(key, variable[key]);
                    }
                }
                else if (types.isObject(variable))
                {
                    for (key in variable)
                    {
                        if (variable.hasOwnProperty(key))
                        {
                            mapFunction(key, variable[key]);
                        }
                    }
                }
                else
                {
                    throw new Error("Cannot apply forEach on this variable");
                }
            }
        };
    }
);
