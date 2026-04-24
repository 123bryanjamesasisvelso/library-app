<?php

namespace App\Console\Commands;

use App\Services\FineService;
use Illuminate\Console\Command;

class ProcessOverdueFines extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fines:process-overdue
                            {--dry-run : Show what would be processed without making changes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process and calculate fines for all overdue books. Can be run via scheduler.';

    /**
     * Create a new command instance.
     */
    public function __construct(protected FineService $fineService)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Processing overdue fines...');

        if ($this->option('dry-run')) {
            $this->info('Running in DRY RUN mode - no changes will be made.');
        }

        if (! $this->option('dry-run')) {
            $finesCreated = $this->fineService->processAllOverdueFines();
            $this->info("✓ Successfully processed {$finesCreated} new fines.");
        } else {
            $this->info('Dry run completed.');
        }

        return Command::SUCCESS;
    }
}
