<?php

namespace Neychang\Microapp\Http\Exception;

use Exception;

class MethodNotAllowedException extends Exception
{
    public function __construct($message = null, $code = 405, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
