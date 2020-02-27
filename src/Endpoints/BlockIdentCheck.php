<?php

namespace FlightAware\Endpoints;

class BlockIdentCheck
{
    const API_ENDPOINT = 'BlockIdentCheck';

    public $blocked;

    public function __construct($data)
    {
        $this->blocked = $data['BlockIdentCheckResult'];
    }

    public function raw()
    {
        return [
            'blocked' => (bool) $this->blocked,
        ];
    }
}
