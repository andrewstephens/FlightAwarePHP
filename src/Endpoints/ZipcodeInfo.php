<?php

namespace FlightAware\Endpoints;

class ZipcodeInfo
{
    const API_ENDPOINT = 'ZipcodeInfo';

    public $city;
    public $county;
    public $latitude;
    public $longitude;
    public $state;

    public function __construct($data)
    {
        $data               = json_decode($data, true);
        $this->city         = $data['ZipcodeInfoResult']['city'];
        $this->county       = $data['ZipcodeInfoResult']['county'];
        $this->latitude     = $data['ZipcodeInfoResult']['latitude'];
        $this->longitude    = $data['ZipcodeInfoResult']['longitude'];
        $this->state        = $data['ZipcodeInfoResult']['state'];
    }

    public function raw()
    {
        return [
            'city'      => $this->city,
            'county'    => $this->county,
            'latitude'  => $this->latitude,
            'longitude' => $this->longitude,
            'state'     => $this->state,
        ];
    }
}
