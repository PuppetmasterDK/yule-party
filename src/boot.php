<?php

require __DIR__ . '/../vendor/autoload.php';

$yule = new \Lutzen\Models\YuleDate(\Carbon\Carbon::now());

echo "Hello: " + $yule->getYulePartyDate()->toDateTimeString() . PHP_EOL;