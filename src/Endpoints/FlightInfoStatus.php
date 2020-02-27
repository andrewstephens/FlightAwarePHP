<?php

namespace FlightAware\Endpoints;

class FlightInfoStatus
{
    const API_ENDPOINT = 'FlightInfoStatus';

    public $flights;
    public $next_offset;

    public function __construct($data)
    {
        $data = json_decode($data, true);
        $this->flights = $data['FlightInfoStatusResult']['flights'];
        $this->next_offset = $data['FlightInfoStatusResult']['next_offset'];
    }

    public function raw()
    {
        return [
            'flights' => $this->flights,
            'next_offset' => $this->next_offset,
        ];
    }
}
