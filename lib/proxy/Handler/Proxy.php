<?php namespace yxorP\lib\proxy\Handler;

use yxorP\lib\Psr\Http\Message\RequestInterface;
use yxorP\lib\proxy\RequestOptions;

class Proxy
{
    public static function wrapSync(callable $default, callable $sync)
    {
        return function (RequestInterface $request, array $options) use ($default, $sync) {
            return empty($options[RequestOptions::SYNCHRONOUS]) ? $default($request, $options) : $sync($request, $options);
        };
    }

    public static function wrapStreaming(callable $default, callable $streaming)
    {
        return function (RequestInterface $request, array $options) use ($default, $streaming) {
            return empty($options['stream']) ? $default($request, $options) : $streaming($request, $options);
        };
    }
}
