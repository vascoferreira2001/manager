<?php
namespace App\Libraries;

class Queue
{
    protected string $driver;
    protected $client;

    public function __construct()
    {
        $this->driver = getenv('QUEUE_DRIVER') ?: ($_ENV['QUEUE_DRIVER'] ?? 'sync');
        if ($this->driver === 'redis') {
            $host = getenv('REDIS_HOST') ?: ($_ENV['REDIS_HOST'] ?? '127.0.0.1');
            $port = getenv('REDIS_PORT') ?: ($_ENV['REDIS_PORT'] ?? 6379);
            $this->client = new \Redis();
            $this->client->connect($host, $port);
        }
    }

    public function push(string $jobClass, array $payload): bool
    {
        $item = json_encode(['job' => $jobClass, 'payload' => $payload, 'created_at' => time()]);
        if ($this->driver === 'redis') {
            return (bool)$this->client->lPush('queue:default', $item);
        }
        // sync fallback: execute immediately (useful for dev)
        $this->runSync($jobClass, $payload);
        return true;
    }

    public function pop(): ?array
    {
        if ($this->driver === 'redis') {
            $raw = $this->client->rPop('queue:default');
            if (!$raw) return null;
            return json_decode($raw, true);
        }
        return null;
    }

    protected function runSync(string $jobClass, array $payload)
    {
        if (class_exists($jobClass)) {
            $job = new $jobClass();
            if (method_exists($job, 'handle')) {
                $job->handle($payload);
            }
        }
    }
}
