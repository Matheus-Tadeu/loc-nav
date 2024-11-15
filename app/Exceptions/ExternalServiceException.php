<?php

namespace App\Exceptions;

use Exception;

class ExternalServiceException extends Exception
{
    /**
     * @param string $message
     * @param int $code
     */
    public function __construct(string $message = "Invalid external service!", int $code = 422)
    {
        parent::__construct($message, $code);
    }
}
