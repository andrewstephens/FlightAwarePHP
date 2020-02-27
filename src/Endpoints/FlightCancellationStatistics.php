<?php

namespace FlightAware\Endpoints;

class FlightCancellationStatistics
{
    const API_ENDPOINT = 'FlightCancellationStatistics';

    public $total_cancellations_worldwide;
    public $total_cancellations_national;
    public $total_delays_worldwide;
    public $next_offset;
    public $type_matching;
    public $matching = [];

    public function __construct($data)
    {
        $data = json_decode($data, true);
        $this->total_cancellations_worldwide    = $data['FlightCancellationStatisticsResult']['total_cancellations_worldwide'];
        $this->total_cancellations_national     = $data['FlightCancellationStatisticsResult']['total_cancellations_national'];
        $this->total_delays_worldwide           = $data['FlightCancellationStatisticsResult']['total_delays_worldwide'];
        $this->type_matching                    = $data['FlightCancellationStatisticsResult']['type_matching'];
        $this->matching                         = $data['FlightCancellationStatisticsResult']['matching'];
        $this->next_offset                      = $data['FlightCancellationStatisticsResult']['next_offset'];
    }

    public function raw()
    {
        return [
            'total_cancellations_worldwide' => $this->total_cancellations_worldwide,
            'total_cancellations_national' => $this->total_cancellations_national,
            'total_delays_worldwide' => $this->total_delays_worldwide,
            'type_matching' => $this->type_matching,
            'matching' => $this->matching,
            'next_offset' => $this->next_offset,
        ];
    }
}
