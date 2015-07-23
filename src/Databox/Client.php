<?php

namespace Databox;

use GuzzleHttp\Client as GuzzleClient;

class Client extends GuzzleClient
{
    public function __construct($pushToken = null)
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
    }

    public function rawPush($path = '/', $data = [])
    {
        return $this->post($path, $data)->json();
    }

    private function processKPI($key, $value, $date = null)
    {
        $data = [sprintf('$%s', $key) => $value];
        if (!is_null($date)) {
            $data['date'] = $date;
        }

        return $data;
    }

    public function push($key, $value, $date = null)
    {
        $response = $this->rawPush('/', [
            'json' => ['data' => [$this->processKPI($key, $value, $date)]]
        ]);

        return $response['status'] === 'ok';
    }

    public function insertAll($kpis)
    {
        $response = $this->rawPush('/', [
            'json' => ['data' => array_map(function ($i) {
                if (count($i) < 3) {
                    $i[] = null;
                }

                return $this->processKPI($i[0], $i[1], $i[2]);
            }, $kpis)]
        ]);

        return $response['status'] === 'ok';
    }

    public function lastPush($n = 1)
    {
        return $this->rawPush(sprintf('/lastpushes/%d', $n));
    }
}
