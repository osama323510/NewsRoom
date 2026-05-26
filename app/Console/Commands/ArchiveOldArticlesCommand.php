<?php

namespace App\Console\Commands;

use App\Services\Command\CommandService;
use Carbon\Carbon;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;


class ArchiveOldArticlesCommand extends Command
{
    /**
     * Execute the console command.
     */
    protected $signature = 'articles:archive {days? : The number of days to look back}';
    protected $description = 'Archive articles that have not been published and are older';

    public function handle(CommandService $service)
    {

        $days = $this->argument('days') ?? 30;
        $targetDate = Carbon::now()->subDays($days);
        $count=$service->archive($days)?? 0;
        $this->info("Successfully archived {$count} articles older than {$days} days.");
        return Command::SUCCESS;
    }
}
