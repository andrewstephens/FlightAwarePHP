<?php

namespace FlightAware\Endpoints;

class FindFlight
{
    const API_ENDPOINT = 'FindFlight';

    public $number_of_flights;
    public $next_offset;
    public $flights = [];

    public function __construct($data)
    {
        $data = json_decode($data, true);
        $flight_data = $data['FindFlightResult'];
        $this->number_of_flights = $flight_data['num_flights'];
        $this->next_offset = $flight_data['next_offset'];
        $this->flights = $flight_data['flights'];
    }

    public function raw()
    {
       return [
           'number_of_flights' => $this->number_of_flights,
           'flights' => $this->flights,
           'next_offset' => $this->next_offset
       ];
    }
}
