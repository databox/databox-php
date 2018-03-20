# Databox bindings for PHP

[![License](http://img.shields.io/:license-mit-blue.svg)](http://databox.mit-license.org)
[![Latest Stable Version](https://poser.pugx.org/databox/databox/v/stable)](https://packagist.org/packages/databox/databox)


The PHP SDK for interacting with the [Databox](http://databox.com) Push API.

## Requirements

* PHP >= 5.5.0 with [cURL](http://php.net/manual/en/book.curl.php) extension,
* [Guzzle](https://github.com/guzzle/guzzle) library,
* (optional) [PHPUnit](https://phpunit.de/) to run tests.

## Autoloading

`databox-php` uses [Composer](http://getcomposer.org).
The first step to use `databox-php` is to download composer:

```bash
$ curl -s http://getcomposer.org/installer | php
```

Clone the repo and install dependencies using:
```bash
$ git clone https://github.com/databox/databox-php.git && cd databox-php
$ php composer.phar install
```

Use autoloader from Composer by:
```json
{
    "require": {
        "databox/databox": "@stable"
    }
}
```

`databox-php` follows the PSR-4 convention names for its classes, which means you can easily integrate `databox-php` classes loading in your own autoloader.

## Basic example

```php
<?php
require __DIR__ . '/vendor/autoload.php';

use Databox\Client;

$c = new Client('<push_token>');

$ok = $c->push('sales', 203);
if ($ok) {
    echo 'Inserted,...';
}

$c->insertAll([
    ['sales', 203],
    ['sales', 103, '2015-01-01 17:00:00'],
]);

// Or push some attributes
$ok = $c->push('sales', 203, null, [
    'city' => 'Boston'
]);

print_r(
    $c->lastPush(3)
);

// Or push with units
$c->insertAll([
    ['transaction', 12134, null, null, 'USD'],
    ['transaction', 3245, null, null, 'EUR']
]);

```

## Documentation

See the `doc` directory for more detailed documentation.

## License

`databox-php` is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Contributing

See the [contribute guide](CONTRIBUTING.md) for more info how to contribute.

## Credits & contributors

- [Jakob Murko](http://github.com/sraka1)
- [Uroš Majerič](http://github.com/umajeric)
- [Oto Brglez](https://github.com/otobrglez)
- [Vlada Petrovic](https://github.com/vladapetrovic)
