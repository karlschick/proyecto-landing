<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\CacheService;

class ClearSiteCache extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'cache:clear-site';

    /**
     * The console command description.
     */
    protected $description = 'Clear all site-specific cache (settings, services, projects, etc.)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Clearing site cache...');

        CacheService::clearAll();

        $this->info('✓ Site cache cleared successfully!');

        return Command::SUCCESS;
    }
}
