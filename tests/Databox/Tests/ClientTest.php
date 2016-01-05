<?php

namespace Databox\Tests;

use Databox\Client;
use GuzzleHttp\Psr7\Response;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    public function __construct()
    {
        $this->client = $this->getMockBuilder('Databox\Client')
            ->setMethods(['rawPush'])
            ->getMock();
    }

    public function testClientCorrectOptions()
    {
        $mimeType  = 'application/json';
        $userAgent = 'databox-php';
        $token     = 'test-token';
        $baseUrl   = 'https://push2new.databox.com';

        $client = new Client($token);
        $this->assertEquals($mimeType, $client->getConfig('headers')['Content-Type']);
        $this->assertEquals($userAgent, substr($client->getConfig('headers')['User-Agent'], 0, 11));
        $this->assertEquals($mimeType, $client->getConfig('headers')['Accept']);
        $this->assertEquals($baseUrl, (string) $client->getConfig('base_uri'));
        $this->assertEquals($token, $client->getConfig('auth')[0]);
    }

    public function testRawPush()
    {
        $client = $this->getMockBuilder('Databox\Client')
            ->setMethods(['post'])
            ->getMock();

        $json     = '{"status":"ok"}';
        $response = new Response(200, [], $json);
        $client->method('post')->willReturn($response);

        $this->assertEquals($json, json_encode($client->rawPush()));
    }

    public function testLastPush()
    {
        $this->client->method('rawPush')->willReturn([
            [], []
        ]);

        $this->assertCount(2, $this->client->lastPush(2));
    }

    public function testPush()
    {
        $this->client->method('rawPush')->willReturn(
            ['status' => 'ok']
        );

        $this->assertTrue($this->client->push('sales', 53.2));
        $this->assertTrue($this->client->push('sales', 40, '2015-01-01 17:00:00'));
        $this->assertTrue($this->client->push('sales', 40, '2015-01-01 17:00:00', [
            'name' => 'attribute name'
        ]));
    }

    public function testFailedPush()
    {
        $this->client->method('rawPush')->willReturn(
            ['status' => 'warnings some items not inserted (ok: 0, false: 1)']
        );

        $this->assertFalse($this->client->push(null, null));
    }

    public function testInsertAll()
    {
        $this->client->method('rawPush')->willReturn(
            ['status' => 'ok']
        );

        $this->assertTrue($this->client->insertAll([
            ['sales', 53.2],
            ['sales', 50.2, '2015-01-01 17:00:00'],
        ]));
    }
}
