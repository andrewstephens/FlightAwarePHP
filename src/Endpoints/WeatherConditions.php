<?php

namespace FlightAware\Endpoints;

class WeatherConditions
{
    const API_ENDPOINT = 'WeatherConditions';

    public $conditions = [];
    public $next_offset;

    public function __construct($data)
    {
        $data               = json_decode($data, true);
        $this->conditions   = $data['WeatherConditionsResult']['conditions'];
        $this->next_offset  = $data['WeatherConditionsResult']['next_offset'];
    }

    public function raw()
    {
        return [
            'conditions'    => $this->conditions,
            'next_offset'   => $this->next_offset
        ];
    }
}
