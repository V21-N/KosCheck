<?php

namespace App\Services;

use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Log;

class QueueService
{
    protected string $connection;
    protected bool $redisAvailable = false;

    public function __construct()
    {
        $this->connection = config('queue.default');
        $this->checkRedisAvailability();
    }

    protected function checkRedisAvailability(): void
    {
        try {
            if ($this->connection === 'redis') {
                Redis::ping();
                $this->redisAvailable = true;
            }
        } catch (\Exception $e) {
            $this->redisAvailable = false;
            Log::warning('Redis not available, falling back to database queue', [
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function dispatch($job): void
    {
        dispatch($job);
    }

    public function dispatchSync($job): void
    {
        dispatch_sync($job);
    }

    public function dispatchAfterCommit($job): void
    {
        dispatch($job)->afterCommit();
    }

    public function dispatchToQueue(string $queue, $job): void
    {
        dispatch($job)->onQueue($queue);
    }

    public function dispatchDelayed(\DateTimeInterface $delay, $job): void
    {
        dispatch($job)->delay($delay);
    }

    public function getQueueStats(): array
    {
        $stats = [
            'connection' => $this->connection,
            'redis_available' => $this->redisAvailable,
            'pending_jobs' => 0,
            'failed_jobs' => 0,
        ];

        if ($this->connection === 'database') {
            $stats['pending_jobs'] = \DB::table('jobs')->count();
            $stats['failed_jobs'] = \DB::table('failed_jobs')->count();
        } elseif ($this->connection === 'redis' && $this->redisAvailable) {
            try {
                $stats['pending_jobs'] = Redis::llen('queues:default');
            } catch (\Exception $e) {
                $stats['error'] = $e->getMessage();
            }
        }

        return $stats;
    }

    public function flushFailedJobs(): int
    {
        return \DB::table('failed_jobs')->delete();
    }

    public function retryFailedJob(string $uuid): bool
    {
        try {
            $job = \DB::table('failed_jobs')->where('uuid', $uuid)->first();
            if ($job) {
                $this->dispatchSync(unserialize($job->payload));
                \DB::table('failed_jobs')->where('uuid', $uuid)->delete();
                return true;
            }
        } catch (\Exception $e) {
            Log::error('Failed to retry job', ['uuid' => $uuid, 'error' => $e->getMessage()]);
        }
        return false;
    }

    public function switchToRedis(): bool
    {
        if (!$this->redisAvailable) {
            return false;
        }

        config(['queue.default' => 'redis']);
        config(['queue.connections.redis.retry_after' => 90]);
        $this->connection = 'redis';

        return true;
    }

    public function switchToDatabase(): void
    {
        config(['queue.default' => 'database']);
        $this->connection = 'database';
    }

    public function isUsingRedis(): bool
    {
        return $this->connection === 'redis' && $this->redisAvailable;
    }

    public function isUsingDatabase(): bool
    {
        return $this->connection === 'database';
    }
}
