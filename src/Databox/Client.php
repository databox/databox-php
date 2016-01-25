<?php

namespace Databox;

use GuzzleHttp\Client as GuzzleClient;

class Client extends GuzzleClient
{
    public function __construct($pushToken = null)
    {
        parent::__construct([
            'base_uri' => 'https://push2new.databox.com',
            'headers' => [
                'User-Agent' => 'databox-php/1.3',
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ],
            'auth' => [$pushToken, '', 'Basic']
        ]);
    }

    public function rawPush($path = '/', $data = [])
    {
        return json_decode($this->post($path, $data)->getBody(), true);
    }

    public function rawGet($path)
    {
        return json_decode($this->get($path)->getBody(), true);
    }

    private function processKPI($key, $value, $date = null, $attributes = null)
    {
        $data = [sprintf('$%s', trim($key, '$')) => $value];
        if (!is_null($date)) {
            $data['date'] = $date;
        }

        if (is_array($attributes)) {
            $data = $data + $attributes;
        }

        return $data;
    }

    public function push($key, $value, $date = null, $attributes = null)
    {
        $response = $this->rawPush('/', [
            'json' => ['data' => [$this->processKPI($key, $value, $date, $attributes)]]
        ]);

        return $response['status'] === 'ok';
    }

    public function insertAll($kpis)
    {
        $response = $this->rawPush('/', [
            'json' => ['data' => array_map(function ($i) {
                $i = $i + [null, null, null, null];

                return $this->processKPI($i[0], $i[1], $i[2], $i[3]);
            }, $kpis)]
        ]);

        return $response['status'] === 'ok';
    }

    public function lastPush($n = 1)
    {
        return $this->rawGet(sprintf('/lastpushes/%d', $n));
    }
}
