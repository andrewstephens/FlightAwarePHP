<?php

namespace FlightAware\Endpoints;

class AirlineInfo
{
    const API_ENDPOINT = 'AirlineInfo';

    public $name;
    public $shortname;
    public $callsign;
    public $location;
    public $country;
    public $phone;
    public $url;
    public $wiki_url;
    public $airbourne;
    public $flights_last_24_hours;

    public function __construct($data)
    {
        $data = json_decode($data, true);
        $this->name                     = $data['AirlineInfoResult']['name'];
        $this->shortname                = $data['AirlineInfoResult']['shortname'];
        $this->callsign                 = $data['AirlineInfoResult']['callsign'];
        $this->location                 = $data['AirlineInfoResult']['location'];
        $this->country                  = $data['AirlineInfoResult']['country'];
        $this->phone                    = $data['AirlineInfoResult']['phone'];
        $this->url                      = $data['AirlineInfoResult']['url'];
        $this->wiki_url                 = $data['AirlineInfoResult']['wiki_url'];
        $this->airbourne                = $data['AirlineInfoResult']['airbourne'];
        $this->flights_last_24_hours    = $data['AirlineInfoResult']['flights_last_24_hours'];
    }

    public function raw()
    {
        return [
            'name'                      => $this->name,
            'shortname'                 => $this->shortname,
            'callsign'                  => $this->callsign,
            'location'                  => $this->location,
            'country'                   => $this->country,
            'phone'                     => $this->phone,
            'url'                       => $this->url,
            'wiki_url'                  => $this->wiki_url,
            'airbourne'                 => $this->airbourne,
            'flights_last_24_hours'     => $this->flights_last_24_hours
        ];
    }
}
