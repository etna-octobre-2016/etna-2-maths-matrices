/**
 * Utilities Module
 * @description: this module contains some useful and generic methods
 */
define(
    [
        "modules/utils/iterators",
        "modules/utils/responsive",
        "modules/utils/types"
    ],
    function(iterators, responsive, types)
    {
        responsive.init();

        return {
            iterators  : iterators,
            responsive : responsive,
            types      : types
        };
    }
);
