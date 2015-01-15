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
        $routes = [
            'get' => [
                'welcome'       => 'ApplicationRouter::welcome'
            ],
            'post' => [
                'add'           => 'ApplicationRouter::add',
                'gauss'         => 'ApplicationRouter::gauss',
                'invert'        => 'ApplicationRouter::invert',
                'multiply'      => 'ApplicationRouter::multiply',
                'multiply-real' => 'ApplicationRouter::multiplyByReal',
                'sub'           => 'ApplicationRouter::sub',
                'trace'         => 'ApplicationRouter::trace',
                'transpose'     => 'ApplicationRouter::transpose'
            ]
        ];

        // routes initialization
        foreach ($routes as $method => &$uriList)
        {
            foreach ($uriList as $uri => $routerHandlerName)
            {
                $this->silexApplication->$method('/'.$uri.'/', function(SilexRequest $request) use ($routerHandlerName, $app) {

                    return call_user_func(__NAMESPACE__.'\\'.$routerHandlerName, $request, $app);
                });
            }
        }

        // default route
        $this->silexApplication->get('/', function(SilexRequest $request) use ($app) {

            return ApplicationRouter::welcome($request, $app);
        });

        // invalid route
        $this->silexApplication->error(function (Exception $e) use ($app) {

            $response = ['status' => 'error', 'message' => 'route not found'];
            return new SilexResponse($app->serialize($response), 200, ['Content-Type' => 'application/json']);
        });
    }
}
