<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\NotificationHandler\Notify; 
use Illuminate\Support\Facades\Log;

class SendNewArticleNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $backoff = 10;
    
    protected $name;
    protected $title;

    public function __construct($name, $title)
    {
        $this->name = $name;
        $this->title = $title;
        
        $this->onQueue('high');
    }

    
    public function handle(Notify $notify): void
    {
        Log::info("Job started handling for title: {$this->title}");
        
        $notify->notifyAllUsers($this->name, $this->title);
    }

    public function failed(\Throwable $exception): void
    {
        Log::error("Job failed permanently for article Title {$this->title}: {$exception->getMessage()}");
    }
}