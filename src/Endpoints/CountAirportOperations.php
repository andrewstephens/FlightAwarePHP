<?php

namespace FlightAware\Endpoints;

class CountAirportOperations
{
    const API_ENDPOINT = 'CountAirportOperations';

    public $departed;
    public $enroute;
    public $scheduled_arrivals;
    public $scheduled_departures;

    public function __construct($data)
    {
        $data = json_decode($data, true);
        $this->departed                  = $data['CountAirportOperationsResult']['departed'];
        $this->enroute                   = $data['CountAirportOperationsResult']['enroute'];
        $this->scheduled_departures      = $data['CountAirportOperationsResult']['scheduled_departures'];
        $this->scheduled_arrivals        = $data['CountAirportOperationsResult']['scheduled_arrivals'];
    }

    public function raw()
    {
        return [
            'departed'              => $this->departed,
            'enroute'               => $this->enroute,
            'scheduled_arrivals'    => $this->scheduled_arrivals,
            'scheduled_departures'  => $this->scheduled_departures
        ];
    }
}
