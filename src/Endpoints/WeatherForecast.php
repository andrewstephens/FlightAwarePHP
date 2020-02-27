<?php

namespace FlightAware\Endpoints;

class WeatherForecast
{
    const API_ENDPOINT = 'WeatherForecast';

    public $airport_code;
    public $timestring;
    public $raw_forecast = [];
    public $decoded_forecast = [];

    public function __construct($data)
    {
        $data                   = json_decode($data, true);
        $this->airport_code     = $data['WeatherForecastResult']['airport_code'];;
        $this->timestring       = $data['WeatherForecastResult']['timestring'];;
        $this->raw_forecast     = $data['WeatherForecastResult']['raw_forecast'];;
        $this->decoded_forecast = $data['WeatherForecastResult']['decoded_forecast'];;
    }

    public function raw()
    {
        return [
            'airport_code'      => $this->airport_code,
            'timestring'        => $this->timestring,
            'raw_forecast'      => $this->raw_forecast,
            'decoded_forecast'  => $this->decoded_forecast,
        ];
    }
}
