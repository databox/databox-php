<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

use Databox\Api\DefaultApi;
use Databox\ApiException;
use Databox\Configuration;
use Databox\Model\PushData as DataboxPushData;
use GuzzleHttp\Client;

execute();

function execute()
{
    // Configure HTTP basic authorization: basicAuth
    $config = Configuration::getDefaultConfiguration()
        ->setHost('https://push.databox.com')
        ->setUsername('<CUSTOM_DATA_TOKEN>')
        ->setUserAgent('databox-designer-pushdata/2.0');

    $headers = [
        'Content-Type' => 'application/json',
        'Accept'       => 'application/vnd.databox.v2+json'
    ];

    $apiInstance = new DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
        new Client(['headers' => $headers]),
        $config
    );

    $pushData = (new DataboxPushData())
        ->setKey('<METRIC_KEY_NAME>') // for e.g. sessions
        ->setValue(125)
        ->setDate('2017-01-01T00:00:00Z') // Date in ISO8601 format
        ->setUnit('<UNIT>') // for e.g. $
        ->setAttributes(['<DIMENSION_VALUE>']); // for e.g. ['US']

    try {
        $apiInstance->dataPost([$pushData]);
        echo "Successfully pushed data to Databox";
    } catch (ApiException $e) {
        echo 'Exception when calling DefaultApi->dataPost: ' . $e->getMessage() . PHP_EOL . $e->getResponseBody() . PHP_EOL;
    }
}