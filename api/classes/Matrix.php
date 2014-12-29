<?php
class Matrix
{
    private $array;
    private $columnsCount;
    private $linesCount;

    // CONSTRUCTOR
    ////////////////////////////////////////////////////////////////////////////////////////

    function __construct($matrixArray)
    {
        self::validateMatrixArray($matrixArray);

        $this->array = $matrixArray;
        $this->linesCount = count($matrixArray);
        $this->columnsCount = max(self::getLinesLengths($matrixArray));
    }

    // GETTERS
    ////////////////////////////////////////////////////////////////////////////////////////

    public function getArray()
    {
        return $this->array;
    }
    public function getColumnsCount()
    {
        return $this->columnsCount;
    }
    public function getLinesCount()
    {
        return $this->linesCount;
    }

    // PUBLIC STATIC METHODS
    ////////////////////////////////////////////////////////////////////////////////////////

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

        self::convertCellValue($real);
        foreach ($matrixArray as &$lineColumns)
        {
            foreach ($lineColumns as &$cell)
            {
                $cell *= $real;
            }
        }
        return new Matrix($matrixArray);
    }


    // PRIVATE STATIC METHODS
    ////////////////////////////////////////////////////////////////////////////////////////

    private static function convertCellValue(&$matrixCell)
    {
        $intValue = filter_var($matrixCell, FILTER_VALIDATE_INT);
        $floatValue = filter_var($matrixCell, FILTER_VALIDATE_FLOAT);

        if ($intValue !== false)
        {
            $matrixCell = $intValue;
        }
        else if ($floatValue !== false)
        {
            $matrixCell = $floatValue;
        }
        else
        {
            throw new MatrixException("$matrixCell is not a valid cell value");
        }
    }
    private static function getLinesLengths($matrixArray)
    {
        return array_map('count', $matrixArray);
    }
    private static function hasEqualLinesLengths($matrixLinesLengths)
    {
        return count(array_unique($matrixLinesLengths)) === 1 ? true : false;
    }
    private static function validateMatrixArray(&$matrixArray)
    {
        if (!is_array($matrixArray))
        {
            throw new MatrixException('the constructor expects an array');
        }
        foreach ($matrixArray as $lineIndex => &$matrixLine)
        {
            if (!is_array($matrixLine) || count($matrixLine) === 0)
            {
                throw new MatrixException("Line n°$lineIndex has no column");
            }
            foreach ($matrixLine as $columnIndex => &$matrixCell)
            {
                if (!is_numeric($matrixCell))
                {
                    throw new MatrixException("Cell $lineIndex,$columnIndex doesn't contain a numeric value");
                }
                self::convertCellValue($matrixCell);
            }
        }

        $matrixLinesLengths = self::getLinesLengths($matrixArray);

        if (!self::hasEqualLinesLengths($matrixLinesLengths))
        {
            throw new MatrixException('each line need to have the same number of columns');
        }
    }
}
