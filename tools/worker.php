<?php
// tools/worker.php
require __DIR__ . '/../vendor/autoload.php';

use App\Libraries\Queue;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad();

$queue = new Queue();
echo "Worker started (driver: " . ($_ENV['QUEUE_DRIVER'] ?? 'sync') . ")\n";

while (true) {
    $item = $queue->pop();
    if ($item === null) {
        // sem jobs: dormir 2s
        sleep(2);
        continue;
    }
    $jobClass = $item['job'] ?? null;
    $payload = $item['payload'] ?? [];
    echo "[" . date('Y-m-d H:i:s') . "] Processing job: $jobClass\n";
    if ($jobClass && class_exists($jobClass)) {
        try {
            $job = new $jobClass();
            $job->handle($payload);
            echo "OK\n";
        } catch (Throwable $e) {
            echo "Job error: " . $e->getMessage() . "\n";
            // requeue or log as needed
        }
    } else {
        echo "Unknown job: $jobClass\n";
    }
}
