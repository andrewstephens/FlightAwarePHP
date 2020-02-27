<?php

namespace FlightAware\Endpoints;

class RoutesBetweenAirports
{
    const API_ENDPOINT = 'RoutesBetweenAirports';

    public $airports = [];
    public $next_offset;

    public function __construct($data)
    {
        $data               = json_decode($data, true);
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
