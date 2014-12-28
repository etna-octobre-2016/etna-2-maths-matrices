<?php
require 'classes/MatrixException.php';
require 'classes/Matrix.php';

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

    // var_dump(Matrix::add($aMatrix, $bMatrix));
    // var_dump(Matrix::sub($aMatrix, $bMatrix));
    // var_dump(Matrix::multiplyByReal($bMatrix, '-1'));

    $result = Matrix::multiply($aMatrix, $bMatrix);

    // var_dump($result->getArray());

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
