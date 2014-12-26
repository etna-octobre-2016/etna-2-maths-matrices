<?php
class Matrix
{
    public static function getColumnsCount($matrixArray)
    {
        return array_map('count', $matrixArray);
    }
    public static function hasEqualColumnsCountByLine($matrixColumns)
    {
        $hasEqualColumnsCountByLine = count(array_unique($matrixColumns)) === 1 ? true : false;
        if (!$hasEqualColumnsCountByLine)
        {
            throw new MatrixException('has not the same number of columns on each line');
        }
        return true;
    }
}
