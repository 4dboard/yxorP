<?php namespace yxorP\lib\proxy\Exception;

use Exception;
use yxorP\inc\Psr\Http\Message\RequestInterface;
use yxorP\inc\Psr\Http\Message\ResponseInterface;

class BadResponseException extends ARequestExceptionAA
{
    public function __construct($message, RequestInterface $request, ResponseInterface $response = null, Exception $previous = null, array $handlerContext = [])
    {
        if (null === $response) {
            @trigger_error('Instantiating the ' . __CLASS__ . ' class without a Response is deprecated since version 6.3 and will be removed in 7.0.', E_USER_DEPRECATED);
        }
        parent::__construct($message, $request, $response, $previous, $handlerContext);
    }
}