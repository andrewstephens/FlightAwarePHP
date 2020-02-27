<?php

namespace FlightAware\Endpoints;

class TailOwner
{
    const API_ENDPOINT = 'TailOwner';

    public $location;
    public $location2;
    public $owner;
    public $website;

    public function __construct($data)
    {
        $this->location         = $data['TailOwnerResult']['location'];
        $this->location2        = $data['TailOwnerResult']['location2'];
        $this->owner            = $data['TailOwnerResult']['owner'];
        $this->website          = $data['TailOwnerResult']['website'];
    }

    public function raw()
    {
        return [
            'location'  => $this->location,
            'location2' => $this->location2,
            'owner'     => $this->owner,
            'website'   => $this->website,
        ];
    }
}
