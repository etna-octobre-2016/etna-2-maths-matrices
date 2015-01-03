<?php namespace Matrix;

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

    // PUBLIC METHODS
    ////////////////////////////////////////////////////////////////////////////////////////

    public function debugHTML($title = "")
    {
        $html[] = '<table style="border:1px solid black; border-collapse: collapse;">';
        $html[] = "<caption>$title</caption>";
        $html[] = '<thead>';
        $html[] = '<tr>';
        $html[] = '<th style="border:1px solid black; background-color: #BBB; padding: 5px;">i / j</th>';

        for ($j = 0; $j < $this->getColumnsCount(); $j++)
        {
            $html[] = '<th style="border:1px solid black; background-color: #BBB; padding: 5px;">'.($j + 1).'</th>';
        }

        $html[] = '</tr>';
        $html[] = '</thead>';
        $html[] = '<tbody>';

        foreach ($this->getArray() as $i => $columns)
        {
            $html[] = '<tr>';
            $html[] = '<th style="border:1px solid black; background-color: #BBB; padding: 5px;">'.($i + 1).'</th>';

            foreach ($columns as $cellValue)
            {
                $html[] = '<td style="border:1px solid black; text-align: center; padding: 5px;">'.$cellValue.'</td>';
            }

            $html[] = '</tr>';
        }

        $html[] = '</tbody>';
        $html[] = '</table>';
        echo implode('', $html);
    }
    public function getDeterminant()
    {
        if (!$this->isSquare())
        {
            throw new MatrixException('determinant not available for non square matrix');
        }

        if ($this->getLinesCount() === 2)
        {
            $determinant = MatrixCalculator::determ22($this);
        }
        else
        {
            $determinant = 0;
            $matrixArray = $this->getArray();

            foreach ($matrixArray[0] as $columnIndex => $cellValue)
            {
                $subMatrix = $this->getSubMatrix(0, $columnIndex);
                $subMatrixDeterminant = $subMatrix->getDeterminant();

                // @note: le signe du determinant change lorsque l'on passe d'une colonne à une autre
                if ($columnIndex % 2 !== 0)
                {
                    $subMatrixDeterminant *= -1;
                }

                $determinant += $cellValue * $subMatrixDeterminant;
            }
        }
        return $determinant;
    }
    public function getIdentityMatrix()
    {
        if (!$this->isSquare())
        {
            throw new MatrixException("the identity matrix not available for a non square matrix");
        }

        $matrixArray = $this->getArray();
        $identityMatrixArray = [];

        foreach ($matrixArray as $lineIndex => $columns)
        {
            foreach ($columns as $columnIndex => $cellValue)
            {
                $identityMatrixArray[$lineIndex][$columnIndex] = ($lineIndex === $columnIndex) ? 1 : 0;
            }
        }
        return new Matrix($identityMatrixArray);
    }
    public function getTrace()
    {
        if (!$this->isSquare()){
            throw new MatrixException("Your Matrix is not Square");
        }
        $matrixArray = $this->getArray();
        $nbCol       = $this->getColumnsCount();

        for ($i=0;$i<$nbCol;++$i){
            $result += $matrixArray[$i][$i];
        }
        return $result;
    }
    public function getSubMatrix($excludedLineIndex, $excludedColumnIndex)
    {
        if (!is_int($excludedLineIndex) || !is_int($excludedColumnIndex))
        {
            throw new MatrixException('excluded line or column index must be an integer');
        }

        if ($excludedLineIndex < 0 || $excludedColumnIndex < 0)
        {
            throw new MatrixException('excluded line or column index cannot be negative');
        }

        if ($excludedLineIndex >= $this->getLinesCount() || $excludedColumnIndex >= $this->getColumnsCount())
        {
            throw new MatrixException('excluded line or column index is out of range');
        }

        $matrixArray    = $this->getArray();
        $newLineIndex   = 0;
        $subMatrixArray = [];

        foreach ($matrixArray as $lineIndex => $columns)
        {
            if ($lineIndex !== $excludedLineIndex)
            {
                $newColumnIndex = 0;
                foreach ($columns as $columnIndex => $cellValue)
                {
                    if ($columnIndex !== $excludedColumnIndex)
                    {
                        $subMatrixArray[$newLineIndex][$newColumnIndex] = $cellValue;
                        $newColumnIndex++;
                    }
                }
                $newLineIndex++;
            }
        }
        return new Matrix($subMatrixArray);
    }
    public function isEqualTo(Matrix $otherMatrix)
    {
        if ($this->getColumnsCount() !== $otherMatrix->getColumnsCount() || $this->getLinesCount() !== $otherMatrix->getLinesCount())
        {
            return false;
        }

        $matrixArray = $this->getArray();
        $otherMatrixArray = $otherMatrix->getArray();

        foreach ($matrixArray as $lineIndex => $columns)
        {
            foreach ($columns as $columnIndex => $cellValue)
            {
                if ($cellValue !== $otherMatrixArray[$lineIndex][$columnIndex])
                {
                    return false;
                }
            }
        }
        return true;
    }
    public function isIdentityMatrix()
    {
        return $this->isEqualTo($this->getIdentityMatrix());
    }
    public function isSquare()
    {
        if ($this->getLinesCount() === $this->getColumnsCount())
        {
            return true;
        }
        return false;
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
