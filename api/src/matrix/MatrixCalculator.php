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
    public static function determ22(Matrix $matrix)
    {
        if (!$matrix->isSquare() || $matrix->getLinesCount() !== 2)
        {
            throw new MatrixException('2x2 matrix is excepted');
        }

        $array = $matrix->getArray();
        return ($array[0][0] * $array[1][1]) - ($array[0][1] * $array[1][0]);
    }
    public static function getMatriceForTranspose(Matrix $matrix){
        if (!$matrix->isSquare()){
            throw new MatrixException('Matrix is not Square for Inverse');
        }

        $matrice            = array();
        $ligneDeterminant   = array();
        $nbLine             = $matrix->getLinesCount();
        $nbCol              = $matrix->getColumnsCount();
        $determinant        = $matrix->getDeterminant();
        $i                  = 0;
        $j                  = 0;

        if($determinant !== 0)
        {
            while ($i < $nbLine)
            {
                while($j < $nbCol)
                {
                    $sub                   = $matrix->getSubMatrix($i,$j);
                    $subMatrixDeterminant  = $sub->getDeterminant();
                    
                    if(($i%2===0  && $j%2!==0) || ($i%2!==0  && $j%2===0))
                    {
                        $subMatrixDeterminant = -1 * $subMatrixDeterminant;
                    }
                    $ligneDeterminant[$i][$j] += $subMatrixDeterminant;
                    $j++;
                }
                $matrice = $ligneDeterminant; 
                $j=0;
                $i++;
            }
        }
        else
        {
            throw new MatrixException('Determinant is null -> 0');
        }

        return new Matrix($matrice);
    }
    public static function Inverse(){
        
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
