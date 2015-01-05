<?php

namespace Filters;

use CyrilPerrin\Spine\Filter;
use CyrilPerrin\Spine\Request;
use CyrilPerrin\Spine\Response;

/**
 * Password protector filter
 */
class PasswordProtector extends Filter
{
    /**
     * @see \CyrilPerrin\Spine\Filter::filterRequest()
     */
    public function filterRequest(Request $request)
    {
        return $request;
    }
    
    /**
     * @see \CyrilPerrin\Spine\Filter::filterResponse()
     */
    public function filterResponse(Response $response)
    {
        $content = $response->getContent();
        $content = preg_replace('/Password is : .+$/', 'Password is : ******', $content);
        $response->setContent($content);
        return $response;
    }
}