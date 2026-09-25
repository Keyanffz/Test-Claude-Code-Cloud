<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(PortfolioSeeder::class);

        // A known login is convenient locally and a liability anywhere else;
        // production accounts are created with `php artisan admin:create`.
        if (app()->isLocal()) {
            User::query()->firstOrCreate(
                ['email' => 'admin@example.com'],
                ['name' => 'Admin', 'password' => 'password'],
            );
            $this->command?->info('Local admin: admin@example.com / password');
        }
    }
}
