<?php

namespace FlightAware\Endpoints;

class DecodeFlightRoute
{
    const API_ENDPOINT = 'DecodeFlightRoute';

    public $route_distance;
    public $route;

    public function __construct($data)
    {
        $this->route = $data['DecodeFlightRouteResult']['route_distance'];
        $this->route = $data['DecodeFlightRouteResult']['data'];
    }

    public function raw()
    {
        return [
            'route_distance'    => $this->route_distance,
            'route'             => $this->route
        ];
    }
}
