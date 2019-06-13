<?php
namespace app\src;
use app\src\Response\Response;
use app\src\route\Route;
use app\src\ServiceContainer\ServiceContainer;
use app\src\Request\Request;
class App
{
    /**
     * @var array
     */
    private $routes = array();
    /**
     * @var $ServiceContainer
     */
    private $serviceContainer;
    public function __construct(ServiceContainer $serviceContainer)
    {
        $this->serviceContainer = $serviceContainer;
    }
    /**
     * Retrieve a service from the service container
     *
     * @param string $serviceName Name of the service to retrieve
     *
     * @return mixed
     */
    public function getService(string $serviceName){
        return $this->serviceContainer->get($serviceName);
    }
    /**
     * Set a service from the service container
     *
     * @param string $serviceName Name of the service to set
     * @param mixed $assigned Value of the service to set
     */
    public function setService(string $serviceName, $assigned){
        $this->serviceContainer->set($serviceName, $assigned);
    }
    /**
     * Creates a route for HTTP verb GET
     *
     * @param string $pattern
     * @param callable $callable
     * @return App $this
     */
    public function get(string $pattern, callable $callable)
    {
        $this->registerRoute(Request::GET, $pattern, $callable);
        return $this;
    }
    /**
     * Creates a route for HTTP verb POST
     *
     * @param string $pattern
     * @param callable $callable
     * @return App $this
     */
    public function post(string $pattern, callable $callable)
    {
        $this->registerRoute(Request::POST, $pattern, $callable);
        return $this;
    }
    /**
     * Creates a route for HTTP verb PUT
     *
     * @param string $pattern
     * @param callable $callable
     * @return App $this
     */
    public function put (string $pattern, callable $callable)
    {
        $this->registerRoute(Request::PUT, $pattern, $callable);
        return $this;
    }
    /**
     * Creates a route for HTTP verb DELETE
     *
     * @param string $pattern
     * @param callable $callable
     * @return App $this
     */
    public function delete (string $pattern, callable $callable)
    {
        $this->registerRoute(Request::DELETE, $pattern, $callable);
        return $this;
    }
    /**
     * Launch the php app
     *
     * @param Request|null $request
     */
    public function run(Request $request = null)
    {
        if($request == null) {
            $request = Request::createFromGlobals();
        }
        $method = $request->getMethod();
        $uri = $request->getUri();
        foreach ($this->routes as $route)
        {
            if ($route->match($method, $uri ))
            {
                return $this->process($route, $request);
            }
        }
        throw new \Error('No routes available for this uri');
    }
    /**
     * @param Route $route
     * @param Request $request
     */
    private function process(Route $route, Request $request)
    {
        try {
            $arguments = $route->getArguments();
            array_unshift($arguments, $request);
            $content = call_user_func_array($route->getCallable(), $arguments);
            if ($content instanceof Response) {
                $content->send();
                return;
            }
            $response = new Response($content, $this->statusCode ?? 200);
            $response->send();
        } catch (\HttpException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new \Error('There was an error during the processing of your request');
        }
        /*catch (\Exception $e) {
            throw $e;
        }*/
    }
    /**
     * Register a route in the routes array
     *
     * @param string $method
     * @param string $pattern
     * @param callable $callable
     */
    private function registerRoute(string $method, string $pattern, callable $callable)
    {
        $this->routes[] = new Route($method, $pattern, $callable);
    }
}