<?php

namespace Databox\Tests;

use Databox\Client;
use GuzzleHttp\Psr7\Response;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    const API_VERSION = 2;

    public function __construct()
    {
        $this->client = $this->getMockBuilder('Databox\Client')
            ->setMethods(['rawPost', 'rawGet'])
            ->getMock();
    }

    public function testClientCorrectOptions()
    {
        $mimeType  = 'application/json';
        $userAgent = 'databox-php/2.0';
        $accept    = 'application/vnd.databox.v' . self::API_VERSION . '+json';
        $token     = 'test-token';
        $baseUrl   = 'https://push.databox.com';

        $client = new Client($token);
        $this->assertEquals($mimeType, $client->getConfig('headers')['Content-Type']);
        $this->assertEquals($userAgent, $client->getConfig('headers')['User-Agent']);
        $this->assertEquals($accept, $client->getConfig('headers')['Accept']);
        $this->assertEquals($baseUrl, (string) $client->getConfig('base_uri'));
        $this->assertEquals($token, $client->getConfig('auth')[0]);
    }

    public function testRawPost()
    {
        $client = $this->getMockBuilder('Databox\Client')
            ->setMethods(['post'])
            ->getMock();

        $json = '{"status":"ok"}';
        $response = new Response(200, [], $json);
        $client->method('post')->willReturn($response);

        $this->assertEquals($json, json_encode($client->rawPost()));
    }

    public function testRawGet()
    {
        $client = $this->getMockBuilder('Databox\Client')
            ->setMethods(['get'])
            ->getMock();

        $json = '[]';
        $response = new Response(200, [], $json);
        $client->method('get')->willReturn($response);
        $this->assertEquals($json, json_encode([]));
    }

    public function testLastPush()
    {
        $this->client->method('rawGet')->willReturn([
            [], []
        ]);

        $this->assertCount(2, $this->client->lastPush(2));
    }

    public function testPush()
    {
        $respose = ['id' => '1471305600b2ec099fde352d6c58b3'];
        $this->client->method('rawPost')->willReturn($respose);

        $this->assertEquals($respose['id'], $this->client->push('sales', 53.2));
        $this->assertEquals($respose['id'], $this->client->push('sales', 40, '2015-01-01 17:00:00'));
        $this->assertEquals($respose['id'], $this->client->push('sales', 40, '2015-01-01 17:00:00', [
            'name' => 'attribute name'
        ]));
    }

    public function testInsertAll()
    {
        $respose = ['id' => '1471305600b2ec099fde352d6c58b3'];
        $this->client->method('rawPost')->willReturn($respose);

        $this->assertEquals($respose['id'], $this->client->insertAll([
            ['sales', 53.2],
            ['sales', 50.2, '2015-01-01 17:00:00'],
        ]));
    }
}
