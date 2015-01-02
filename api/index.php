<?php
require 'classes/Matrix.php';
require 'classes/MatrixCalculator.php';
require 'classes/MatrixException.php';

try
{
    $aMatrix = new Matrix([
        [ 1, 2 ],
        [ 1, 1 ],
        [ 3, 4 ]
    ]);

    $bMatrix = new Matrix([
        [1, 2, 5, 6],
        [1, 2, '-12', 0]
    ]);

    $cMatrix = new Matrix([
        [ 1, 2, 2 ],
        [ 1, 10,1 ],
        [ 3, 4, 9 ]
    ]);

    $dMatrix = new Matrix([
        [ 89, -13 ],
        [ 4,22 ]
    ]);

    // $result = MatrixCalculator::add($aMatrix, $bMatrix);
    // $result = MatrixCalculator::multiplyByReal($aMatrix, 2);
    // $result = MatrixCalculator::transpose($aMatrix);
    // $result = MatrixCalculator::multiply($aMatrix, $bMatrix);

    //$aMatrix->debugHTML("Matrice A");
    echo "<br><br>";
    //$bMatrix->debugHTML("Matrice B");
    echo "<br><br>";
    // $result->debugHTML("Matrice A + B");
    // $result->debugHTML("Matrice 2 x A");
    // $result->debugHTML("Matrice transposée de A");
    //$result->debugHTML("Matrice A x B");

    
    // $result->debugHTML("toto");
    // $resultc = $cMatrix->getTrace();
    // echo $resultc;

    $result = MatrixCalculator::determ22($dMatrix);
    var_dump($result);

}
catch (MatrixException $e)
{
    echo $e->getMessage();
}
