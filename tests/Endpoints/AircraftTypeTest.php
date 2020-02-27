<?php declare(strict_types=1);

use FlightAware\Endpoints\AircraftType;
use FlightAware\Utils\GuzzleClient;
use PHPUnit\Framework\TestCase;

final class AircraftTypeTest extends TestCase
{
    const ENDPOINT = '';
    private $client;

    protected function setUp(): void
    {
        $this->client = new GuzzleClient([
            'base_uri' => 'http://flightxml.flightaware.com/json/FlightXML3/',
            'auth' => [$username, $api_key]
        ]);
    }

    public function testAircraftTypeShowsCorrectAircraft(): void
    {

    }

    public function testEndpointSuccessfullyConnectsToApi(): void
    {
        $options = [
            'params' => [
                'type' => 'GALX'
            ]
        ];
        $aircraftType = new AircraftType($this->client, $options);
        $this->assertIsArray($aircraftType->data());
    }
}
