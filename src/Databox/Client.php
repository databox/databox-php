<?php

namespace Databox;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Event\BeforeEvent;

class Client extends GuzzleClient
{

    function __construct($pushToken = null)
    {
        parent::__construct([
            'base_url' => 'https://push2new.databox.com',
            'defaults' => [
                'headers' => [
                    'Content-Type' => 'application/json'
                ],
                'auth' => [$pushToken, '', 'Basic']
            ],
        ]);

        /*
        $this->getEmitter()->on('before', function (BeforeEvent $e) {
            echo PHP_EOL.'About to send request: ' . $e->getRequest();
        });
        */
    }

    private function processKPI($key, $value, $date = null)
    {
        $data = [sprintf("$%s", $key) => $value];
        if (!is_null($date)) $data["date"] = $date;
        return $data;
    }

    public function push($key, $value, $date = null)
    {
        return $this->post('/', [
            'json' => ['data' => [$this->processKPI($key, $value, $date)]]
        ])->json()["status"] == "ok";
    }

    public function insertAll($kpis)
    {
        return $this->post('/', [
            'json' => ['data' => array_map(function ($i) {
                if (count($i) < 3) $i[] = null;
                return $this->processKPI($i[0], $i[1], $i[2]);
            }, $kpis)]
        ])->json()["status"] == "ok";
    }

    public function lastPush($n = 1)
    {
        return $this->post(sprintf('/lastpushes/%d', $n))->json();
    }
}
