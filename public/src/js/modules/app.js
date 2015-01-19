"use strict";

// Vendors
var vendors = require("./vendors"),
    $       = vendors.Zepto,
    Can     = vendors.Can;

// Components
var components = {

    add: require("./add")
};

module.exports = {

    // PUBLIC METHODS
    /////////////////////////////////////////////////////////

    init: function(){

        this._initCanvas();
        this._initRouter();
    },

    // PRIVATE METHODS
    /////////////////////////////////////////////////////////

    _initCanvas: function(){

        var canvas = document.getElementById("matrix-canvas"),
            context = canvas.getContext('2d');

        context.globalCompositeOperation = 'lighter';
        canvas.width = $(window).width();
        canvas.height = $(window).height();

        console.log(canvas.width);
        console.log(canvas.height);

        draw();

        var textStrip = ['诶', '比', '西', '迪', '伊', '吉', '艾', '杰', '开', '哦', '屁', '提', '维'];

        var stripCount = 60, stripX = new Array(), stripY = new Array(), dY = new Array(), stripFontSize = new Array();

        for (var i = 0; i < stripCount; i++) {
            stripX[i] = Math.floor(Math.random()*1265);
            stripY[i] = -100;
            dY[i] = Math.floor(Math.random()*7)+3;
            stripFontSize[i] = Math.floor(Math.random()*16)+8;
        }

        var theColors = ['#cefbe4', '#81ec72', '#5cd646', '#54d13c', '#4ccc32', '#43c728'];

        var elem, context, timer;

        function drawStrip(x, y) {
            for (var k = 0; k <= 20; k++) {
                var randChar = textStrip[Math.floor(Math.random()*textStrip.length)];
                if (context.fillText) {
                    switch (k) {
                    case 0:
                        context.fillStyle = theColors[0]; break;
                    case 1:
                        context.fillStyle = theColors[1]; break;
                    case 3:
                        context.fillStyle = theColors[2]; break;
                    case 7:
                        context.fillStyle = theColors[3]; break;
                    case 13:
                        context.fillStyle = theColors[4]; break;
                    case 17:
                        context.fillStyle = theColors[5]; break;
                    }
                    context.fillText(randChar, x, y);
                }
                y -= stripFontSize[k];
            }
        }

        function draw() {
            // clear the canvas and set the properties
            context.clearRect(0, 0, canvas.width, canvas.height);
            context.shadowOffsetX = context.shadowOffsetY = 0;
            context.shadowBlur = 8;
            context.shadowColor = '#94f475';

            for (var j = 0; j < stripCount; j++) {
                context.font = stripFontSize[j]+'px MatrixCode';
                context.textBaseline = 'top';
                context.textAlign = 'center';

                if (stripY[j] > 1358) {
                    stripX[j] = Math.floor(Math.random()*canvas.width);
                    stripY[j] = -100;
                    dY[j] = Math.floor(Math.random()*7)+3;
                    stripFontSize[j] = Math.floor(Math.random()*16)+8;
                    drawStrip(stripX[j], stripY[j]);
                } else drawStrip(stripX[j], stripY[j]);

                stripY[j] += dY[j];
            }
          setTimeout(draw, 70);
        }
    },
    _initComponent: function(name, options){

        if (typeof components[name] !== "undefined")
        {
            components[name].init(options);
        }
    },
    _initRouter: function(){

        var self;

        self = this;
        Can.route(":page", {page: "welcome"});
        Can.route.bind('page', function(e, newValue, oldValue) {

            if (oldValue !== undefined)
            {
                self._destroyComponent(oldValue);
            }
            self._initComponent(newValue,{
                containerSelector   : "#component-container",
                vendors             : vendors
            });
        });
        Can.route.ready();
    },
    _destroyComponent: function(name){

        if (typeof components[name] !== "undefined")
        {
            components[name].destroy();
        }
    }
};
