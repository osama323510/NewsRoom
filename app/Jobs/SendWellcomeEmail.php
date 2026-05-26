<?php

namespace App\Jobs;

use App\Mail\WellcomeMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendWellcomeEmail implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public int $tries = 3;
    public int $backoff = 10;
    public $email;
    public $name;
    public function __construct($name, $email)
    {
        $this->name =$name;
        $this->email =$email;
        $this->onQueue('low');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->email)->send(new WellcomeMail($this->name));
    }
    public function failed(\Throwable $exception): void
    {
        Log::error("Job failed permanently for email {$this->email}: {$exception->getMessage()}");
    }
}
