<?php namespace App;

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
    private function serialize($data, $format)
    {
        return $this->silexApplication['serializer']->serialize($data, $format);
    }
    private function setRoutes()
    {
        $this->silexApplication->get('/', function(){
            return new SilexResponse('Welcome to the Matrix API', 200);
        });
    }
}
