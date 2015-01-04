<?php namespace App;

// Vendors classes
use Symfony\Component\HttpFoundation\Request  as SilexRequest;
use Symfony\Component\HttpFoundation\Response as SilexResponse;

// Application classes
use Matrix\Matrix;
use Matrix\MatrixCalculator;
use Matrix\MatrixException;

class ApplicationRouter
{
    // PUBLIC STATIC METHODS
    ////////////////////////////////////////////////////////////////////////////////////////

    public static function add(SilexRequest $request, Application $app)
    {
        $aMatrixArray    = $request->request->get('A_matrix');
        $bMatrixArray    = $request->request->get('B_matrix');

        if (is_array($aMatrixArray) && is_array($bMatrixArray))
        {
            try
            {
                $aMatrix  = new Matrix($aMatrixArray);
                $bMatrix  = new Matrix($bMatrixArray);
                $cMatrix  = MatrixCalculator::add($aMatrix, $bMatrix);
                $response = [
                    'status' => 'success',
                    'result' => $cMatrix->getArray()
                ];
            }
            catch (MatrixException $e)
            {
                $response = [
                    'status'  => 'error',
                    'message' => $e->getMessage()
                ];
            }
        }
        else
        {
            $response = [
                'status'  => 'error',
                'message' => 'An array for each matrix is expected'
            ];
        }
        return new SilexResponse($app->serialize($response), 200, self::getResponseHeaders());
    }
    public static function sub(SilexRequest $request, Application $app)
    {
        $aMatrixArray    = $request->request->get('A_matrix');
        $bMatrixArray    = $request->request->get('B_matrix');

        if (is_array($aMatrixArray) && is_array($bMatrixArray))
        {
            try
            {
                $aMatrix  = new Matrix($aMatrixArray);
                $bMatrix  = new Matrix($bMatrixArray);
                $cMatrix  = MatrixCalculator::sub($aMatrix, $bMatrix);
                $response = [
                    'status' => 'success',
                    'result' => $cMatrix->getArray()
                ];
            }
            catch (MatrixException $e)
            {
                $response = [
                    'status'  => 'error',
                    'message' => $e->getMessage()
                ];
            }
        }
        else
        {
            $response = [
                'status'  => 'error',
                'message' => 'An array for each matrix is expected'
            ];
        }
        return new SilexResponse($app->serialize($response), 200, self::getResponseHeaders());
    }
    public static function welcome(SilexRequest $request, Application $app)
    {
        $response = [
            'status'  => 'success',
            'message' => 'Welcome to the Matrix Project API'
        ];
        return new SilexResponse($app->serialize($response), 200, self::getResponseHeaders());
    }

    // PRIVATE STATIC METHODS
    ////////////////////////////////////////////////////////////////////////////////////////

    private static function getResponseHeaders()
    {
        return ['Content-Type' => 'application/json'];
    }
}
