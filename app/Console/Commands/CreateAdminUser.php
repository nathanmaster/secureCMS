<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-admin-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an admin user by setting the is_admin flag to true for an existing user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Create Admin User');
        $this->line('This command will find an existing user and grant them admin privileges.');
        
        // Prompt for email
        $email = $this->ask('Enter the email address of the user to make admin');
        
        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error('Invalid email format provided.');
            return Command::FAILURE;
        }
        
        // Find user by email
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            $this->error("User with email '{$email}' not found.");
            $this->line('Please make sure the user exists in the system first.');
            return Command::FAILURE;
        }
        
        // Check if user is already an admin
        if ($user->is_admin) {
            $this->warn("User '{$user->name}' ({$email}) is already an admin.");
            return Command::SUCCESS;
        }
        
        // Confirm action
        $confirmed = $this->confirm("Are you sure you want to make '{$user->name}' ({$email}) an admin?");
        
        if (!$confirmed) {
            $this->info('Operation cancelled.');
            return Command::SUCCESS;
        }
        
        // Update user to admin
        $user->is_admin = true;
        $user->save();
        
        $this->info("✅ User '{$user->name}' ({$email}) has been successfully granted admin privileges.");
        
        return Command::SUCCESS;
    }
}
