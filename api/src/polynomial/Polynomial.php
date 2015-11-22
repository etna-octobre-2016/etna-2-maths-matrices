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
