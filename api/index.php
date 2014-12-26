<?php
require 'classes/MatrixException.php';
require 'classes/Matrix.php';

try
{
    $matrix = [
        [0, 2, 7],
        [0, 1, 5, 2],
        [3, -12, 4, 0]
    ];


    var_dump($matrix);

    $matrixColumns = Matrix::getColumnsCount($matrix);
    $matrixhasEqualColumns = Matrix::hasEqualColumnsCountByLine($matrixColumns);

    var_dump($matrixhasEqualColumns);
}
catch (MatrixException $e)
{
    $response = [
        'status'    => 'failure',
        'message'   => $e->getMessage()
    ];
    echo json_encode($response);
}
