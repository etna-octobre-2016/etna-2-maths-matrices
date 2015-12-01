<?php namespace Polynomial;

class Polynomial
{
    private $coefficients;
    private $isSquare;

    //////////////////////////////////////////////////////////////////////////
    // PUBLIC INSTANCE METHODS
    //////////////////////////////////////////////////////////////////////////

    public function __construct($coefficients)
    {
        $this->validateCoefficients($coefficients);
        $this->coefficients = $coefficients;
        $this->isSquare = false;
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

    // retourne les quotients du polynome du 2nd degrés
    public function getQuotients($minroot,$maxroot)
    {
        $arrayRoots    = $this->getRoots($minroot,$maxroot);
        $coefficients  = $this->coefficients;
        $res           = [];
        echo "array Root\n";
        var_dump($arrayRoots);
        echo "\ncoefficients\n";
        var_dump($coefficients);

        if ($coefficients[0]<0){
            $coefficients[0] = $coefficients[0]*-1;
            $coefficients[1] = $coefficients[1]*-1;
            $coefficients[2] = $coefficients[2]*-1;
            $coefficients[3] = $coefficients[3]*-1;
        }

         $res[0] =     $arrayRoots[0];                                           //quotient
         $res[1] =   ( $coefficients[1]  + ($arrayRoots[0]*$res[0]) );           //quotient
         $res[2] =   ( $coefficients[2]  + ($arrayRoots[0]*$res[1]) );           //quotient
         $res[3] =   ( $coefficients[3]  + ($arrayRoots[0]*$res[2]) );           //remainder

        return $res;
    }

    // voir exemple de calcul -> www.mathportal.org/calculators/solving-equations/quadratic-equation-solver.php?val1=1&combo1=2&val2=5&combo2=1&val3=6&rb1=s
    // cette fonction retourne de solutions x1 et x2 depuis un polynome 2nd degré
    public function getSolutions($minroot, $maxroot)
    {
        $quotient     = $this->getQuotients($minroot,$maxroot);
        echo "quotients polynome 2nd degrée \n";
        var_dump($quotient);
        $coefficients   = $this->coefficients;

        // step 3
        //$xtermCoef      = ($quotient[1] / $quotient[0]);
        $xtermCoef      = $quotient[1];
        $xtermHalfCoef  = ($xtermCoef / 2);
        $commonFactor   = pow( ($xtermHalfCoef),2 );
        $x              = "x";
        $result         = [];

        //step 4, 5
        // Polynome du 2nd degrés
        // Les opérateurs de calcul sont contenus dans la tableau quotient
        //$left  = pow( ($quotient[0]*$x/2 + $quotient[1]/2) , 2 );
        if ($quotient[2]<0){ $quotient[2] = abs($quotient[2]); }
        else{ $quotient[2] = $quotient[2] * (-1);}

        // step 6
        if ($xtermHalfCoef<0) { $xtermHalfCoef = abs($xtermHalfCoef); }
        else { $xtermHalfCoef = $xtermHalfCoef * (-1); }

        $right = ($quotient[2]+$commonFactor);

        // step 7
        echo "variable pour calcul x1 - x2 \n";
        echo "\nxtermCoef \n";
        echo $xtermCoef;
        echo "\nxtermHalfCoef \n";
        echo $xtermHalfCoef;
        echo "\nquotient[2] \n";
        echo $quotient[2];
        echo "\ncommonFactor \n";
        echo $commonFactor;
        echo "\n right \n";
        echo $right;
        echo "\n racine de right \n";
        echo sqrt($right);
        echo "\n";
        $x1 = ( $xtermHalfCoef - sqrt($right) );
        $x2 = ( $xtermHalfCoef + sqrt($right) );
        echo "\n";
        // check is square
        if (sqrt($right) == 0){$this->isSquare = true;}

        $result[0] = $x1;
        $result[1] = $x2;

        return $result;
    }

    // retourne la polynome factorisé sous forme de string
    public function getResultFactorisation($minroot, $maxroot)
    {
        $quotient  = $this->getQuotients($maxroot,$maxroot);
        $solutions = $this->getSolutions($minroot, $maxroot);
        $coefficients   = $this->coefficients;
        $result      = "error";
        echo " solutions x1 et x2 \n";
        var_dump($solutions);
        $sign = "+";
        if($coefficients[0]<0){$sign = "-";}
        if($quotient[1]==0){
            $result = "( x - ".$solutions[0]." )^2 ( x - ".$solutions[1]." )";
        }
        elseif ($this->isSquare === true)
        {
            $result = "(".$solutions[0]." ".$sign." x)^3";
        }
        else{
            $result = $sign."( x - ".$quotient[0].")( x - ".$solutions[0]." )( x - ".$solutions[1]." )";
        }

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
