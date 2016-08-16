#!/usr/bin/env php
<?php
$loader = require __DIR__ . '/./vendor/autoload.php';

use Databox\Client;

$token = getenv("DATABOX_PUSH_TOKEN");

if (!$token) {
    $token = 'adxg1kq5a4g04k0wk0s4wkssow8osw84';
}

$sha = [];
$c = new Client($token);

$ok = $c->push('sales', rand(100, 10000));
if ($ok) {
    $sha[] = $ok;
    echo "Inserted with value,...\n";
}

$ok = $c->push('sales', rand(100, 10000), (new \DateTime('now'))->format('Y-m-d'));
if ($ok) {
    $sha[] = $ok;
    echo "Inserted with date,...\n";
}

$ok = $c->push('referal', rand(100, 10000), (new \DateTime('yesterday'))->format('Y-m-d'), [
    'country' => 'Slovenia',
    'city'    => 'Ptuj',
    'site'    => 'https://databox.com'
]);
if ($ok) {
    $sha[] = $ok;
    echo "Inserted with attributes,...\n";
}

echo "\nGet last 3 pushes\n",
    json_encode($c->lastPush(3)),
    "\n";

// get pushes
echo "\nGet last push with ::getPush\n",
    json_encode($c->getPush(end($sha))),
    "\n";

echo "\nGet last 3 pushes with ::getPush\n",
    json_encode($c->getPush($sha)),
    "\n";

// Insert with unit
$c->insertAll([
    ['transaction', rand(100, 10000), null, null, 'USD'],
    ['transaction', rand(100, 10000), null, null, 'EUR'],
    ['transaction', rand(100, 10000), null, null, 'GBP']
]);

echo "\nGet last push with ::lastPush\n",
    json_encode($c->lastPush()),
    "\n";

echo "\nGet list of metrics\n",
    json_encode($c->metrics()),
    "\n";

echo "\nPurge pushed data\n",
    json_encode($c->purge()),
    "\n";
