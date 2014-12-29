<?php
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

        $aMatrixArray       = $aMatrix->getArray();
        $bMatrixArray       = $bMatrix->getArray();
        $resultMatrixArray  = [];

        foreach ($aMatrixArray as $lineIndex => $lineColumns)
        {
            foreach ($lineColumns as $columnIndex => $cellValue)
            {
                $resultMatrixArray[$lineIndex][$columnIndex] = $cellValue - $bMatrixArray[$lineIndex][$columnIndex];
            }
        }
        return new Matrix($resultMatrixArray);
    }
    public static function multiply(Matrix $aMatrix, Matrix $bMatrix)
    {
        if ($aMatrix->getColumnsCount() !== $bMatrix->getLinesCount())
        {
            throw new MatrixException("the number of columns in the first matrix is not equal to the number of lines in the second matrix");
        }

        $aMatrixArray           = $aMatrix->getArray();
        $aMatrixColumnsCount    = $aMatrix->getColumnsCount();
        $bMatrixArray           = $bMatrix->getArray();
        $resultMatrixArray      = [];

        foreach ($aMatrixArray as $aLineIndex => $aLineColumns)
        {
            // echo "<br>line n°$aLineIndex<br><br>";

            foreach ($aLineColumns as $aColumnIndex => $aCellValue)
            {
                // echo "column n°$aColumnIndex - value: $aCellValue<br>";

                $resultMatrixArray[$aLineIndex][$aColumnIndex] = 0;

                for ($i = 0; $i < $aMatrixColumnsCount; $i++)
                {
                    $resultMatrixArray[$aLineIndex][$aColumnIndex] += $aMatrixArray[$aLineIndex][$i] * $bMatrixArray[$i][$aColumnIndex];
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
