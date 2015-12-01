<?php namespace App;

// Vendors classes
use Symfony\Component\HttpFoundation\Request  as SilexRequest;
use Symfony\Component\HttpFoundation\Response as SilexResponse;

// Application classes
use Matrix\Matrix;
use Matrix\MatrixCalculator;
use Matrix\MatrixException;
use Polynomial\Polynomial;
use Polynomial\PolynomialException;

class ApplicationRouter
{
    ////////////////////////////////////////////////////////////////////////////
    // GENERIC PUBLIC STATIC METHODS
    ////////////////////////////////////////////////////////////////////////////

    public static function welcome(SilexRequest $request, Application $app)
    {
        $response = [
            'status'  => 'success',
            'message' => 'Welcome to the Matrix Project API'
        ];
        return new SilexResponse($app->serialize($response), 200, self::getResponseHeaders());
    }

    ////////////////////////////////////////////////////////////////////////////
    // MATRIX PUBLIC STATIC METHODS
    ////////////////////////////////////////////////////////////////////////////

    public static function matrixAdd(SilexRequest $request, Application $app)
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
    public static function matrixGauss(SilexRequest $request, Application $app)
    {
        $aMatrixArray = $request->request->get('A_matrix');
        $yMatrixArray = $request->request->get('Y_matrix');

        if (is_array($aMatrixArray) && is_array($yMatrixArray))
        {
            try
            {
                $aMatrix  = new Matrix($aMatrixArray);
                $yMatrix  = new Matrix($yMatrixArray);
                $xMatrix  = MatrixCalculator::resolveLinearSystem($aMatrix, $yMatrix);
                $response = [
                    'status' => 'success',
                    'result' => $xMatrix->getArray()
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
    public static function matrixInvert(SilexRequest $request, Application $app)
    {
        $aMatrixArray = $request->request->get('A_matrix');

        if (is_array($aMatrixArray))
        {
            try
            {
                $aMatrix       = new Matrix($aMatrixArray);
                $inverseMatrix = MatrixCalculator::invert($aMatrix);
                $response      = [
                    'status' => 'success',
                    'result' => $inverseMatrix->getArray()
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
                'message' => 'A matrix array is expected'
            ];
        }
        return new SilexResponse($app->serialize($response), 200, self::getResponseHeaders());
    }
    public static function matrixMultiply(SilexRequest $request, Application $app)
    {
        $aMatrixArray    = $request->request->get('A_matrix');
        $bMatrixArray    = $request->request->get('B_matrix');

        if (is_array($aMatrixArray) && is_array($bMatrixArray))
        {
            try
            {
                $aMatrix  = new Matrix($aMatrixArray);
                $bMatrix  = new Matrix($bMatrixArray);
                $cMatrix  = MatrixCalculator::multiply($aMatrix, $bMatrix);
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
    public static function matrixMultiplyByReal(SilexRequest $request, Application $app)
    {
        $real         = $request->request->get('real');
        $aMatrixArray = $request->request->get('A_matrix');

        if (is_array($aMatrixArray) && is_numeric($real))
        {
            try
            {
                $aMatrix  = new Matrix($aMatrixArray);
                $bMatrix  = MatrixCalculator::multiplyByReal($aMatrix, $real);
                $response = [
                    'status' => 'success',
                    'result' => $bMatrix->getArray()
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
                'message' => 'An array for the matrix and a numeric value are expected'
            ];
        }
        return new SilexResponse($app->serialize($response), 200, self::getResponseHeaders());
    }
    public static function matrixSub(SilexRequest $request, Application $app)
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
    public static function matrixTrace(SilexRequest $request, Application $app)
    {
        $aMatrixArray = $request->request->get('A_matrix');

        if (is_array($aMatrixArray))
        {
            try
            {
                $aMatrix  = new Matrix($aMatrixArray);
                $response = [
                    'status' => 'success',
                    'result' => $aMatrix->getTrace()
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
                'message' => 'An array for the matrix is expected'
            ];
        }
        return new SilexResponse($app->serialize($response), 200, self::getResponseHeaders());
    }
    public static function matrixTranspose(SilexRequest $request, Application $app)
    {
        $aMatrixArray = $request->request->get('A_matrix');

        if (is_array($aMatrixArray))
        {
            try
            {
                $aMatrix  = new Matrix($aMatrixArray);
                $bMatrix  = MatrixCalculator::transpose($aMatrix);
                $response = [
                    'status' => 'success',
                    'result' => $bMatrix->getArray()
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
                'message' => 'An array for the matrix is expected'
            ];
        }
        return new SilexResponse($app->serialize($response), 200, self::getResponseHeaders());
    }

    ////////////////////////////////////////////////////////////////////////////
    // POLYNOMIAL PUBLIC STATIC METHODS
    ////////////////////////////////////////////////////////////////////////////

    public static function polynomialRoots(SilexRequest $request, Application $app)
    {
        $coefficients = $request->request->get('coefficients');

        try
        {
            $polynomial = new Polynomial($coefficients);
            $minRoot = $request->request->get('minRoot');
            $maxRoot = $request->request->get('maxRoot');
            $response = [
                'status'  => 'success',
                'result'  => $polynomial->getRoots($minRoot, $maxRoot)
            ];
        }
        catch (PolynomialException $e)
        {
            $response = [
                'status'  => 'error',
                'message' => $e->getMessage()
            ];
        }
        return new SilexResponse($app->serialize($response), 200, self::getResponseHeaders());
    }

    public static function polynomialFactoring(SilexRequest $request, Application $app)
    {

        $coefficients[0] = -1;
        $coefficients[1] = 6;
        $coefficients[2] = -11;
        $coefficients[3] = 6;

        // $coefficients[0] = -1;
        // $coefficients[1] = 0;
        // $coefficients[2] = 12;
        // $coefficients[3] = -16;

        // $coefficients[0] = -1;
        // $coefficients[1] = 3;
        // $coefficients[2] = -3;
        // $coefficients[3] = 1;

        try
        {
            $polynomial = new Polynomial($coefficients);
            $minRoot = $request->request->get('minRoot');
            $maxRoot = $request->request->get('maxRoot');

            $response = [
                'status'  => 'success',
                'result'  => $polynomial->getResultFactorisation($minRoot,$maxRoot)
            ];
        }
        catch (PolynomialException $e)
        {
            $response = [
                'status'  => 'error',
                'message' => $e->getMessage()
            ];
        }
        return new SilexResponse($app->serialize($response), 200, self::getResponseHeaders());



    }
    ////////////////////////////////////////////////////////////////////////////
    // PRIVATE STATIC METHODS
    ////////////////////////////////////////////////////////////////////////////

    private static function getResponseHeaders()
    {
        return ['Content-Type' => 'application/json'];
    }
}
