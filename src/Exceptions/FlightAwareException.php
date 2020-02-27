<?php

namespace FlightAware\Exceptions;

class FlightAwareException extends \Exception
{
    protected $error;
    protected $endpoint;

    public function __construct($endpoint, $message)
    {
        $this->endpoint = $endpoint;
        $this->error = $message;
        parent::__construct();
    }

    public function __toString()
    {
       return sprintf("Error with endpoint: %s. Message: %s", $this->endpoint, $this->error);
    }
}
