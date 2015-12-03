/**
 * Router Module
 * @description: this module handles URL changes and notifies the section core component
 */
define(
    [
        "crossroads",
        "core/utils",
        "core/events",
    ],
    function(crossroads, utils, events)
    {
        var defaultPattern,
            module,
            routes,
            observeRouteChange,
            setDefaultRoute,
            setRoutes;

        defaultPattern = "/home";
        routes = [
            {
                pattern: "/home",
                section: "home"
            }
        ];
        module = {

            init: function()
            {
                observeRouteChange();
                setRoutes();
                setDefaultRoute();
                startRouter();
            },
            redirect: function(route)
            {
                location.hash = route;
            }
        };
        observeRouteChange = function()
        {
            window.addEventListener("hashchange", function()
            {
                crossroads.parse(location.hash.substr(1));
            });
        };
        setDefaultRoute = function()
        {
            crossroads.bypassed.add(function(request)
            {
                module.redirect(defaultPattern);
            });
        };
        setRoutes = function()
        {
            crossroads.normalizeFn = crossroads.NORM_AS_OBJECT; // retrieves params as object
            utils.iterators.forEach(routes, function(index, route)
            {
                crossroads.addRoute(route.pattern, function(params)
                {
                    localStorage.setItem("router.lastRoute", location.hash.substr(1));
                    events.emit("sections:" + route.section, params); // Route change notification
                });
            });
        };
        startRouter = function()
        {
            var currentRoute,
                lastRoute;

            currentRoute = location.hash.substr(1);
            if (currentRoute.substr(-1) === "/")
            {
                currentRoute = currentRoute.substr(0, (currentRoute.length - 1));
            }
            lastRoute = localStorage.getItem("router.lastRoute") || defaultPattern;
            if (lastRoute !== currentRoute)
            {
                if (currentRoute.length > 0)
                {
                    crossroads.parse(currentRoute);
                }
                else
                {
                    module.redirect(defaultPattern);
                }
            }
            else
            {
                crossroads.parse(currentRoute);
            }
        };
        return module;
    }
);
