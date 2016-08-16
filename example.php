#!/usr/bin/env php
<?php
$loader = require __DIR__ . '/./vendor/autoload.php';

use Databox\Client;

$token = getenv("DATABOX_PUSH_TOKEN");

if (!$token) {
    $token = 'adxg1kq5a4g04k0wk0s4wkssow8osw84';
}

$c = new Client($token);

$ok = $c->push('sales', rand(100, 10000));
if ($ok) {
    echo "Inserted with value,...\n";
}

$ok = $c->push('sales', rand(100, 10000), (new \DateTime('now'))->format('Y-m-d'));
if ($ok) {
    echo "Inserted with date,...\n";
}

$ok = $c->push('referal', rand(100, 10000), (new \DateTime('yesterday'))->format('Y-m-d'), [
    'country' => 'Slovenia',
    'city'    => 'Ptuj',
    'site'    => 'https://databox.com'
]);
if ($ok) {
    echo "Inserted with attributes,...\n";
}

print_r(
    $c->lastPush(3)
);

// Insert with unit
$c->insertAll([
    ['transaction', rand(100, 10000), null, null, 'USD'],
    ['transaction', rand(100, 10000), null, null, 'EUR'],
    ['transaction', rand(100, 10000), null, null, 'GBP']
]);

print_r(
    $c->lastPush()
);

// get list of metrics
print_r(
    $c->metrics()
);

// purge pushed data
print_r(
    $c->purge()
);

