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

        $res[0] =   $coefficients[0];                                    //quotient
        $res[1] =   $coefficients[1]  + ($arrayRoots[0]*$res[0]);       //quotient
        $res[2] =   $coefficients[2]  + ($arrayRoots[0]*$res[1]);      //quotient
        $res[3] =   $coefficients[3]  + ($arrayRoots[0]*$res[2]);     //remainder

        return $res;
    }

    // voir exemple de calcul -> www.mathportal.org/calculators/solving-equations/quadratic-equation-solver.php?val1=1&combo1=2&val2=5&combo2=1&val3=6&rb1=s
    // cette fonction retourne de solutions x1 et x2 depuis un polynome 2nd degré
    public function getSolutions()
    {
        $quotient[]     = getQuotients();
        $coefficients   = $this->coefficients;

        // step 3
        $xtermCoef      = ($quotient[1] / $quotient[0]);
        $xtermHalfCoef  = ($xtermCoef / 2);
        $commonFactor   = pow( ($xtermHalfCoef),2 );
        $x              = "x";
        $result         = [];

        //step 4, 5
        // Polynome du 2nd degrés
        // Les opérateurs de calcul sont contenus dans la tableau quotient
        //$left  = pow( ($quotient[0]*$x/2 + $quotient[1]/2) , 2 );
        if ($quotient[2]<0) { $quotient[2] = abs($quotient[2]) }
        else { $quotient[2] = -$quotient[2] }

        $right = ($quotient[2]+$commonFactor);

        // step 6
        if ($xtermHalfCoef<0) { $xtermHalfCoef = abs($xtermHalfCoef) }
        else { $xtermHalfCoef = -$xtermHalfCoef }

        // step 7
        $x1 = ( $xtermHalfCoef + sqrt($right) );
        $x2 = ( $xtermHalfCoef - sqrt($right) );

        $result[0] = $x1;
        $result[1] = $x2;

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
