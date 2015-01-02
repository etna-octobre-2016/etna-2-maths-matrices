<?php
require 'classes/Matrix.php';
require 'classes/MatrixCalculator.php';
require 'classes/MatrixException.php';

try
{
    $aMatrix = new Matrix([
        [1, 2, 4],
        [2, -1, 3],
        [4, 0, 1]
    ]);

    $aMatrix->debugHTML("Matrice A");

    $aMatrix->getDeterminant();
}
catch (MatrixException $e)
{
    echo $e->getMessage();
}
