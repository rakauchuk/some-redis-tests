<?php

require __DIR__ . '/vendor/autoload.php';

$client = new Predis\Client('tcp://redis:6379');
$client->connect();

// wait for messages on channel and print them on screen
echo("Waiting for messages on channel.\n");
$loop = $client->pubSubLoop();
$loop->subscribe("channel");
foreach ($loop as $message) {
    if ($message->kind == "message") {
        echo("Received: {$message->payload}\n");
        $loop->unsubscribe("channel");
    }
}
