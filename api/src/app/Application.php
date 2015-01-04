<?php namespace App;

use Exception;
use Matrix\Matrix;
use Matrix\MatrixCalculator;
use Matrix\MatrixException;
use Silex\Application                           as SilexApplication;
use Silex\Provider\SerializerServiceProvider    as SilexSerializerProvider;
use Symfony\Component\HttpFoundation\Request    as SilexRequest;
use Symfony\Component\HttpFoundation\Response   as SilexResponse;

class Application
{
    private $silexApplication;

    // CONSTRUCTOR
    ////////////////////////////////////////////////////////////////////////////////////////

    function __construct()
    {
        $this->initSilexApplication();
        $this->setRoutes();
        $this->parseData();
        $this->removeRequestUriSlash();
    }

    // PUBLIC METHODS
    ////////////////////////////////////////////////////////////////////////////////////////

    public function run()
    {
        $this->silexApplication->run();
    }

    // PRIVATE METHODS
    ////////////////////////////////////////////////////////////////////////////////////////

    private function initSilexApplication()
    {
        $app = new SilexApplication();

        // Serialization
        $app->register(new SilexSerializerProvider());

        $this->silexApplication = $app;
    }
    private function parseData()
    {
        $this->silexApplication->before(function(SilexRequest $request){

            if (0 === strpos($request->headers->get('Content-Type'), 'application/json'))
            {
                $data = json_decode($request->getContent(), true);
                $request->request->replace(is_array($data) ? $data : array());
            }
        });
    }
    private function removeRequestUriSlash()
    {
        $_SERVER['REQUEST_URI'] = rtrim($_SERVER['REQUEST_URI'], '/') . '/';
    }
    private function serialize($data, $format = 'json')
    {
        return $this->silexApplication['serializer']->serialize($data, $format);
    }
    private function setRoutes()
    {
        $app = $this;
        $responseHeaders = ['Content-Type' => 'application/json'];

        $this->silexApplication->get('/', function(SilexRequest $request) {
            return new SilexResponse('Welcome to the Matrssdix API', 200);
        });

        $this->silexApplication->post('/add/', function(SilexRequest $request) use ($app, $responseHeaders) {

            $aMatrixArray = $request->request->get('A_matrix');
            $bMatrixArray = $request->request->get('B_matrix');

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
            return new SilexResponse($app->serialize($response), 200, $responseHeaders);
        });

        // default route
        $this->silexApplication->error(function (Exception $e) use ($app, $responseHeaders) {

            $response = [
                'status'  => 'error',
                'message' => 'route not found'
            ];
            return new SilexResponse($app->serialize($response), 200, $responseHeaders);
        });
    }
}
