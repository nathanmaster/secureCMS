<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class RefreshDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:refresh-with-seeders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh the database and run all seeders';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Refreshing database with seeders...');
        
        // Run migrations fresh
        $this->call('migrate:fresh');
        
        // Run all seeders
        $this->call('db:seed');
        
        $this->info('Database refreshed and seeded successfully!');
        
        return 0;
    }
}
