<?php
/* Importing the wrapper class from the yxorP\http namespace. */

use yxorP\http\wrapper;
use yxorP\inc\constants;
use yxorP\inc\generalHelper;

/* Extending the wrapper class. */

class checkFilesAction extends wrapper
{
    public function buildIncludes()
    {
        /* Checking the files in the directory `DIR_FULL` and it is not recursive. */
        generalHelper::fileCheck(constants::get('DIR_FULL'), false);
        /* Checking the files in the directory `DIR_ROOT . 'override' . DIRECTORY_SEPARATOR . 'global'` and it is not
        recursive. */
        generalHelper::fileCheck(DIR_ROOT . 'override' . DIRECTORY_SEPARATOR . 'global', false);
    }
}