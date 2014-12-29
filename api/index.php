<?php
require 'classes/Matrix.php';
require 'classes/MatrixCalculator.php';
require 'classes/MatrixException.php';

header('Content-Type: application/json');

try
{
    $aMatrix = new Matrix([
        [2,     434,    -12,    0],
        [-565,  -2,     23,     69]
    ]);

    $bMatrix = new Matrix([
        [34,    767,    80,     98,     0],
        [-232,  -4,     232,    -998,   8923],
        [45,    1,      2,      65,     -9],
        [3,     6,      8,      0,      -42]
    ]);

    // $result = MatrixCalculator::add($aMatrix, $bMatrix);
    // $result = MatrixCalculator::sub($aMatrix, $bMatrix);
    // $result = MatrixCalculator::multiplyByReal($aMatrix, '-1');
    $result = MatrixCalculator::multiply($aMatrix, $bMatrix);

    var_dump($result->getArray());

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
