<?php

namespace FlightAware;

use FlightAware\Endpoints\AircraftType;
use FlightAware\Endpoints\AirlineFlightSchedules;
use FlightAware\Endpoints\AirlineInfo;
use FlightAware\Endpoints\AirportBoards;
use FlightAware\Endpoints\AirportInfo;
use FlightAware\Endpoints\BlockIdentCheck;
use FlightAware\Endpoints\CountAirportOperations;
use FlightAware\Endpoints\CountAllEnrouteAirlineOperations;
use FlightAware\Endpoints\DecodeFlightRoute;
use FlightAware\Endpoints\DecodeRoute;
use FlightAware\Endpoints\FindFlight;
use FlightAware\Endpoints\FleetBoards;
use FlightAware\Endpoints\FlightCancellationStatistics;
use FlightAware\Endpoints\FlightInfoStatus;
use FlightAware\Endpoints\GetFlightTrack;
use FlightAware\Endpoints\LatLongsToDistance;
use FlightAware\Endpoints\LatLongsToHeading;
use FlightAware\Endpoints\NearbyAirports;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

require '../vendor/autoload.php';

class FlightAware
{
    const BASE_URL = 'http://flightxml.flightaware.com/json/FlightXML3/';

    public function __construct(string $username, string $api_key)
    {
        $this->options = [
            'base_uri' => self::BASE_URL,
            'auth' => [$username, $api_key]
        ];
    }

    // TODO: Improve handline 400 errors and exceptions
    public function request($class_name, $params = [])
    {
        $client = new Client($this->options);
        try {
            $response = $client->request('GET', $class_name::API_ENDPOINT, ['query' => $params]);
            return new $class_name($response->getBody());
        } catch (RequestException $e) {
            // TODO: Improve This
            echo $e->getMessage();
            exit;
        }
    }

    /**
     * Returns information about specified Aircraft Type.
     *
     * @param string $type
     *  Aircraft Type ID
     *
     * @return AircraftType
     */
    public function aircraft_type(string $type)
    {
        $params = ['type' => $type];
        return $this->request(AircraftType::class, $params);
    }

    /**
     * Returns information about specified airline.
     *
     * @param string $airline_code
     *  The ICAO airline ID (e.g., COA, ASA, UAL, etc.)
     *
     * @return AirlineInfo
     */
    public function airline_info(string $airline_code)
    {
        $params = ['airline_code' => $airline_code];
        return $this->request(AirlineInfo::class, $params);
    }

    /**
     * Returns Flights Scheduled, Departing, Enroute, and Arriving at specified airport.
     * @param string $airport_code
     *  Airport Code
     *
     * @param bool $include_ex_data
     *  Set to true or 1 to receive extended flight information.
     *
     * @param string $filter
     *  Specify "ga" to show only general aviation traffic, "airline" to only show airline traffic.
     *  If null/void then all types are returned. You can also limit results to a particular airline by
     *  specifying "airline:airlineCode" where the airlineCode is the ICAO identifier for that airline.
     *
     * @param string $type
     *  Can use "all" or any space separated combination of "arrivals", "departures", "enroute", and "scheduled"
     *
     * @param int $how_many
     *  Number of flights to fetch, per type.
     *
     * @param int $offset
     *  Offset for query.
     *
     * @return AirportBoards
     */
    public function airport_boards(
        string $airport_code,
        bool $include_ex_data = false,
        string $filter = '',
        string $type = 'all',
        int $how_many = 15,
        int $offset = 0
    ) {
        $params = [
            'airport_code' => $airport_code,
            'include_ex_data' => $include_ex_data,
            'filter' => $filter,
            'type' => $type,
            'howMany' => $how_many,
            'offset' => $offset
        ];
        return $this->request(AirportBoards::class, $params);
    }

    /**
     * Return information about specified airport.
     *
     * @param string $airport_code
     *  ICAO airport ID (e.g., KLAX, KSFO, KIAH, KHOU, KJFK, KEWR, KORD, KATL, etc.)
     *
     * @return AirportInfo
     */
    public function airport_info(string $airport_code): AirportInfo
    {
        $params = ['airport_code' => $airport_code];
        return $this->request(AirportInfo::class, $params);
    }

    /**
     * Given an aircraft identification, returns true if the aircraft is blocked from public tracking, false if it is not.
     *
     * @param string $ident
     *  Requested Tail Number
     *
     * @return BlockIdentCheck
     */
    public function block_ident_check(string $ident): BlockIdentCheck
    {
        $params = ['ident' => $ident];
        return $this->request(BlockIdentCheck::class, $params);
    }

