<?php

namespace CyrilPerrin\Spine;

/**
 * Response
 */
class Response
{
    /**
     * Get HTTP status by code
     * @param $statusCode int HTTP status code
     * @throws \Exception if HTTP status does not exist
     * @return string HTTP status
     */
    public static function getStatusByCode($statusCode)
    {
        switch ($statusCode) {
            case 100:
                return 'Continue';
                break;
            case 101:
                return 'Switching Protocols';
                break;
            case 200:
                return 'OK';
                break;
            case 201:
                return 'Created';
                break;
            case 202:
                return 'Accepted';
                break;
            case 203:
                return 'Non-Authoritative Information';
                break;
            case 204:
                return 'No Content';
                break;
            case 205:
                return 'Reset Content';
                break;
            case 206:
                return 'Partial Content';
                break;
            case 300:
                return 'Multiple Choices';
                break;
            case 301:
                return 'Moved Permanently';
                break;
            case 302:
                return 'Moved Temporarily';
                break;
            case 303:
                return 'See Other';
                break;
            case 304:
                return 'Not Modified';
                break;
            case 305:
                return 'Use Proxy';
                break;
            case 400:
                return 'Bad Request';
                break;
            case 401:
                return 'Unauthorized';
                break;
            case 402:
                return 'Payment Required';
                break;
            case 403:
                return 'Forbidden';
                break;
            case 404:
                return 'Not Found';
                break;
            case 405:
                return 'Method Not Allowed';
                break;
            case 406:
                return 'Not Acceptable';
                break;
            case 407:
                return 'Proxy Authentication Required';
                break;
            case 408:
                return 'Request Time-out';
                break;
            case 409:
                return 'Conflict';
                break;
            case 410:
                return 'Gone';
                break;
            case 411:
                return 'Length Required';
                break;
            case 412:
                return 'Precondition Failed';
                break;
            case 413:
                return 'Request Entity Too Large';
                break;
            case 414:
                return 'Request-URI Too Large';
                break;
            case 415:
                return 'Unsupported Media Type';
                break;
            case 500:
                return 'Internal Server Error';
                break;
            case 501:
                return 'Not Implemented';
                break;
            case 502:
                return 'Bad Gateway';
                break;
            case 503:
                return 'Service Unavailable';
                break;
            case 504:
                return 'Gateway Time-out';
                break;
            case 505:
                return 'HTTP Version not supported';
                break;
            default:
                throw new \Exception(
                    'Unknown HTTP status code "'.$this->_statusCode.'"'
                );
        }
    }
    
    /** @var $_statusCode int HTTP status code */
    private $_statusCode;
    
    /** @var $_headers array HTTP headers */
    private $_headers = array();
    
    /** @var $_content string content */
    private $_content = null;
    
    /** @var $_exception \Exception exception */
    private $_exception = null;
    
    /**
     * Constructor
     * @param $statusCode int HTTP status code
     * @param $content string content
     * @param $exception \Exception exception
     */
    public function __construct($statusCode=200,$content='',$exception=null)
    {
        $this->_statusCode = $statusCode;
        $this->_content = $content;
        $this->_exception = $exception;
    }
    
    /**
     * Get HTTP status code
     * @return int HTTP status code
     */
    public function getStatusCode()
    {
        return $this->_statusCode;
    }
    
    /**
     * Set HTTP status code
     * @param $statusCode int HTTP status code
     */
    public function setStatusCode($statusCode)
    {
        $this->_statusCode = $statusCode;
    }
    
    /**
     * Get HTTP header
     * @param $headerName string $header name
     * @return string header value
     */
    public function getHeader($headerName)
    {
        if (isset($this->_headers[$headerName])) {
            return $this->_headers[$headerName];
        }
        return null;
    }
    
    /**
     * Get HTTP headers
     * @return array HTTP headers
     */
    public function getHeaders()
    {
        return $this->_headers;
    }
    
    /**
     * Set HTTP header
     * @param $headerName string header name
     * @param $headerValue string header value
     */
    public function setHeader($headerName,$headerValue) 
    {
        $this->_headers[$headerName] = $headerValue;
    }
    
    /**
     * Clear HTTP headers
     */
    public function clearHeaders()
    {
        $this->_headers = array();
    }
    
    /**
     * Get content
     * @return string content
     */
    public function getContent()
    {
        return $this->_content;
    }
    
    /**
     * Set content
     * @param $content string content
     */
    public function setContent($content)
    {
        $this->_content = $content;
    }
    
    /**
     * Get exception
     * @return \Exception exception
     */
    public function getException()
    {
        return $this->_exception;
    }
    
    /**
     * Set exception
     * @param $exception \Exception exception
     */
    public function setException($exception)
    {
        $this->_exception = $exception;
    }
    
    /**
     * Send
     */
    public function send()
    {
        // Get HTTP status
        $status = self::getStatusByCode($this->_statusCode);
        
        // Get HTTP protocol
        if (isset($_SERVER['SERVER_PROTOCOL'])) {
            $protocol = $_SERVER['SERVER_PROTOCOL'];
        } else {
            $protocol = 'HTTP/1.0';
        }
        
        // Send HTTP headers
        header($protocol.' '.$this->_statusCode.' '.$status);
        foreach ($this->_headers as $headerName => $headerValue) {
            header($headerName.': '.$headerValue);
        }
        
        // Send content
        echo $this->_content;
    }
    
}