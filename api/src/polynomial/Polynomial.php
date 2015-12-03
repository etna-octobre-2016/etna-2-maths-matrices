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
        if($this->coefficients[0]==0){
            throw new PolynomialException('This Polynomial is not third degree.');
        }
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
        $sizeTabRoot   = count($arrayRoots);

        $root = $arrayRoots[0];
        if($root<0 && $sizeTabRoot>1){$root = $arrayRoots[1];}

        if ($coefficients[0]<0){
            $coefficients[0] = $coefficients[0]*-1;
            $coefficients[1] = $coefficients[1]*-1;
            $coefficients[2] = $coefficients[2]*-1;
            $coefficients[3] = $coefficients[3]*-1;
        }

         $res[0] =     $coefficients[0];                                           //quotient
         $res[1] =   ( $coefficients[1]  + ($root*$res[0]) );           //quotient
         $res[2] =   ( $coefficients[2]  + ($root*$res[1]) );           //quotient
         $res[3] =   ( $coefficients[3]  + ($root*$res[2]) );           //remainder

        return $res;
    }

    // cette fonction retourne de solutions x1 et x2 depuis un polynome 2nd degré
    public function getSolutions($quotients)
    {
        $quotient       = $quotients;
        $coefficients   = $this->coefficients;

        // initialisation de variable pour la division
        $xtermCoef      = $quotient[1]/$quotient[0];
        $xtermHalfCoef  = ($xtermCoef / 2);
        $commonFactor   = pow( ($xtermHalfCoef),2 );
        $x              = "x";
        $result         = [];

        // Polynome du 2nd degrés
        // Les opérateurs de calcul sont contenus dans la tableau quotient
        if ($quotient[2]<0){ $quotient[2] = abs($quotient[2]); }
        else{ $quotient[2] = $quotient[2] * (-1);}

        // step 6
        if ($xtermHalfCoef<0) { $xtermHalfCoef = abs($xtermHalfCoef); }
        else { $xtermHalfCoef = $xtermHalfCoef * (-1); }

        $right = ($quotient[2]+$commonFactor);

        $x1 = ( $xtermHalfCoef - sqrt($right) );
        $x2 = ( $xtermHalfCoef + sqrt($right) );

        // check is square
        if (sqrt($right) == 0){$this->isSquare = true;}

        $result[0] = $x1;
        $result[1] = $x2;

        return $result;
    }

    // retourne la polynome factorisé sous forme de string
    public function getResultFactorisation($minRoot,$maxRoot)
    {
        $quotient       = $this->getQuotients($minRoot,$maxRoot);
        $solutions      = $this->getSolutions($quotient);
        $coefficients   = $this->coefficients;
        $result         = "error";
        $sign           = "";

        if ($this->isSquare == true)
        {
            $sign0 = "";
            if($coefficients[0]<0){$sign0 = "-";}
            $result = "(".$solutions[0]." ".$sign0." x)^3";
        }
        else if($coefficients[1]==0){
            $sign1 = "-";
            if($solutions[1]<0){$sign1="+";$solutions[1]=abs($solutions[1]);}
            if($solutions[0]<0){$sign2="+";$solutions[0]=abs($solutions[0]);}
            if($coefficients[0]<0){$sign0="-";}
            $result = $sign0."( x ".$sign1." ".$solutions[1]." )^2 * ( ".$quotient[0]."x ".$sign2." ".$solutions[0]." )";
        }
        else{
            if($coefficients[0]<0){$sign = "-";}
            $result = $sign."( x - (".$quotient[0].") ) ( x - (".$solutions[0].") )( x - (".$solutions[1].") )";
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
