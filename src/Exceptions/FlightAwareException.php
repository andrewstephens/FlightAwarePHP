<?php

namespace FlightAware\Exceptions;

use Throwable;

class RequestException extends \Exception
{
    public static function create(string $endpoint, string $response): RequestException
    {
        $message = '';
        return new static($message);
    }
}
