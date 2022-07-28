<?php namespace yxorP\lib\proxy\Psr7;

use yxorP\lib\Psr\Http\Message\StreamInterface;

class DroppingStream implements StreamInterface
{
    use AStreamDecoratorTrait;

    private $maxLength;

    public function __construct(StreamInterface $stream, $maxLength)
    {
        $this->stream = $stream;
        $this->maxLength = $maxLength;
    }

    public function write($string)
    {
        $diff = $this->maxLength - $this->stream->getSize();
        if ($diff <= 0) {
            return 0;
        }
        if (strlen($string) < $diff) {
            return $this->stream->write($string);
        }
        return $this->stream->write(substr($string, 0, $diff));
    }
}
