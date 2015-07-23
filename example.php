#!/usr/bin/env php
<?php
$loader = require __DIR__ . '/./vendor/autoload.php';

use Databox\Client;

$c = new Client('adxg1kq5a4g04k0wk0s4wkssow8osw84');

$ok = $c->push('sales', 203);
if ($ok) {
    echo 'Inserted,...';
}

$c->insertAll([
    ['sales', 203],
    ['sales', 103, '2015-01-01 17:00:00'],

]);

print_r(
    $c->lastPush(2)
);
