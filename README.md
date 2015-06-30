# Databox bindings for PHP

The PHP SDK for interacting with the [Databox](http://databox.com) Push API.

## Features

* Follows PSR-4 conventions and coding standard: autoload friendly
* Built on top of a solid and extensively tested framework - Guzzle
* Tested and well-documented

## Requirements

* PHP >= 5.4
* PHPUnit for development

## Autoloading

`databox-php` uses [Composer](http://getcomposer.org).
The first step to use `databox-php-sdk` is to download composer:

```bash
$ curl -s http://getcomposer.org/installer | php
```

Then we have to install our dependencies using:
```bash
$ php composer.phar install
```
Now we can use autoloader from Composer by:

```yaml
{
    "require": {
        "databox/databox-php": "*"
    },
    "minimum-stability": "dev"
}
```

> `databox-php-sdk` follows the PSR-0 convention names for its classes, which means you can easily integrate `databox-php-sdk` classes loading in your own autoloader.

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

`databox-php-sdk` is licensed under the MIT License - see the LICENSE file for details

## Credits & contributors

- [Jakob Murko aka. sraka1](http://github.com/sraka1)
- [Uroš Majerič](http://github.com/umajeric) 
- [Oto Brglez](https://github.com/otobrglez)