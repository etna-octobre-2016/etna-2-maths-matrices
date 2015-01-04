<?php namespace App;

// PHP core classes
use Exception;

// Vendors classes
use Silex\Application                           as SilexApplication;
use Symfony\Component\HttpFoundation\Request    as SilexRequest;
use Symfony\Component\HttpFoundation\Response   as SilexResponse;
use Silex\Provider\SerializerServiceProvider    as SilexSerializerProvider;

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
    public function serialize($data, $format = 'json')
    {
        return $this->silexApplication['serializer']->serialize($data, $format);
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
    private function setRoutes()
    {
        $app = $this;

        $this->silexApplication->get('/', function(SilexRequest $request) use ($app) {
            return ApplicationRouter::welcome($request, $app);
        });
        $this->silexApplication->post('/add/', function(SilexRequest $request) use ($app) {
            return ApplicationRouter::add($request, $app);
        });
        $this->silexApplication->post('/multiply/', function(SilexRequest $request) use ($app) {
            return ApplicationRouter::multiply($request, $app);
        });
        $this->silexApplication->post('/multiply-real/', function(SilexRequest $request) use ($app) {
            return ApplicationRouter::multiplyByReal($request, $app);
        });
        $this->silexApplication->post('/sub/', function(SilexRequest $request) use ($app) {
            return ApplicationRouter::sub($request, $app);
        });
        $this->silexApplication->get('/welcome/', function(SilexRequest $request) use ($app) {
            return ApplicationRouter::welcome($request, $app);
        });

        // default route
        $this->silexApplication->error(function (Exception $e) use ($app) {

            $response = ['status' => 'error', 'message' => 'route not found'];
            return new SilexResponse($app->serialize($response), 200, ['Content-Type' => 'application/json']);
        });
    }
}
