<?php
namespace Databox\Tests;

use Databox\Widget as Widget;
use Databox\KPI as KPI;
use Databox\Widget\Table as Table;

class PushTest extends DataboxTestCase
{

    public function testPushData()
    {
        $this->builder->addKpi(new KPI("testlinechart", 123));
        $this->builder->addKpi(new KPI("testbarchart", 300, new \DateTime("2013-07-30 22:53:00")));
        $this->builder->addKpi(new KPI("testmain", 300, new \DateTime("2013-07-30 22:53:00")));
        $this->builder->addKpi(new KPI("testbignumber", 123));
        $this->builder->addKpi(new KPI("testcompare", 300, new \DateTime("2013-07-30 22:53:00")));
        $this->builder->addKpi(new KPI("testintervalvalues", 300, new \DateTime("2013-07-30 22:53:00")));
        
        $res = $this->client->pushData($this->builder);

        $this->assertTrue($res->hasKey('response'));
        $this->assertEquals('success', $res->get('response')['type']);
    }

    public function testGetPushLog()
    {
        $result = $this->client->getPushLog();
        $this->assertTrue(isset($result[0]['time']));
    }
}
