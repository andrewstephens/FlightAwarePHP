<?php

namespace FlightAware\Endpoints;

class LatLongsToDistance
{
    const API_ENDPOINT = 'LatLongsToDistance';

    public $distance_in_miles;

    public function __construct($data)
    {
        $this->distance_in_miles = $data['LatLongsToDistanceResult'];
    }

    public function raw()
    {
        return $this->distance_in_miles;
    }
}
