<?php namespace Bugsnag\Shutdown;

use Bugsnag\Client;

interface ShutdownStrategyInterface
{
    public function registerShutdownStrategy(Client $client);
}