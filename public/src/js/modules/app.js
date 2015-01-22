"use strict";

// Vendors
var vendors = require("./vendors"),
    $       = vendors.jQuery;

module.exports = {

    // PUBLIC METHODS
    /////////////////////////////////////////////////////////

    init: function(){

        this._initCanvas();
        this._initCalculator();
    },

    // PRIVATE METHODS
    /////////////////////////////////////////////////////////

    _initCalculator: function()
    {
        $( document ).ready(function() {

            var saut		= "<br>";
            var libelleA	= "Matrice A";
            var libelleB	= "Matrice B";
            var apiURL      = "http://api.matrix.maths.etna";

            /*######################## EVENT #############################*/

            $("#dialog").dialog({
                autoOpen : false,
                height   : "auto",
                modal    : true,
                width    : "auto"
            });

            /******************
            **** Addition *****/
            $( "#set-add" ).click(function()
            {
                buildMatriceHTMLAddSub("Addition / Soutraction","line-add","column-add");
            });

            /****************************
            ****** Multiplication ******/
            $( "#input-mult" ).val( $("#column-multA option:selected").val());

            $( "#column-multA" ).change(function(){
                $( "#input-mult" ).val( $("#column-multA option:selected").val());
            });

            $( "#set-multiply" ).click(function()
            {
                buildMatriceHTMLMultiply("Mutiply","line-multA","column-multA","column-multB");
            });

            /****************************
            ******** Transpose **********/
            $( "#set-transpose" ).click(function()
            {
                buildMatriceHTMLTranspose("Transpose","line-transpose","column-transpose");
            });

            /****************************
            ******** Trace **********/
            $( "#set-trace" ).click(function()
            {
                buildMatriceHTMLTrace("Trace","dim-trace");
            });

            /*########################## FUNCTIONS ##############################
            ###*/
            function getMatriceHTML(idmat,line,col){
                var nbCol 	= $("#"+col+" option:selected").val();
                var nbLine 	= $("#"+line+" option:selected").val();
                var cell 	= '';
                var line 	= '';
                var cells	= '';
                var i,j 	= 0;

                for (i=0;i<nbLine;++i)
                {
                    cells = "";
                    for (j=0;j<nbCol;++j)
                    {
                        cells += '<td><input id="in'+i+j+'" class="textfield" data-row="'+i+'" data-col="'+j+'" type="text"></input></td>';
                    }
                    line += "<tr>"+cells+"</tr>";
                }
                var matriceHTML = "<table id='"+idmat+"'>"+line+"</table>";

                return matriceHTML;
            }

            function buildMatriceHTMLAddSub(title,line,col){
                var idtab1 = "mat-addsub1";
                var idtab2 = "mat-addsub2";
                var tab1 = getMatriceHTML(idtab1,line,col);
                var tab2 = getMatriceHTML(idtab2,line,col);
                var html = title+saut+libelleA+saut+tab1+saut+libelleB+saut+tab2;
                var idButton = "calc-addsub";
                var op  = $("#operator-add-sub option:selected").val();

                getDialog(html,idButton);

                $( "#"+idButton ).click(function(){
                    var matA = getMatriceArray(idtab1);
                    var matB = getMatriceArray(idtab2);
                    if(op == '-'){
                        calcSub(matA,matB);
                    }else if(op =='+'){
                        calcAdd(matA,matB);
                    }else{return;}

                });
            }

            function buildMatriceHTMLMultiply(title,lineA,colA,lineB){
                var idtab1 = "mat-mult1";
                var idtab2 = "mat-mult2";
                var tab1 = getMatriceHTML(idtab1,lineA,colA);
                var tab2 = getMatriceHTML(idtab2,colA,lineB);
                var html = title+saut+libelleA+saut+tab1+saut+libelleB+saut+tab2;
                var idButton = "calc-mult";
                getDialog(html,idButton);

                $( "#"+idButton).click(function(){
                    var matA = getMatriceArray(idtab1);
                    var matB = getMatriceArray(idtab2);
                    calcMult(matA,matB)
                });
            }

            function buildMatriceHTMLTranspose(title,line,col){
                var idtab1 = "mat-transp1";
                var tab1 = getMatriceHTML(idtab1,line,col);
                var html = title+saut+libelleA+saut+tab1;
                var idButton = "calc-transp";
                getDialog(html,idButton);

                $( "#"+idButton).click(function(){
                    var matA = getMatriceArray(idtab1);
                    calcTranspose(matA);
                });
            }

            function buildMatriceHTMLTrace(title,dim){
                var idtab1 = "mat-trace1";
                var tab1 = getMatriceHTML(idtab1,dim,dim);
                var html = title+saut+libelleA+saut+tab1+saut;
                var idButton = "calc-trace";

                getDialog(html,idButton);

                $( "#"+idButton ).click(function(){
                    var matA = getMatriceArray(idtab1);
                    calcTrace(matA);
                });
            }

            function buildHTMLTableFromMatrixArray(matrixArray)
            {
                var html,
                    i,
                    j;

                html = '<table class="table">';

                for (i = 0; i < matrixArray.length; i++)
                {
                    html += "<tr>";

                    for (j = 0; j < matrixArray[i].length; j++)
                    {
                        html += '<td class="table__cell">' + matrixArray[i][j] + "</td>";
                    }

                    html += "</tr>";
                }

                html += "</table>";

                return html;
            }

            function getDialog(data,id){
                var button = '<input id="'+id+'" class="calculate" type="submit" value="Calculer">';

                $( "#dialog" ).html(data+saut+button).dialog("open");
            }

            function getMatriceArray(idtable){
                var matriceArray = [];

                /**** je pointe sur le tableau par l'id -> dans le tableau courant
                , je check tout les inputs, puis je fait mon traitement
                */
                $('#'+idtable).find("input").each(function(i, input){
                    var $input  = $(input);
                    var value   = input.value;
                    var i       = $input.data("row");
                    var j       = $input.data("col");
                    if (typeof matriceArray[i] === "undefined"){
                        matriceArray[i] = [];
                    }
                    matriceArray[i][j] = value;
                });
                return matriceArray;
            }

            function getMatriceArray_generique(idtable){
                var matrice = [];
                /**** je pointe sur le tableau par l'id -> dans le tableau courant
                , je check tout les inputs, puis je fait mon traitement
                */
                $('table[id^='+idtable+']').each(function(j, table) {
                    $(table).find("input").each(function(i, input){
                        var value = input.value;
                    });
                })
            }

            /*** ADDITION  ***/
            function calcAdd(matA,matB){
                $.post(apiURL + "/add", {A_matrix:matA, B_matrix: matB}, function(data)
                {
                    if (typeof data.status === "string")
                    {
                        if (data.status === "success")
                        {
                            $("#result").html(buildHTMLTableFromMatrixArray(data.result));
                        }
                        else
                        {
                            alert(data.message);
                        }
                    }
                    else
                    {
                        alert("une erreur a eu lieu lors de la requête");
                    }
                });
            }

            /*** SOUSTRACTION  ***/
            function calcSub(matA,matB){
                $.post(apiURL + "/sub", {A_matrix:matA, B_matrix: matB}, function(data)
                {
                    if (typeof data.status === "string")
                    {
                        if (data.status === "success")
                        {
                            $("#result").html(buildHTMLTableFromMatrixArray(data.result));
                        }
                        else
                        {
                            alert(data.message);
                        }
                    }
                    else
                    {
                        alert("une erreur a eu lieu lors de la requête");
                    }
                });
            }

            /*** MULTIPLICATION ***/
            function calcMult(matA,matB){
                $.post(apiURL + "/multiply", {A_matrix:matA, B_matrix: matB}, function(data)
                {
                    if (typeof data.status === "string")
                    {
                        if (data.status === "success")
                        {
                            $("#result").html(buildHTMLTableFromMatrixArray(data.result));
                        }
                        else
                        {
                            alert(data.message);
                        }
                    }
                    else
                    {
                        alert("une erreur a eu lieu lors de la requête");
                    }
                });
            }

            function calcMultByReal(matA,matB){
                $.post('/multiply-real/', {matriceA :matA, matriceB: matB}, function(data)
                {
                    $('#result-multiple').append(data);
                })
            }

            /*** TRANSPOSE ***/
            function calcTranspose(matA){
                $.post(apiURL + "/transpose", {A_matrix:matA}, function(data)
                {
                    if (typeof data.status === "string")
                    {
                        if (data.status === "success")
                        {
                            $("#result").html(buildHTMLTableFromMatrixArray(data.result));
                        }
                        else
                        {
                            alert(data.message);
                        }
                    }
                    else
                    {
                        alert("une erreur a eu lieu lors de la requête");
                    }
                });
            }

            /*** TRACE ***/
            function calcTrace(matA,matB){
                $.post('', {matriceA :matA, matriceB: matB}, function(data)
                {
                    $('#result-trace').append(data);
                })
            }
        });
    },
    _initCanvas: function(){

        var canvas = document.getElementById("matrix-canvas"),
            context = canvas.getContext('2d');

        context.globalCompositeOperation = 'lighter';
        canvas.width = $(window).width();
        canvas.height = $(window).height();
        draw();

        var textStrip = ['诶', '比', '西', '迪', '伊', '吉', '艾', '杰', '开', '哦', '屁', '提', '维'];

        var stripCount = 60, stripX = new Array(), stripY = new Array(), dY = new Array(), stripFontSize = new Array();

        for (var i = 0; i < stripCount; i++) {
            stripX[i] = Math.floor(Math.random()*canvas.width);
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
    }
};
