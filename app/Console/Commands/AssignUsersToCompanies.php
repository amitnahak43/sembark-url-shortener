<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class AssignUsersToCompanies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'assign:users-companies';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign users to companies by rotating between company_id 1 and 2';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        User::each(function ($user, $index) {
            $companyId = ($index % 2) + 1; // Rotate between company_id 1 and 2
            $user->company_id = $companyId;
            $user->save();
            $this->info("User ID {$user->id} assigned to Company ID {$companyId}");
        });

        $this->info('All users have been assigned to companies.');
    }
}
