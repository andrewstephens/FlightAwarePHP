<?php

namespace FlightAware\Endpoints;

class GetFlightTrack
{
    const API_ENDPOINT = 'GetFlightTrack';

    public $tracks = [];

    public function __construct($data)
    {
        $this->tracks = $data['GetFlightTrackResult']['tracks'];
    }

    public function raw()
    {
        return [
            'tracks' => $this->tracks,
        ];
    }
}
