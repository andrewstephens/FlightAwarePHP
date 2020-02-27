<?php

namespace FlightAware\Endpoints;

class RoutesBetweenAirports
{
    const API_ENDPOINT = 'RoutesBetweenAirports';

    public $routes = [];
    public $next_offset;

    public function __construct($data)
    {
        $data               = json_decode($data, true);
        $this->routes       = $data['RoutesBetweenAirportsResult']['data'];
        $this->next_offset  = $data['RoutesBetweenAirportsResult']['next_offset'];
    }

    public function raw()
    {
        return [
            'routes'        => $this->routes,
            'next_offset'   => $this->next_offset
        ];
    }
}
