<?php

namespace FlightAware\Endpoints;

class FleetBoards
{
    const API_ENDPOINT = 'FleetBoards';

    public $fleet;
    public $arrivals;
    public $departures;
    public $enroute;
    public $scheduled;

    public function __construct($data)
    {
        $data = json_decode($data, true);
        $this->fleet        = $data['FleetBoardsResult']['fleet'];
        $this->arrivals     = $data['FleetBoardsResult']['arrivals'];
        $this->departures   = $data['FleetBoardsResult']['departures'];
        $this->enroute      = $data['FleetBoardsResult']['enroute'];
        $this->scheduled    = $data['FleetBoardsResult']['scheduled'];
    }

    public function raw()
    {
        return [
            'fleet'         => $this->fleet,
            'arrivals'      => $this->arrivals,
            'departures'    => $this->departures,
            'enroute'       => $this->enroute,
            'scheduled'     => $this->scheduled,
        ];
    }
}
