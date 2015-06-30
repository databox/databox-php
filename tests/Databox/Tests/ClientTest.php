<?php

namespace Databox\Tests;

use Databox\Client as Client;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    public function testInitialisation(){
        $this->client = new Client();
        $this->assertEquals(get_class($this->client), Client);
    }
}
