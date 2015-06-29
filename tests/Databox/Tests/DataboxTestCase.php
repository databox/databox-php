<?php

namespace Databox\Tests;

use Databox\DataboxClient;
use Databox\DataboxBuilder;
use Guzzle\Log\ClosureLogAdapter;
use Guzzle\Plugin\Log\LogPlugin;
use Guzzle\Log\MessageFormatter;

class DataboxTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DataboxClient
     */
    protected $client;

    /**
     * @var DataboxBuilder
     */
    protected $builder;

    public function setUp()
    {
        /**
         * username: test@databox.com
         * password: test123
         * connection: PHP SDK Test
         */
        $this->client = new DataboxClient('17kibd5ds7a8k48s4wc0csoc88gckgw4os8400c04kc4w0kkcw');
        $this->client->setSourceToken('32lkojmk5sw08o44');

        $adapter = new ClosureLogAdapter(function ($m) { file_put_contents('trace.log',$m,\FILE_APPEND); });
        $logPlugin = new LogPlugin($adapter, MessageFormatter::DEBUG_FORMAT);
        $this->client->addSubscriber($logPlugin);

        $this->builder = new DataboxBuilder();
    }
}