    /**
     * Given an airport, CountAirportOperations returns the number of aircraft scheduled, en route or departing the airport.
     * Scheduled arrivals are non-airborne flights that are scheduled to fly to the airport in question.
     *
     * @param string $airport_code
     *  The ICAO airport ID (e.g., KLAX, KSFO, KIAH, KHOU, KJFK, KEWR, KORD, KATL, etc.)
     *
     * @return CountAirportOperations
     */
    public function count_airport_operations(string $airport_code): CountAirportOperations
    {
        $params = ['airport_code' => $airport_code];
        return $this->request(CountAirportOperations::class, $params);
    }

    /**
     * Returns an array of airlines and how many flights each currently has enroute.
     *
     * @return CountAllEnrouteAirlineOperations
     */
    public function count_all_enroute_airline_operations(): CountAllEnrouteAirlineOperations
    {
        return $this->request(CountAllEnrouteAirlineOperations::class);
    }

    /**
     * Given a flight identifier (faFlightID) of a past, current, or future flight, DecodeFlightRoute returns a
     * "cracked" list of noteworthy navigation points along the planned flight route.
     *
     * @param string $faFlightID
     *  Unique identifier assigned by FlightAware for the desired flight (or use "ident@departureTime").
     *
     * @return DecodeFlightRoute
     * TODO: FINISH THIS METHOD
     */
    public function decode_flight_route(string $faFlightID): DecodeFlightRoute
    {
        $params = ['faFlightID' => $faFlightID];
        return $this->request(DecodeFlightRoute::class, $params);
    }

    /**
     * Given an origin airport, destination airport, and a route between them, DecodeRoute returns a "cracked" list
     * of noteworthy navigation points along the planned flight route.
     *
     * @param string $origin
     *  Origin airport code
     *
     * @param string $route
     *  Space separated list of intersections and/or VORs along the route (e.g. WYLSN MONNT KLJOY MAJKK REDDN4)
     *
     * @param string $destination
     *  Destination airport code
     *
     * @return DecodeRoute
     *
     * TODO: FINISH METHOD
     */
    public function decode_route(string $origin, string $route, string $destination): DecodeRoute
    {
        $params = ['origin' => $origin, 'route' => $route, 'destination' => $destination];
        return $this->request(DecodeRoute::class, $params);
    }

    /**
     * Returns matching flights based on an origin/destination pair. The returned results may include
     * non-stop or one-stop flights.
     *
     * @param string $origin
     *  Airport of Origin
     *
     * @param string $destination
     *  Airport of Destination
     *
     * @param bool $include_ex_data
     *  Set to true or 1 to receive extended flight information.
     *
     * @param string $type
     *  Type of search (auto, nonstop, onestop).
     *
     * @param string $filter
     *  Filter restrictions (all, ga, airline)
     *
     * @param int $how_many
     *  Maximum number of results to return. Must be a positive integer.
     *
     * @param int $offset
     *  Must be an integer value of the offset row count you want the search to start at.
     *
     * @return FindFlight
     *
     * TODO: Partially Implemented - Consider custom class for each flight/segment
     */
    public function find_flight(
        string $origin,
        string $destination,
        bool $include_ex_data = false,
        string $type = 'auto',
        string $filter = 'all',
        int $how_many = 15,
        int $offset = 0
    ): FindFlight {
        $params = [
            'origin' => $origin,
            'destination' => $destination,
            'include_ex_data' => $include_ex_data,
            'type' => $type,
            'filter' => $filter,
            'howMany' => $how_many,
            'offset' => $offset
        ];

        return $this->request(FindFlight::class, $params);
    }

    /**
     * Returns the flights scheduled, departing, enroute, for a specified airline.
     *
     * @param string $fleet_code
     *  ICAO airline code.
     *
     * @param bool $include_ex_data
     *  Set to true or 1 to receive extended flight information.
     *
     * @param string $type
     *  Select one of "arrivals", "departures", "enroute", "scheduled", or "all".
     *
     * @param int $how_many
     *  Number of flights to fetch, per type.
     *
     * @param int $offset
     *  Offset for query.
     *
     * @return FleetBoards
     */
    public function fleet_boards(
        string $fleet_code,
        bool $include_ex_data = false,
        string $type = 'all',
        int $how_many = 15,
        int $offset = 0
    ): FleetBoards
    {
        $params = [
            'fleet_code'        => $fleet_code,
            'include_ex_data'   => $include_ex_data,
            'type'              => $type,
            'howMany'           => $how_many,
            'offset'            => $offset
        ];

        return $this->request(FleetBoards::class, $params);
    }

