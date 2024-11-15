<?php

namespace App\Exceptions;

use InvalidArgumentException;

class InvalidExternalServiceException extends InvalidArgumentException
{
    /**
     * @param $message
     * @param $code
     */
    public function __construct($message = "Invalid external service!", $code = 422)
    {
        parent::__construct($message, $code);
    }
}
