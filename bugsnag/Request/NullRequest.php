<?php namespace Bugsnag\Request;
class NullRequest implements RequestInterface
{
    public function isRequest()
    {
        return false;
    }

    public function getSession()
    {
        return [];
    }

    public function getCookies()
    {
        return [];
    }

    public function getMetaData()
    {
        return [];
    }

    public function getContext()
    {
        return null;
    }

    public function getUserId()
    {
        return null;
    }
}