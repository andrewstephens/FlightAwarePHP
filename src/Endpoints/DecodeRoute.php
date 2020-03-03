<?php

namespace FlightAware\Endpoints;

class DecodeRoute
{
    const API_ENDPOINT = 'DecodeRoute';

    public $route_distance;
    public $route;

    public function __construct($data)
    {
        $this->route_distance = $data['DecodeRouteResult']['route_distance'];
        $this->route = $data['DecodeRouteResult']['data'];
    }

    public function raw()
    {
        return [
            'route_distance'    => $this->route_distance,
            'route'             => $this->route
        ];
    }
}
