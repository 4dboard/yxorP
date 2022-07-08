<?php namespace Bugsnag\DateTime;

use DateTimeImmutable;

final class Clock implements ClockInterface
{
    public function now()
    {
        return new DateTimeImmutable();
    }
}