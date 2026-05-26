<?php

namespace App\Services\Command;

use App\contract\ArticleRepositoryInterface;
use App\contract\UserRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CommandService
{
    /**
     * Create a new class instance.
     */
    protected $articleRepository;
    protected $userRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        ArticleRepositoryInterface $articleRepository)
    {
        $this->articleRepository = $articleRepository;
        $this->userRepository = $userRepository;
    }
    
    public function archive($days)
    {
        return $this->articleRepository->archive($days);
    }

    public function report()
    {
        $writersReport=$this->userRepository->report();
        $data = [];
        $logMessage = "Monthly Published Articles Report (" . Carbon::now()->format('F Y') . "):\n";
        foreach ($writersReport as $writer) {
            $data[] = [
                $writer->name,
                $writer->email,
                $writer->articles_count
            ];

            $logMessage .= "- Writer: {$writer->name} ({$writer->email}) | Total: {$writer->articles_count}\n";
        }
        return [
            'data'        => $data,
            'logMessage'  => $logMessage
        ];

    }

}
