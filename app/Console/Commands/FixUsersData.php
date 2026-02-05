<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Carbon\Carbon;

class FixUsersData extends Command
{
    protected $signature = 'fix:users-data';
    protected $description = 'Fix missing user data like created_at and status';

    public function handle()
    {
        $this->info('Fixing user data...');
        
        // Fix created_at NULL
        $createdAtFixed = User::whereNull('created_at')->count();
        User::whereNull('created_at')->update(['created_at' => Carbon::now()]);
        $this->info("Fixed {$createdAtFixed} users with NULL created_at");
        
        // Fix status NULL
        $statusFixed = User::whereNull('status')->count();
        User::whereNull('status')->update(['status' => 'active']);
        $this->info("Fixed {$statusFixed} users with NULL status");
        
        // Fix updated_at NULL
        $updatedAtFixed = User::whereNull('updated_at')->count();
        User::whereNull('updated_at')->update(['updated_at' => Carbon::now()]);
        $this->info("Fixed {$updatedAtFixed} users with NULL updated_at");
        
        $this->info('Done!');
        
        // Show summary
        $this->table(
            ['ID', 'Name', 'Email', 'Role', 'Status', 'Created At'],
            User::all()->map(function($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'status' => $user->status ?? 'NULL',
                    'created_at' => $user->created_at ? $user->created_at->format('Y-m-d H:i:s') : 'NULL'
                ];
            })->toArray()
        );
    }
}