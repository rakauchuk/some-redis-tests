<?php

require __DIR__ . '/vendor/autoload.php';

use Predis\Client as PredisClient;

$client = new PredisClient();
$client->connect();

// synchronized code block
$key = 'lock';
if (getLock($client, $key)) {
    echo "Lock acquired\n";

    // do something useful here
    sleep(1);

    // release the lock
    $client->del([$key]);
} else {
    echo("Failed to acquire lock\n");
}

/**
 * Acquire a lock, notice use of NX parameter
 * @param PredisClient $client
 * @param string $key
 * @return bool
 */
function getLock(PredisClient $client, $key)
{
    // attempts to acquire a lock and
    for ($i = 0; $i < 3; $i++) {
        $lock = $client->set($key, time(), 'EX', 3, 'NX');
        if ($lock) {
            return true;
        }

        // use exponential back-off when retrying
        usleep(100 * ($i + 1));
    }

    return false;
}