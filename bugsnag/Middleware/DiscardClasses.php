<?php namespace Bugsnag\Middleware;

use Bugsnag\Configuration;
use Bugsnag\Report;

class DiscardClasses
{
    private $config;

    public function __construct(Configuration $config)
    {
        $this->config = $config;
    }

    public function __invoke(Report $report, callable $next)
    {
        $errors = $report->getErrors();
        foreach ($this->config->getDiscardClasses() as $discardClass) {
            foreach ($errors as $error) {
                if ($error['errorClass'] === $discardClass || @preg_match($discardClass, $error['errorClass']) === 1) {
                    syslog(LOG_INFO, sprintf('Discarding event because error class "%s" matched discardClasses configuration', $error['errorClass']));
                    return;
                }
            }
        }
        $next($report);
    }
}