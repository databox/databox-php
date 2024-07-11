# Databox

Push API resources Open API documentation


## Installation & Usage

### Requirements

PHP 7.4 and later.
Should also work with PHP 8.0.

### Composer

To install the bindings via [Composer](https://getcomposer.org/), add the following to `composer.json`:

```json
{
  "repositories": [
    {"type": "composer", "url": "https://repo.packagist.com/databox/"}
  ],
  "require" : {
    "databox/databox": "@stable"
  }
}
```

Then run `composer install`

## Getting Started

Please follow the [installation procedure](#installation--usage) and then run the following:

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



// Configure HTTP basic authorization: basicAuth
$config = Databox\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new Databox\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);

try {
    $apiInstance->dataDelete();
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->dataDelete: ', $e->getMessage(), PHP_EOL;
}

```

## API Endpoints

All URIs are relative to *https://push.databox.com*

Class | Method | HTTP request | Description
------------ | ------------- | ------------- | -------------
*DefaultApi* | [**dataDelete**](docs/Api/DefaultApi.md#datadelete) | **DELETE** /data | 
*DefaultApi* | [**dataMetricKeyDelete**](docs/Api/DefaultApi.md#datametrickeydelete) | **DELETE** /data/{metricKey} | 
*DefaultApi* | [**dataPost**](docs/Api/DefaultApi.md#datapost) | **POST** /data | 
*DefaultApi* | [**metrickeysGet**](docs/Api/DefaultApi.md#metrickeysget) | **GET** /metrickeys | 
*DefaultApi* | [**metrickeysPost**](docs/Api/DefaultApi.md#metrickeyspost) | **POST** /metrickeys | 
*DefaultApi* | [**pingGet**](docs/Api/DefaultApi.md#pingget) | **GET** /ping | 

## Models

- [ApiResponse](docs/Model/ApiResponse.md)
- [PushData](docs/Model/PushData.md)
- [PushDataAttribute](docs/Model/PushDataAttribute.md)
- [State](docs/Model/State.md)

## Authorization

Authentication schemes defined for the API:
### basicAuth

- **Type**: HTTP basic authentication

## Tests

To run the tests, use:

```bash
composer install
vendor/bin/phpunit
```

## Author



## About this package

This PHP package is automatically generated by the [OpenAPI Generator](https://openapi-generator.tech) project:

- API version: `0.4.1`
    - Package version: `2.1.1`
    - Generator version: `7.6.0`
- Build package: `org.openapitools.codegen.languages.PhpClientCodegen`
