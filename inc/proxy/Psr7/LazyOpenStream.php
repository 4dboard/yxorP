<?php

namespace yxorP\inc\proxy\Psr7;

use yxorP\inc\psr\Http\Message\StreamInterface;

/**
 * Lazily reads or writes to a file that is opened only after an IO operation
 * take place on the stream.
 */
class LazyOpenStream implements StreamInterface
{
    use AAAStreamDecoratorTrait;

    /** @var string File to open */
    private string $filename;

    /** @var string $mode */
    private string $mode;

    /**
     * @param string $filename File to lazily open
     * @param string $mode fopen mode to use when opening the stream
     */
    public function __construct($filename, string $mode)
    {
        $this->filename = $filename;
        $this->mode = $mode;
    }

    /**
     * Creates the underlying stream lazily when required.
     *
     * @return StreamInterface
     */
    protected function createStream(): StreamInterface
    {
        return stream_for(try_fopen($this->filename, $this->mode));
    }
}
