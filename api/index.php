<?php
require 'classes/MatrixException.php';
require 'classes/Matrix.php';

header('Content-Type: application/json');

try
{
    $matrixArray = [
        [0, '032', -45],
        [1, '-2332432']
    ];

    $matrix = new Matrix($matrixArray);

    var_dump([
        'array'         => $matrix->getArray(),
        'columnsCount'  => $matrix->getColumnsCount(),
        'linesCount'    => $matrix->getLinesCount(),
    ]);

    $response = [
        'status'    => 'success',
        'resources' => null
    ];
}
catch (MatrixException $e)
{
    $response = [
        'status'    => 'failure',
        'message'   => $e->getMessage()
    ];
}

echo json_encode($response);
