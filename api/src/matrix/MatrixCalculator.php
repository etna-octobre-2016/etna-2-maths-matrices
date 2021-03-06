<?php namespace Matrix;

class MatrixCalculator
{
    // PUBLIC STATIC METHODS
    ///////////////////////////////////////////////////////////////////////////

    public static function add(Matrix $aMatrix, Matrix $bMatrix)
    {
        if ($aMatrix->getColumnsCount() !== $bMatrix->getColumnsCount() || $aMatrix->getLinesCount() !== $bMatrix->getLinesCount())
        {
            throw new MatrixException("matrices are not of the same format");
        }

        $aMatrixArray       = $aMatrix->getArray();
        $bMatrixArray       = $bMatrix->getArray();
        $resultMatrixArray  = [];

        foreach ($aMatrixArray as $lineIndex => $lineColumns)
        {
            foreach ($lineColumns as $columnIndex => $cellValue)
            {
                $resultMatrixArray[$lineIndex][$columnIndex] = $cellValue + $bMatrixArray[$lineIndex][$columnIndex];
            }
        }
        return new Matrix($resultMatrixArray);
    }
    public static function sub(Matrix $aMatrix, Matrix $bMatrix)
    {
        if ($aMatrix->getColumnsCount() !== $bMatrix->getColumnsCount() || $aMatrix->getLinesCount() !== $bMatrix->getLinesCount())
        {
            throw new MatrixException("matrices are not of the same format");
        }
        return self::add($aMatrix, self::multiplyByReal($bMatrix, -1));
    }
    public static function multiply(Matrix $aMatrix, Matrix $bMatrix)
    {
        if ($aMatrix->getColumnsCount() !== $bMatrix->getLinesCount())
        {
            throw new MatrixException("the number of columns in the first matrix is not equal to the number of lines in the second matrix");
        }

        $aMatrixArray           = $aMatrix->getArray();
        $bMatrixArray           = $bMatrix->getArray();
        $bMatrixColumnsCount    = $bMatrix->getColumnsCount();
        $resultMatrixArray      = [];

        foreach ($aMatrixArray as $i => $aLineColumns)
        {
            for ($j = 0; $j < $bMatrixColumnsCount; $j++)
            {
                $resultMatrixArray[$i][$j] = 0;

                foreach ($aLineColumns as $k => $aCellValue)
                {
                    $resultMatrixArray[$i][$j] += $aMatrixArray[$i][$k] * $bMatrixArray[$k][$j];
                }
            }
        }
        return new Matrix($resultMatrixArray);
    }
    public static function multiplyByReal(Matrix $matrix, $real)
    {
        $matrixArray = $matrix->getArray();

        self::convertToNumber($real);
        foreach ($matrixArray as &$lineColumns)
        {
            foreach ($lineColumns as &$cell)
            {
                $cell *= $real;
            }
        }
        return new Matrix($matrixArray);
    }
    public static function resolveLinearSystem(Matrix $aMatrix, Matrix $yMatrix)
    {
        return self::multiply(self::invert($aMatrix), $yMatrix);
    }
    public static function transpose(Matrix $matrix)
    {
        $matrixArray       = $matrix->getArray();
        $resultMatrixArray = [];

        foreach ($matrixArray as $lineIndex => $columns)
        {
            foreach ($columns as $columnIndex => $cellValue)
            {
                $resultMatrixArray[$columnIndex][$lineIndex] = $cellValue;
            }
        }
        return new Matrix($resultMatrixArray);
    }
    public static function invert(Matrix $matrix)
    {
        $determinant = $matrix->getDeterminant();

        if ($determinant === 0)
        {
            throw new MatrixException('this matrix cannot be inverted');
        }

        $matrixArray = $matrix->getArray();

        if ($matrix->getOrder() > 2)
        {
            $determinantMatrixArray = [];

            foreach ($matrixArray as $lineIndex => $columns)
            {
                foreach ($columns as $columnIndex => $cellValue)
                {
                    $subMatrix = $matrix->getSubMatrix($lineIndex, $columnIndex);
                    $subMatrixDeterminant = $subMatrix->getDeterminant();

                    // @note: le signe du determinant change lorsque l'on passe d'une colonne à une autre
                    if (($lineIndex % 2 === 0 && $columnIndex % 2 !== 0) || ($lineIndex % 2 !== 0 && $columnIndex % 2 === 0))
                    {
                        $subMatrixDeterminant *= -1;
                    }

                    $determinantMatrixArray[$lineIndex][$columnIndex] = $subMatrixDeterminant;
                }
            }

            $inverseMatrix = self::multiplyByReal(
                self::transpose(new Matrix($determinantMatrixArray)), (1 / $determinant)
            );
        }
        else
        {
            $inverseMatrix = self::multiplyByReal(
                new Matrix([
                    [$matrixArray[1][1], -$matrixArray[0][1]],
                    [-$matrixArray[1][0], $matrixArray[0][0]],
                ]),
                (1 / $determinant)
            );
        }
        return $inverseMatrix;
    }

    // PRIVATE STATIC METHODS
    ///////////////////////////////////////////////////////////////////////////

    private static function convertToNumber(&$numericValue)
    {
        $intValue = filter_var($numericValue, FILTER_VALIDATE_INT);
        $floatValue = filter_var($numericValue, FILTER_VALIDATE_FLOAT);

        if ($intValue !== false)
        {
            $numericValue = $intValue;
        }
        else if ($floatValue !== false)
        {
            $numericValue = $floatValue;
        }
        else
        {
            throw new MatrixException("$numericValue is not a valid numeric value");
        }
    }
}
