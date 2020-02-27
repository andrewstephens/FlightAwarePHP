<?php

namespace FlightAware\Endpoints;

class AirportBoards
{
    const API_ENDPOINT = 'AirportBoards';

    public $airport;
    public $airport_info;
    public $arrivals;
    public $departures;
    public $enroute;
    public $scheduled;

    public function __construct($data)
    {
        $this->airport          = $data['AirportBoardsResult']['airport'];
        $this->airport_info     = $data['AirportBoardsResult']['airport_info'];
        $this->arrivals         = $data['AirportBoardsResult']['arrivals'];
        $this->departures       = $data['AirportBoardsResult']['departures'];
        $this->enroute          = $data['AirportBoardsResult']['enroute'];
        $this->scheduled        = $data['AirportBoardsResult']['scheduled'];
    }

    public function raw()
    {
        return [
            'airport'       => $this->airport,
            'airport_info'  => $this->airport_info,
            'arrivals'      => $this->arrivals,
            'departures'    => $this->departures,
            'enroute'       => $this->enroute,
            'scheduled'     => $this->scheduled,
        ];
    }
}
