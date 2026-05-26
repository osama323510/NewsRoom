<?php

namespace App\Jobs;

use App\services\Tags\TagRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CacheMostUsedTagsJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public int $tries = 3;
    public int $backoff = 10;
    public function __construct()
    {
        $this->onQueue('low');
    }

    /**
     * Execute the job.
     */
    public function handle(TagRepository $tagRepository): void
    {
        $mostUsedTags = $tagRepository->getMostUsedTags(5);
        Cache::forever('dashboard_most_used_tags', $mostUsedTags);
    }
        public function failed(\Throwable $exception): void
    {
        Log::error("Job failed permanently: {$exception->getMessage()}");
    }
}
