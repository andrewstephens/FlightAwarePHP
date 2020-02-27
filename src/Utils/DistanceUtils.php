<?php

namespace FlightAware\Utils;

class DistanceUtils
{
    public static function milesToKilometers(float $miles): float
    {
        return $miles * 1.60934;
    }

    public static function kilometersToMiles(float $kilometers): float
    {
        return $kilometers * 0.621371;
    }
}
