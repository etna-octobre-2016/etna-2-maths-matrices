<?php
require 'classes/Matrix.php';
require 'classes/MatrixCalculator.php';
require 'classes/MatrixException.php';

try
{
    $aMatrix = new Matrix([
        [1,2,3,4],
        [1,0,2,0],
        [0,1,2,3],
        [2,3,0,0]
    ]);

    $aMatrix->debugHTML("Matrice A");
    var_dump($aMatrix->getDeterminant());
}
catch (MatrixException $e)
{
    echo $e->getMessage();
}
