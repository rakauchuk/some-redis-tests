<?php

require __DIR__ . '/vendor/autoload.php';

$client = new Predis\Client('tcp://redis:6379');
$client->connect();

// Read input from user and send to channel
echo "Press CTRL-C to stop.\n";
while (true) {
    $message = readline("Enter a Message:");
    $client->publish('channel', $message);
    echo("Sent {$message}.\n");
}
