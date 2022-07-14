<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\HttpClient;

class LogParserAPITest extends TestCase
{
    public function testEndpoint(): void
    {

    $client = HttpClient::create();
        
    $response = $client->request('GET', 'http://symfony_dockerized_nginx_1/count');

    $this->assertEquals(200, $response->getStatusCode());
    }
}
