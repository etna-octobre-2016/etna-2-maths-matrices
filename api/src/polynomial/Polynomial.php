<?php namespace Polynomial;

class Polynomial
{
    private $coefficients;

    //////////////////////////////////////////////////////////////////////////
    // PUBLIC INSTANCE METHODS
    //////////////////////////////////////////////////////////////////////////

    public function __construct($coefficients)
    {
        $this->validateCoefficients($coefficients);
        $this->coefficients = $coefficients;
    }
    public function getRoots($minRoot, $maxRoot)
    {
        if (!is_int($minRoot))
        {
            throw new PolynomialException('Min root is not an integer');
        }
        if (!is_int($maxRoot))
        {
            throw new PolynomialException('Max root is not an integer');
        }
        if ($minRoot > $maxRoot)
        {
            throw new PolynomialException('Min root is greater than max root');
        }
        $coefficients = $this->coefficients;
        $coefficientsCount = count($coefficients);
        $max = $maxRoot + 1;
        $roots = [];
        for ($x = $minRoot; $x < $max; $x++)
        {
            $result = 0;
            for ($i = 0; $i < $coefficientsCount; $i++)
            {
                $a = $coefficients[$i];
                $result = $result + $a * pow($x, ($coefficientsCount - $i - 1));
            }
            if ($result === 0)
            {
                $roots[] = $x;
            }
        }
        return $roots;
    }
    public function getFactorise($equation)
    {
        $arrayRoots = getRoots();
        $x          = null;
        
        $calc       = ($x - $arrayRoots[0])()

    }

    //////////////////////////////////////////////////////////////////////////
    // PUBLIC STATIC METHODS
    //////////////////////////////////////////////////////////////////////////

    public static function validateCoefficients($coefficients)
    {
        if (!is_array($coefficients))
        {
            throw new PolynomialException('Coefficients are not listed in an array');
        }
        $count = count($coefficients);
        if ($count === 0)
        {
            throw new PolynomialException('Coefficients list is empty');
        }
        for ($i = 0; $i < $count; $i++)
        {
            if (!is_int($coefficients[$i]))
            {
                throw new PolynomialException('Coefficient item #'.$i.' is not an integer');
            }
        }
    }
}
