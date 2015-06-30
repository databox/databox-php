# Databox bindings for PHP

The PHP SDK for interacting with the [Databox](http://databox.com) Push API.

## Requirements

* PHP >= 5.4
* PHPUnit for development

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
        "databox/databox-php": "*"
    },
    "minimum-stability": "dev"
}
```

`databox-php` follows the PSR-4 convention names for its classes, which means you can easily integrate `databox-php` classes loading in your own autoloader.

## Basic example

```php
<?php

$loader = require __DIR__ . "/./vendor/autoload.php";

use Databox\Client;

$c = new Client("<push_token>");

$ok = $c->push("sales", 203);
if($ok) echo "Inserted,...";

$c->insertAll([
    ["sales", 203],
    ["sales", 103, "2015-01-01 17:00:00"],

]);

print_r(
    $c->lastPush(2)
);

```

## Documentation

See the `doc` directory for more detailed documentation. 

## License

`databox-php` is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Credits & contributors

- [Jakob Murko aka. sraka1](http://github.com/sraka1)
- [Uroš Majerič](http://github.com/umajeric) 
- [Oto Brglez](https://github.com/otobrglez)