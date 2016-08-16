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
        $this->assertEquals($json, json_encode($client->lastPush()));
    }

    public function testRawDelete()
    {
        $client = $this->getMockBuilder('Databox\Client')
            ->setMethods(['delete'])
            ->getMock();

        $json = '[]';
        $response = new Response(200, [], $json);
        $client->method('delete')->willReturn($response);
        $this->assertEquals($json, json_encode($client->purge()));
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

    public function testMetrics()
    {
        $respose = json_decode('{"metrics":[{"title":"Val","key":"21805|val"},{"title":"Ping","key":"21805|ping"},{"title":"Sales","key":"21805|sales"},{"title":"Transaction","key":"21805|transaction"}]}', true);
        $this->client->method('rawGet')->willReturn($respose);

        $metrics = $this->client->metrics();
        $this->assertArrayHasKey('metrics', $metrics);
        $this->assertTrue(!empty($metrics['metrics']));
    }

    public function testGetPushWithId()
    {
        $sha     = '147130560011282848ac51b10b6c0c';
        $respose = json_decode('{"request":{"date":"2016-08-16T13:45:21.640Z","body":{"data":[{"$referal":2677,"date":"2016-08-15","country":"Slovenia","city":"Ptuj","site":"https:\/\/databox.com"}]},"errors":[]},"response":{"date":"2016-08-16T13:45:21.645Z","body":{"id":"147130560011282848ac51b10b6c0c"}},"metrics":["21805|referal|country","21805|referal|city","21805|referal|site"]}', true);
        $this->client->method('rawGet')->willReturn($respose);

        $push = $this->client->getPush($sha);
        $this->assertArrayHasKey('request', $push);
        $this->assertArrayHasKey('response', $push);
        $this->assertArrayHasKey('metrics', $push);
        $this->assertEquals($sha, $push['response']['body']['id']);
    }

    public function testGetPushWithMultipleIds()
    {
        $sha = [
            '147130560011282848ac51b10b6c0c',
            '147130560098f4d9fc0a87f60256bd',
            '1471305600b12452f84e232768c117'
        ];
        $respose = json_decode('[{"request":{"date":"2016-08-16T13:45:21.493Z","body":{"data":[{"$referal":2677,"date":"2016-08-15","country":"Slovenia","city":"Ptuj","site":"https:\/\/databox.com"}]},"errors":[]},"response":{"date":"2016-08-16T13:45:21.500Z","body":{"id":"147130560011282848ac51b10b6c0c"}},"metrics":["21805|referal|country","21805|referal|city","21805|referal|site"]},{"request":{"date":"2016-08-16T13:45:21.493Z","body":{"data":[{"$sales":2874,"date":"2016-08-16"}]},"errors":[]},"response":{"date":"2016-08-16T13:45:21.500Z","body":{"id":"147130560098f4d9fc0a87f60256bd"}},"metrics":["21805|sales"]},{"request":{"date":"2016-08-16T13:45:21.493Z","body":{"data":[{"$sales":9333}]},"errors":[]},"response":{"date":"2016-08-16T13:45:21.500Z","body":{"id":"1471305600b12452f84e232768c117"}},"metrics":["21805|sales"]}]', true);
        $this->client->method('rawGet')->willReturn($respose);

        $push = $this->client->getPush($sha);
        $this->assertEquals(3, count($push));
        $this->assertEquals($sha[0], $push[0]['response']['body']['id']);
        $this->assertEquals($sha[1], $push[1]['response']['body']['id']);
        $this->assertEquals($sha[2], $push[2]['response']['body']['id']);
    }

    public function testInsertAll()
    {
        $respose = ['id' => '1471305600b2ec099fde352d6c58b3'];
        $this->client->method('rawPost')->willReturn($respose);

        $this->assertEquals($respose['id'], $this->client->insertAll([
            ['sales', 53.2],
            ['sales', 50.2, '2015-01-01 17:00:00'],
            ['sales', 50.2, '2015-01-01 17:00:00', null, 'USD']
        ]));
    }
}
