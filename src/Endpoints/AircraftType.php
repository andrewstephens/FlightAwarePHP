<?php

namespace FlightAware\Endpoints;

class AircraftType
{
    const API_ENDPOINT = 'AircraftType';

    public $description;
    public $engine_count;
    public $engine_type;
    public $manufacturer;
    public $type;

    public function __construct($data)
    {
        $data = json_decode($data, true);
        $this->description  = $data['AircraftTypeResult']['description'];
        $this->type         = $data['AircraftTypeResult']['type'];
        $this->engine_count = $data['AircraftTypeResult']['engine_count'];
        $this->engine_type  = $data['AircraftTypeResult']['engine_type'];
        $this->manufacturer = $data['AircraftTypeResult']['manufacturer'];
    }

    public function raw()
    {
        return [
            'description'   => $this->description,
            'type'          => $this->type,
            'engine_count'  => $this->engine_count,
            'engine_type'   => $this->engine_type,
            'manufacturer'  => $this->manufacturer
        ];
    }
}
