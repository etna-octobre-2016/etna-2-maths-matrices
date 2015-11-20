<?php namespace polynome;

class Polynome
{
    private $listCoef;
    private $listUnknow;

    // CONSTRUCTOR
    //////////////////////////////////////////////////////////////////////////

    function __construct()
    {

        $this->listCoef = null;
        $this->listUnknow = null;
    }


    // Phase 1 : retourne un tableau de toutes les racine d'un polynome
    // a3(x0)^3 + a2(x0)^2 + a1(x0)+a0 = 0
    public static function getRacine($listCoef, $listX)
    {
        $tabRacine;
        $res    = null;
        $k      =0;

        for ($i = 0; $i <= count($listX); $i++)
        {
            $res =  ( $listCoef[3]*pow($listX[$i],3) )
                    + ( $listCoef[2]*pow($listX[$i],2) )
                    + ( $listCoef[1]*$listX[$i] )
                    + $listCoef[$i];
            if ($res!=null && $res==0)
            {
                $tabRacine[$k]= $res;
                $k++;
            }
        }
        return res;
    }

}
