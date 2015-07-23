<?php

namespace Databox\Tests;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    public function __construct()
    {
        $this->client = $this->getMockBuilder('Databox\Client')
            ->setMethods(['rawPush'])
            ->setConstructorArgs(['adxg1kq5a4g04k0wk0s4wkssow8osw84'])
            ->getMock();
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
