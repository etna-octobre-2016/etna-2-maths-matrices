<?php
require 'classes/MatrixException.php';
require 'classes/Matrix.php';

header('Content-Type: application/json');

try
{
    $matrixArray = [
        [0, '032'],
        [-21, '+20.002', 4],
        [1, '-2332432']
    ];

    // $var = filter_var('755', FILTER_VALIDATE_INT);

    // var_dump($var);

    $matrix = new Matrix($matrixArray);

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
