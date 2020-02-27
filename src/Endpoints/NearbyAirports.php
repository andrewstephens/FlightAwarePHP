<?php

namespace FlightAware\Endpoints;

class NearbyAirports
{
    const API_ENDPOINT = 'NearbyAirports';

    public $airports = [];
    public $next_offset;

    public function __construct($data)
    {
        $this->airports     = $data['NearbyAirportsResult']['airports'];
        $this->next_offset  = $data['NearbyAirportsResult']['next_offset'];
    }

    public function raw()
    {
        return [
            'airports'      => $this->airports,
            'next_offset'   => $this->next_offset
        ];
    }
}
