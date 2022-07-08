<?php namespace Bugsnag\Callbacks;

use Bugsnag\Report;

class EnvironmentData
{
    public function __invoke(Report $report)
    {
        if (!empty($_ENV)) {
            $report->setMetaData(['Environment' => $_ENV]);
        }
    }
}