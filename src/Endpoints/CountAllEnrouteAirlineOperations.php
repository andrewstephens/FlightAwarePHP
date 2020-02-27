<?php

namespace FlightAware\Endpoints;

class CountAllEnrouteAirlineOperations
{
    const API_ENDPOINT = 'CountAllEnrouteAirlineOperations';

    public $airline_operation_data;

    public function __construct($data)
    {
        $data = json_decode($data, true);
        $airline_list = $data['CountAllEnrouteAirlineOperationsResult']['data'];
        $airline_operations = [];
        foreach ($airline_list as $airline) {
            $airline_operations[$airline['icao']] = $airline;
        }

        $this->airline_operation_data = $airline_operations;
    }

    public function raw()
    {
        return $this->airline_operation_data;
    }
}
