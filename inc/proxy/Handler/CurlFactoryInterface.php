<?php

namespace yxorP\inc\proxy\Handler;

use RuntimeException;
use yxorP\inc\psr\Http\Message\RequestInterface;

interface CurlFactoryInterface
{
    /**
     * Creates a cURL handle resource.
     *
     * @param RequestInterface $request Request
     * @param array $options Transfer options
     *
     * @return EasyHandle
     * @throws RuntimeException when an option cannot be applied
     */
    public function create(RequestInterface $request, array $options): EasyHandle;

    /**
     * Release an easy handle, allowing it to be reused or closed.
     *
     * This function must call unset on the easy handle's "handle" property.
     *
     * @param EasyHandle $easy
     */
    public function release(EasyHandle $easy);
}
