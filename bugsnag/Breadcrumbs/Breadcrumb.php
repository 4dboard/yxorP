<?php namespace Bugsnag\Breadcrumbs;

use Bugsnag\DateTime\Date;
use InvalidArgumentException;

class Breadcrumb
{
    const NAVIGATION_TYPE = 'navigation';
    const REQUEST_TYPE = 'request';
    const PROCESS_TYPE = 'process';
    const LOG_TYPE = 'log';
    const USER_TYPE = 'user';
    const STATE_TYPE = 'state';
    const ERROR_TYPE = 'error';
    const MANUAL_TYPE = 'manual';
    const MAX_SIZE = 4096;
    protected $timestamp;
    protected $name;
    protected $type;
    protected $metaData;

    public function __construct($name, $type, array $metaData = [])
    {
        if (!is_string($name)) {
            if (is_null($name)) {
                $metaData['BreadcrumbError'] = 'NULL provided as the breadcrumb name';
                $name = '<no name>';
            } else {
                $metaData['BreadcrumbError'] = 'Breadcrumb name must be a string - ' . gettype($name) . ' provided instead';
                $name = '<no name>';
            }
        } elseif ($name === '') {
            $metaData['BreadcrumbError'] = 'Empty string provided as the breadcrumb name';
            $name = '<no name>';
        }
        $types = static::getTypes();
        if (!in_array($type, $types, true)) {
            throw new InvalidArgumentException(sprintf('The breadcrumb type must be one of the set of %d standard types.', count($types)));
        }
        $this->timestamp = Date::now();
        $this->name = $name;
        $this->type = $type;
        $this->metaData = $metaData;
    }

    public static function getTypes()
    {
        return [static::NAVIGATION_TYPE, static::REQUEST_TYPE, static::PROCESS_TYPE, static::LOG_TYPE, static::USER_TYPE, static::STATE_TYPE, static::ERROR_TYPE, static::MANUAL_TYPE,];
    }

    public function toArray()
    {
        return ['timestamp' => $this->timestamp, 'name' => $this->name, 'type' => $this->type,];
    }

    public function getMetaData()
    {
        return $this->metaData;
    }
}