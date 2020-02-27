<?php

namespace FlightAware\Endpoints;

class AirportInfo
{
    const API_ENDPOINT = 'AirportInfo';

    public $airport_code;
    public $elevation;
    public $city;
    public $state;
    public $longitude;
    public $latitude;
    public $timezone;
    public $country_code;
    public $wiki_url;
    public $alternate_ident;

    public function __construct($data)
    {
        $this->airport_code         = $data['AirportInfoResult']['airport_code'];
        $this->name                 = $data['AirportInfoResult']['name'];
        $this->elevation            = $data['AirportInfoResult']['elevation'];
        $this->city                 = $data['AirportInfoResult']['city'];
        $this->state                = $data['AirportInfoResult']['state'];
        $this->longitude            = $data['AirportInfoResult']['longitude'];
        $this->latitude             = $data['AirportInfoResult']['latitude'];
        $this->timezone             = $data['AirportInfoResult']['timezone'];
        $this->country_code         = $data['AirportInfoResult']['country_code'];
        $this->wiki_url             = $data['AirportInfoResult']['wiki_url'];
        $this->alternate_ident      = $data['AirportInfoResult']['alternate_ident'];
    }

    public function raw()
    {
        return [
            'airport_code'      => $this->airport_code,
            'elevation'         => $this->elevation,
            'city'              => $this->city,
            'state'             => $this->state,
            'longitude'         => $this->longitude,
            'latitude'          => $this->latitude,
            'timezone'          => $this->timezone,
            'country_code'      => $this->country_code,
            'wiki_url'          => $this->wiki_url,
            'alternate_ident'   => $this->alternate_ident,
        ];
    }
}
