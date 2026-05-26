<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use App\Services\Command\CommandService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ReportArticlesCommand extends Command
{
    /**
     * Execute the console command.
     */
    protected $signature = 'articles:report';
    protected $description = 'Generate a report of all published articles with their authors and comment counts.';

    public function handle(CommandService $service)
    {
        $this->info("Generating monthly articles report...");
        $headers = ['Writer Name', 'Email', 'Published Articles This Month'];

        $reportResult = $service->report();
        $data = $reportResult['data'];
        $logMessage = $reportResult['logMessage'];
        

        $this->table($headers, $data);
        Log::info($logMessage);

        $this->info("Report logged successfully to storage/logs/laravel.log!");
        return Command::SUCCESS;
    }
}
