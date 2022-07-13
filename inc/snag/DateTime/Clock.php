<?php

namespace yxorP\inc\snag\DateTime;

use DateTimeImmutable;

final class Clock implements ClockInterface
{
    /**
     * @return DateTimeImmutable
     */
    public function now(): DateTimeImmutable
    {
        return new DateTimeImmutable();
    }
}
