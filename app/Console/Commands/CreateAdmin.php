<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

use function Laravel\Prompts\password;
use function Laravel\Prompts\text;

class CreateAdmin extends Command
{
    protected $signature = 'admin:create
                            {--name= : Display name}
                            {--email= : Login email}
                            {--password= : Password (prompted when omitted, so it stays out of shell history)}';

    protected $description = 'Create an account that can sign in to /admin';

    public function handle(): int
    {
        $data = [
            'name' => $this->option('name') ?? text('Name', default: 'Admin', required: true),
            'email' => $this->option('email') ?? text('Email', required: true),
            'password' => $this->option('password') ?? password('Password (min. 12 characters)', required: true),
        ];

        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', Password::min(12)],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->components->error($error);
            }

            return self::FAILURE;
        }

        User::query()->create($data);

        $this->components->info("Admin {$data['email']} created. Sign in at ".route('admin.login'));

        return self::SUCCESS;
    }
}
