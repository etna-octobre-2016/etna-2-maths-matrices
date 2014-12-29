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

    $cMatrix = new Matrix([
        [1, 2],
        [1, 2]
    ]);

    // $result = MatrixCalculator::add($aMatrix, $bMatrix);
    // $result = MatrixCalculator::sub($aMatrix, $bMatrix);
    // $result = MatrixCalculator::multiplyByReal($aMatrix, '-1');
    // $result = MatrixCalculator::multiply($aMatrix, $bMatrix);
    // $result = MatrixCalculator::transpose($aMatrix);
    // var_dump($result->getArray());

    var_dump([
        'a_is_squaure' => $aMatrix->isSquare(),
        'b_is_squaure' => $bMatrix->isSquare(),
        'c_is_squaure' => $cMatrix->isSquare()
    ]);

    $response = [
        'status'    => 'success',
        'resources' => null
    ];
}
catch (MatrixException $e)
{
    var_dump($e);

    $response = [
        'status'    => 'failure',
        'message'   => $e->getMessage()
    ];
}

echo json_encode($response);
