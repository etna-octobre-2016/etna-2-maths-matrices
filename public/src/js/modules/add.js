"use strict";

module.exports = {

    // ATTRIBUTES
    ////////////////////////////////////////////////////////////

    options: null,

    // PUBLIC METHODS
    ////////////////////////////////////////////////////////////

    init: function(options){

        this.options = options;
        this._createComponent();
    },
    destroy: function(){

        this.options = null;
    },

    // PRIVATE METHODS
    ////////////////////////////////////////////////////////////

    _createComponent: function(){

        console.log("create component");
        console.log(this.options);
    }
};
