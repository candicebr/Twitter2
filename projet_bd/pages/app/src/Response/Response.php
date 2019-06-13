<?php
namespace app\src\Response;
class Response
{
    /**
     * @var string
     */
    private $content;
    /**
     * @var int
     */
    private $statusCode;
    /**
     * @var array
     */
    private $headers;
    /**
     * Response constructor.
     * @param string $content
     * @param int $statusCode
     * @param array $headers
     */
    public function __construct($content, $statusCode = 200, $headers = [])
    {
        $this->content = $content;
        $this->statusCode = $statusCode;
        $this->headers = array_merge(['Content-Type' => 'text/html'], $headers); //In the content of a website, we will always send 'text/html' headers (because we send html files)
    }
    /**
     * Get status code of the response
     * @return int
     */
    public function getStatusCode(){
        return $this->statusCode;
    }
    /**
     * Get content of the response
     * @return string
     */
    public function getContent() {
        return $this->content;
    }
    /**
     * Send headers to the browser
     * Always send headers before content, if you do not do this, you risk the browser to not understand what you are sending
     */
    public function sendHeaders(){
        http_response_code($this->statusCode);
        foreach ($this->headers as $name => $value) {
            header(sprintf('%s: %s', $name, $value));
        }
    }
    /**
     * Send the content of the response to the browser
     */
    public function send(){
        $this->sendHeaders(); //insure headers are sent before sending content
        echo $this->content;
    }
}