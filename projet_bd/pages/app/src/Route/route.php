<?php
namespace app\src\Route;
class Route
{
    /**
     * @var string
     */
    private $method;
    /**
     * @var string
     */
    private $pattern;
    /**
     * @var callable
     */
    private $callable;
    /**
     * @var array
     */
    private $arguments;
    /**
     * Root constructor.
     * @param string $method
     * @param string $pattern
     * @param callable $callable
     */
    public function __construct(string $method, string $pattern, callable $callable)
    {
        $this->method = $method;
        $this->pattern = $pattern;
        $this->callable = $callable;
        $this->arguments = array();
    }
    public function match(string $method, string $uri)
    {
        if ($this->method !== $method)
        {
            return false;
        }
        if (preg_match($this->compilePattern(), $uri, $this->arguments))
        {
            array_shift($this->arguments);
            return true;
        }
        return false;
    }
    private function compilePattern()
    {
        return sprintf('#^%s$#', $this->pattern);
    }
    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }
    /**
     * @return string
     */
    public function getPattern()
    {
        return $this->pattern;
    }
    /**
     * @return callable
     */
    public function getCallable()
    {
        return $this->callable;
    }
    /**
     * @return array
     */
    public function getArguments()
    {
        return $this->arguments;
    }
}