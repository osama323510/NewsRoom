<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\WeeklyArticlesReportMail;
use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class SendWeeklyArticlesReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
    public function handle(): void
    {
        
        $weeklyArticles = Article::where('status', 'published')
            ->where('updated_at', '>=', now()->subDays(7))
            ->with('user') 
            ->get();

        
        $admins = User::where('role', 'admin')->get();

        if ($weeklyArticles->isNotEmpty() && $admins->isNotEmpty()) {
            foreach ($admins as $admin) {
                Mail::to($admin->email)->send(new WeeklyArticlesReportMail($weeklyArticles));
            }
        }
    }
    
    public function failed(\Throwable $exception): void
    {
        Log::error("Job failed  {$exception->getMessage()}");
    }
    
}
