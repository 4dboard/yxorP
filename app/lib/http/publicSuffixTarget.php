<?php namespace yxorP\app\lib\http;

use yxorP\app\yP;

class publicSuffixTarget
{

    public function registrableDomain(): registrableDomain
    {
        return yP::store(ENV_DEFAULT_HOST);
    }

}

