<?php

namespace Databox\Tests;

use Databox\Client;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    function __construct(){
        $this->client = new Client("adxg1kq5a4g04k0wk0s4wkssow8osw84");
    }

    /*
    public function testInitialisation()
    {
        //TODO: Token thing here
        $this->assertEquals(get_class($this->client), 'Databox\Client');
    }
*/

    public function testPush() {
        $this->assertTrue($this->client->push("sales", 53.2));
        $this->assertTrue($this->client->push("sales", 40, "2015-01-01 17:00:00"));
    }

    public function testInsertAll() {
        $this->assertTrue($this->client->insertAll([
            ["sales", 53.2],
            ["sales", 50.2, "2015-01-01 17:00:00"],
        ]));
    }


    public function testLastPush() {
        $this->assertCount(1, $this->client->lastPush());
        $this->assertCount(3, $this->client->lastPush(3));
    }
}
