<?php
require 'classes/Matrix.php';
require 'classes/MatrixCalculator.php';
require 'classes/MatrixException.php';

try
{
    $aMatrix = new Matrix([
        [1, 2],
        [1, 2],
        [3, 4]
    ]);

    $bMatrix = new Matrix([
        [1, 2, 5, 6],
        [1, 2, '-12', 0]
    ]);

    // $result = MatrixCalculator::add($aMatrix, $bMatrix);
    // $result = MatrixCalculator::multiplyByReal($aMatrix, 2);
    // $result = MatrixCalculator::transpose($aMatrix);
    $result = MatrixCalculator::multiply($aMatrix, $bMatrix);

    $aMatrix->debugHTML("Matrice A");
    echo "<br><br>";
    $bMatrix->debugHTML("Matrice B");
    echo "<br><br>";
    // $result->debugHTML("Matrice A + B");
    // $result->debugHTML("Matrice 2 x A");
    // $result->debugHTML("Matrice transposée de A");
    $result->debugHTML("Matrice A x B");
}
catch (MatrixException $e)
{
    echo $e->getMessage();
}
