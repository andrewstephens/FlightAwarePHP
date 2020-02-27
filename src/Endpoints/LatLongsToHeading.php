<?php

namespace FlightAware\Endpoints;

class LatLongsToHeading
{
    const API_ENDPOINT = 'LatLongsToHeading';

    public $heading;

    public function __construct($data)
    {
        $data = json_decode($data, true);
        $this->heading = $data['LatLongsToHeadingResult'];
    }

    public function raw()
    {
        return $this->heading;
    }
}
