<?php
namespace app\src\Request;
class Request
{
    const GET = 'GET';
    const POST = 'POST';
    const PUT = 'PUT';
    const DELETE = 'DELETE';
    /**
     * @var array
     */
    private $parameters;
    /**
     * Request constructor.
     *
     * @param array $query Query string from the request
     * @param array $request Request body from the request (Post method)
     */
    public function __construct(array $query = [], array $request = [])
    {
        $this->parameters = array_merge($query, $request);
    }
    /**
     * Create an instance from global variable
     * This method needs to stay static and have the name create from globals
     * @return Request
     */
    public static function createFromGlobals() {
        return new self($_GET, $_POST);
    }
    /**
     * Return parameters name from get or post arguments
     *
     * @param String $name Name of the parameters
     * @return mixed
     */
    public function getParameters(String $name) {
        return $this->parameters[$name];
    }
    /**
     * Return the request method used
     * if no method available return get by default
     *
     * @return string
     */
    public function getMethod() {
        return $_SERVER['REQUEST_METHOD'] ?? self::GET;
    }
    /**
     * return the request URI
     * Also takes care of removing the query string to not interfeer with our routing system
     *
     *
     * @return string
     *
     */
    public function getUri() {
        $uri = substr($_SERVER['REQUEST_URI'], 16) ?? '/';
        if($pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        return $uri;
    }
}