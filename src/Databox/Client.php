<?php

namespace Databox;

use GuzzleHttp\Client as GuzzleClient;

class Client extends GuzzleClient
{
    const API_VERSION  = '2.0';
    const API_ENDPOINT = 'https://push.databox.com';

    public function __construct($pushToken = null)
    {
        $majorVer = explode('.', self::API_VERSION)[0];
        parent::__construct([
            'base_uri' => self::API_ENDPOINT,
            'headers'  => [
                'User-Agent'   => 'databox-php/' . self::API_VERSION,
                'Content-Type' => 'application/json',
                'Accept'       => 'application/vnd.databox.v' . $majorVer . '+json'
            ],
            'auth' => [$pushToken, '', 'Basic']
        ]);
    }

    public function rawPost($path = '/', $data = [])
    {
        return json_decode($this->post($path, $data)->getBody(), true);
    }

    public function rawGet($path)
    {
        return json_decode($this->get($path)->getBody(), true);
    }

    private function rawDelete($path)
    {
        return json_decode($this->delete($path)->getBody(), true);
    }

    private function processKPI($key, $value, $date = null, $attributes = null, $unit = null)
    {
        $data = [sprintf('$%s', trim($key, '$')) => $value];
        if (!is_null($date)) {
            $data['date'] = $date;
        }
        if (!is_null($unit)) {
            $data['unit'] = $unit;
        }

        if (is_array($attributes)) {
            $data = $data + $attributes;
        }

        return $data;
    }

    public function push($key, $value, $date = null, $attributes = null, $unit = null)
    {
        $response = $this->rawPost('/', [
            'json' => ['data' => [$this->processKPI($key, $value, $date, $attributes, $unit)]]
        ]);

        return $response['id'];
    }

    public function insertAll($kpis)
    {
        $response = $this->rawPost('/', [
            'json' => ['data' => array_map(function ($i) {
                $i = $i + [null, null, null, null, null];

                return $this->processKPI($i[0], $i[1], $i[2], $i[3], $i[4]);
            }, $kpis)]
        ]);

        return $response['id'];
    }

    public function lastPush($n = 1)
    {
        return $this->rawGet(sprintf('/lastpushes?limit=%d', $n));
    }

    public function getPush($sha)
    {
        if (is_array($sha) && !empty($sha)) {
            return $this->rawGet('/lastpushes?id=' . implode(',', $sha));
        } else {
            return $this->rawGet("/lastpushes/{$sha}");
        }
    }

    public function metrics()
    {
        return $this->rawGet('/metrickeys');
    }

    public function purge()
    {
        return $this->rawDelete('/data');
    }
}
