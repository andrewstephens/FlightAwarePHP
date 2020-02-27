<?php

namespace FlightAware\Endpoints;

class DecodeRoute
{
    const API_ENDPOINT = 'DecodeRoute';

    public $airline_operation_data;

    public function __construct($data)
    {
        $data = json_decode($data, true);
        print_r($data);
        die();
        $airline_list = $data['CountAllEnrouteAirlineOperationsResult']['data'];
    }

    public function raw()
    {
        return $this->airline_operation_data;
    }
}
