<?php
require 'classes/MatrixException.php';
require 'classes/Matrix.php';

header('Content-Type: application/json');

try
{
    $aMatrix = new Matrix([
        [1, 2, 3],
        [4, 5, 6]
    ]);

    $bMatrix = new Matrix([
        ['1', '2', 3],
        [4, 5, 6]
    ]);

    var_dump(Matrix::add($aMatrix, $bMatrix));
    var_dump(Matrix::sub($aMatrix, $bMatrix));
    var_dump(Matrix::multiplyByReal($bMatrix, '-1'));

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
