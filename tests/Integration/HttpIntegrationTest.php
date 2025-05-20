<?php

namespace Integration;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class HttpIntegrationTest extends TestCase
{
    public function testEndpointReturnsExpectedJson()
    {
        $routes = [
            '/ranking/movement/Deadlift',
            '/ranking/movement/1',
            '/movement/1/ranking',
            '/movement/Deadlift/ranking'
        ];
        foreach ($routes as $route) {
            $this->endpointGETReturnsExpectedJson($route);
        }
    }
    public function endpointGETReturnsExpectedJson($route): void
    {
        $client = new Client(['base_uri' => 'http://localhost:8000']);

        $response = $client->request('GET', $route);
        $this->assertEquals(201, $response->getStatusCode());

        $data = json_decode((string) $response->getBody(), true);

        $this->assertIsArray($data);
        $this->assertArrayHasKey('movement', $data);
        $this->assertArrayHasKey('ranking', $data);
        $this->assertEquals('Deadlift', $data['movement']);
    }
}