    /**
     * Fetches statistics about how many flights have been cancelled on the specified day, and aggregated by the
     * specified breakdown criteria.
     *
     * @param string $time_period
     *  Specifies which day to analyze. (must be 'yesterday', 'today', 'tomorrow', 'plus2days', 'twoDaysAgo',
     *  'minus2plus12hrs', 'next36hrs', 'week').
     *
     * @param string $type_matching
     *  The aggregation criteria. (must be 'airline', 'origin', or 'destination').
     *
     * @param string $ident_filter
     *  This argument can be blank/unspecified to request that all results are returned. Otherwise, when type_matching
     *  is 'airline', this argument can be the specific airline you are interested in. When type_matching is 'origin'
     *  or 'destination', this argument can be the specific airport you are interested in.
     *
     * @param int $how_many
     *  Maximum number of aggregated rows to return, ordered by highest to lowest. Must be a positive integer.
     *
     * @param int $offset
     *  Must be an integer value of the offset row count you want the search to start at.
     *
     * @return FlightCancellationStatistics
     */
    public function flight_cancellation_statistics(
        string $time_period,
        string $type_matching,
        string $ident_filter = '',
        int $how_many = 15,
        int $offset = 0
    ): FlightCancellationStatistics {
        $params = [
            'time_period'       => $time_period,
            'type_matching'     => $type_matching,
            'ident_filter'      => $ident_filter,
            'howMany'           => $how_many,
            'offset'            => $offset
        ];

        return $this->request(FlightCancellationStatistics::class, $params);
    }

    /**
     * Returns information about flights for a specific tail number (e.g., N12345), or an ident (typically an ICAO
     * airline with flight number, e.g., SWA2558), or a FlightAware-assigned unique flight identifier (e.g. faFlightID
     * returned by another FlightXML function). When a tail number or ident is specified and multiple flights are
     * available, the results will be returned from newest to oldest. The oldest flights searched by this function are
     * about 2 weeks in the past. Codeshares and alternate idents are automatically searched. When a
     * FlightAware-assigned unique flight identifier is supplied, at most a single result will be returned.
     *
     * Times are provided in a nested data structure that contains the representation in several different formats,
     * including UTC integer seconds since 1970 (UNIX epoch time), and integer seconds since 1970 relative to the
     * local (airport) timezone. The estimated time enroute (filed_ete) is given in seconds.
     *
     * The inbound_faFlightID field will only be included for queries that use a howMany of 15 or less.
     *
     * @param string $ident
     *  Requested tail number, ident, atc_ident, or faFlightID
     *
     * @param bool $include_ex_data
     *  Set to true or 1 to receive extended flight information.
     *
     * @param string $filter
     *  This filter will be available in the future and will utilize ODate logical operators to filter results.
     *
     * @param int $how_many
     *  Maximum number of past flights to obtain. Must be a positive integer value.
     *
     * @param int $offset
     *  Must be an integer value of the offset row count you want the search to start at.
     *
     * @return FlightInfoStatus
     *
     * TODO: Implement Flight Data Struct?
     */
    public function flight_info_status(
        string $ident,
        bool $include_ex_data = false,
        string $filter = '',
        int $how_many = 15,
        int $offset = 0
    ): FlightInfoStatus {
        $params = [
            'ident'             => $ident,
            'include_ex_data'   => $include_ex_data,
            'filter'            => $filter,
            'howMany'           => $how_many,
            'offset'            => $offset
        ];

        return $this->request(FlightInfoStatus::class, $params);
    }

    /**
     * Looks up a flight's track log by its unique FlightAware identifier (e.g. SKW5252-1491801993-airline-0107) or
     * flight ident and departure time (e.g. SKW5252@1492037400). To obtain the faFlightID, you can use a function
     * such as FlightInfoStatus. It returns the track log for that flight if it has departed. It returns an array of
     * positions, with each including the timestamp, longitude, latitude, groundspeed, altitude, altitudestatus,
     * updatetype, and altitudechange. Altitude is in hundreds of feet or Flight Level where appropriate.
     *
     * Altitude status is 'C' when the flight is more than 200 feet away from its ATC-assigned altitude.
     * (For example, the aircraft is transitioning to its assigned altitude.) Altitude change is 'C' if the aircraft
     * is climbing (compared to the previous position reported), 'D' for descending, and empty if it is level.
     * This happens for VFR flights with flight following, among other things. Timestamp is integer seconds
     * since 1970 (UNIX epoch time).
     *
     * Codeshares and alternate idents are automatically searched.
     *
     * @param string $ident
     *  Requested flight id (either a FlightAware flight id (e.g. SWA35-1491974780-airline-0046) or an ident
     *  with departure time (e.g. SWA35@1492200000))
     *
     * @param bool $include_position_estimates
     *  Set to true to return estimated positions in the track.
     *
     * @return GetFlightTrack
     */
    public function get_flight_track(string $ident, bool $include_position_estimates = false): GetFlightTrack
    {
        $params = ['ident' => $ident, 'include_position_estimates' => $include_position_estimates];
        return $this->request(GetFlightTrack::class, $params);
    }

