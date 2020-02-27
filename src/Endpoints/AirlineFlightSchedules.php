<?php

namespace FlightAware\Endpoints;

class AirlineFlightSchedules
{
    const API_ENDPOINT = 'AirlineFlightSchedules';

    public $flights = [];
    public $next_offset;

    public function __construct($data)
    {
        $this->flights          = $data['AirlineFlightSchedulesResult']['flights'];
        $this->next_offset      = $data['AirlineFlightSchedulesResult']['next_offset'];
    }

    public function raw()
    {
        return [
            'flights'      => $this->flights,
            'next_offset'  => $this->next_offset,
        ];
    }
}
