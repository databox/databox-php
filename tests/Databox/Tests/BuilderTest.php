<?php

namespace Databox\Tests;

use Databox\Widget as Widget;
use Databox\KPI as KPI;
use Databox\Widget\Table as Table;

class BuilderTest extends DataboxTestCase
{
    public function testCreate()
    {
        $this->builder->addKpi(new KPI("milan", 150, new \DateTime("2013-09-17 23:15:18")));
        $this->builder->addKpi(new KPI("kucan", 250, new \DateTime("2013-07-30 22:55:00")));

        $this->assertEquals('{"data":[{"key":"milan","value":"150","date":"2013-09-17T23:15:18","attributes":[]},{"key":"kucan","value":"250","date":"2013-07-30T22:55:00","attributes":[]}]}', $this->builder->getPayload());
    }

    public function testReset()
    {
        $this->builder->reset();
        $this->assertEquals('[]', $this->builder->getPayload());
    }
}