    /**
     * Given two latitudes and longitudes, lat1 lon1 lat2 and lon2, respectively, determine the great circle distance
     * between those positions in miles. The returned distance is rounded to the nearest whole mile.
     *
     * @param float $lat1
     *  Latitude of Point 1
     *
     * @param float $lon1
     *  Longitude of Point 1
     *
     * @param float $lat2
     *  Latitude of Point 2
     *
     * @param float $lon2
     *  Longitude of Point 2
     *
     * @return LatLongsToDistance
     */
    public function lat_longs_to_distance(float $lat1, float $lon1, float $lat2, float $lon2): LatLongsToDistance
    {
        $params = ['lat1' => $lat1, 'lon1' => $lon1, 'lat2' => $lat2, 'lon2' => $lon2];
        return $this->request(LatLongsToDistance::class, $params);
    }

    /**
     * Given two latitudes and longitudes, lat1 lon1 lat2 and lon2, respectively, calculate and return the initial
     * compass heading (where 360 is North) from position one to position two. Quite accurate for relatively short
     * distances but since it assumes the earth is a sphere rather than on irregular oblate sphereoid may be inaccurate
     * for flights around a good chunk of the world, etc.
     *
     * @param float $lat1
     *  Latitude of Point 1
     *
     * @param float $lon1
     *  Longitude of Point 1
     *
     * @param float $lat2
     *  Latitude of Point 2
     *
     * @param float $lon2
     *  Longitude of Point 2
     *
     * @return LatLongsToHeading
     */
    public function lat_longs_to_heading(float $lat1, float $lon1, float $lat2, float $lon2): LatLongsToHeading
    {
        $params = ['lat1' => $lat1, 'lon1' => $lon1, 'lat2' => $lat2, 'lon2' => $lon2];
        return $this->request(LatLongsToHeading::class, $params);
    }

    /**
     * Returns a list of airports near the latitude / longitude or airport code specified within the given radius.
     * You must specify either a latitude/longitude OR an airport code.
     *
     * @param int $radius
     *  The search radius to use for finding nearby airports in statute miles.
     *
     * @param float|null $latitude
     *  The latitude of the point to search near.
     *
     * @param float|null $longitude
     *  The longitude of the point to search near.
     *
     * @param string|null $airport_code
     *  The airport code to search near.
     *
     * @param bool $only_iap
     *  Return only airports with Instrument Approaches (also limits results to North America).
     *
     * @param int $how_many
     *  Maximum number of aggregated rows to return. Must be a positive integer.
     *
     * @param int $offset
     *  Must be an integer value of the offset row count you want the search to start at.
     *
     * @return NearbyAirports
     */
    public function nearby_airports(
        int $radius,
        float $latitude = null,
        float $longitude = null,
        string $airport_code = null,
        bool $only_iap = false,
        int $how_many = 15,
        int $offset = 0
    ): NearbyAirports {
        $params = [
            'latitude' => $latitude,
            'longitude' => $longitude,
            'airport_code' => $airport_code,
            'radius' => $radius,
            'only_iap' => $only_iap,
            'howMany' => $how_many,
            'offset' => $offset
        ];

        return $this->request(NearbyAirports::class, $params);
    }

    public function routes_between_airports(
        string $origin,
        string $destination,
        string $max_file_age,
        string $sort_by,
        int $how_many = 15,
        int $offset = 0
    )

    public function airline_flight_schedules(
        int $start_date,
        int $end_date,
        string $origin = '',
        string $destination = '',
        string $airline = '',
        string $flightno = '',
        bool $exclude_codeshare = false,
        int $how_many = 15,
        int $offset = 0
    ) {
        $params = [
            'start_date'            => $start_date,
            'end_date'              => $end_date,
            'origin'                => $origin,
            'destination'           => $destination,
            'airline'               => $airline,
            'flightno'              => $flightno,
            'exclude_codeshare'     => $exclude_codeshare,
            'howMany'               => $how_many,
            'offset'                => $offset
        ];

        return $this->request(AirlineFlightSchedules::class, $params);
    }
}


$client = new FlightAware($username, $api_key);
//$aircraft_type = $client->aircraft_type(['type' => 'GALX']);
$data = $client->nearby_airports(30, null, null, 'KBHM');
print_r($data->raw());
