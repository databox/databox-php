# Databox bindings for PHP

[![Build Status][travis-badge]][travis]
[![StyleCI][styleci-badge]][styleci]

The PHP SDK for interacting with the [Databox](http://databox.com) Push API.

## Requirements

* PHP >= 5.4 with [cURL](http://php.net/manual/en/book.curl.php) extension,
* [Guzzle](https://github.com/guzzle/guzzle) library,
* (optional) [PHPUnit](https://phpunit.de/) to run tests.

## Autoloading

`databox-php` uses [Composer](http://getcomposer.org).
The first step to use `databox-php` is to download composer:

```bash
$ curl -s http://getcomposer.org/installer | php
```

Install dependencies using:
```bash
$ php composer.phar install
```

Use autoloader from Composer by:
```json
{
    "require": {
        "databox/databox-php": "@stable"
    }
}
```

`databox-php` follows the PSR-4 convention names for its classes, which means you can easily integrate `databox-php` classes loading in your own autoloader.

## Basic example

```php
use Databox\Client;

$c = new Client('<push_token>'');

$ok = $c->push('sales', 203);
if ($ok) {
    echo "Inserted,...";
}

$c->insertAll([
    ['sales', 203],
    ['sales', 103, '2015-01-01 17:00:00'],
]);

print_r(
    $c->lastPush(2)
);

```

## Documentation

See the `doc` directory for more detailed documentation.

## License

`databox-php` is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Contributing

See the [contribute guide](CONTRIBUTE.md) for more info how to contribute.

## Credits & contributors

- [Jakob Murko](http://github.com/sraka1)
- [Uroš Majerič](http://github.com/umajeric)
- [Oto Brglez](https://github.com/otobrglez)
- [Vlada Petrovic](https://github.com/vladapetrovic)

[travis-badge]: https://secure.travis-ci.org/databox/databox-php.png
[travis]: http://travis-ci.org/databox/databox-php
[styleci-badge]: https://styleci.io/repos/37914175/shield
[styleci]: https://styleci.io/repos/37914175
