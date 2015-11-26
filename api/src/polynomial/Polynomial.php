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

    public function getQuotients()
    {
        $arrayRoots    = getRoots();
        $coefficients  = $this->coefficients;
        $res           = [];
        //$operator    = $this->$operators;
        //$x           = null;
        //$qx          = ($x - $arrayRoots[0]);
        //$px          = ($coefficients[0]*$x^3)$operator[0]($coefficients[1]*$x^2)$operator[1]($coefficients[2]*$x)$operator[2]($coefficients[3]);

        $res[0] =   $coefficients[0];                                    //quotient
        $res[1] =   $coefficients[1]  + ($arrayRoots[0]*$res[0]);       //quotient
        $res[2] =   $coefficients[2]  + ($arrayRoots[0]*$res[1]);      //quotient
        $res[3] =   $coefficients[3]  + ($arrayRoots[0]*$res[2]);     //remainder

        return $res;
    }

    public function getSolutions()
    {
        $quotient[]     = getQuotient();
        $coefficients   = $this->coefficients;
        $xtermCoef      = $quotient[1];
        $commonFactor   = exp($xtermCoef/2)^2;
        $x              = "x";
        $result         = [];

        // Polynome du 2nd degrés
        // Les opérateurs de calcul sont contenus dans la tableau quotient
        $left  = ($quotient[0]*$x/2 + $quotient[1]/2)^2;
        $right = ($quotient[2]+$commonFactor);

        $result[0] = null;
        $result[1] = null;

        return $result;
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
