<?php

require __DIR__ . '/vendor/autoload.php';

$client = new Predis\Client('tcp://redis:6379');
$client->connect();
for ($i = 0; $i < 10; $i++) {
    $id = $client->incr('counter');
    echo("Next user id is:{$id}\n");
}
